<?php

namespace App\Console\Commands\Imports;

use App\Interfaces\Silex;
use App\Models\Event;
use App\Models\Events\Picture;
use App\Traits\RocketChat;
use Carbon\Carbon;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SilexCommand extends Command implements Silex
{
    use \App\Traits\Silex, RocketChat;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:silex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe les événements du Silex via Weezevent';

    /**
     * @var DOMXPath
     */
    private $_dom;

    private $_place;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->_place = $this->_getPlace();
        $this->_getDom()->_saveEvents();
    }

    /**
     * Récupère le DOM.
     *
     * @return $this
     */
    private function _getDom()
    {
        $html = file_get_contents(self::WEEZEVENT_URL);

        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $this->_dom = new DOMXPath($dom);

        return $this;
    }

    /**
     * Converti une chaine de date(s) en date de début / fin.
     *
     * @param $date
     *
     * @return array
     */
    private function _convertDate($date)
    {
        $return = ['start' => null, 'end' => null];
        if (strpos($date, 'à') !== false) {
            $dates = explode('à', $date);
            $return['start'] = Carbon::createFromFormat('d/m/Y \- H:i ', $dates[0]);
            $return['end'] = Carbon::createFromFormat('d/m/Y \- H:i', $return['start']->format('d/m/Y \- ') . $dates[1]);
        } else {
            $return['start'] = Carbon::createFromFormat('d/m/Y \- H:i', $date);
        }

        return $return;
    }

    /**
     * @return $this
     */
    private function _saveEvents()
    {
        $events = $this->_dom->query(self::XPATH_EVENTS);
        foreach ($events as $event) {
            /* @var DOMElement $event */
            $date = $this->_dom->query($event->getNodePath() . '/div[@class="event_fiche"]/div[@class="event_date"]')->item(0)->nodeValue;
            if ($date == '') {
                continue;
            }

            $dates = $this->_convertDate($date);

            $img = $this->_dom->query($event->getNodePath() . '/img')->item(0)->getAttribute('src');

            $title = $this->_dom->query($event->getNodePath() . '/div[@class="event_fiche"]/div[@class="event_titre"]/h1')->item(0)->nodeValue;
            $place = $this->_dom->query($event->getNodePath() . '/div[@class="event_fiche"]/div[@class="event_info"]')->item(0)->nodeValue;
            $link = $this->_dom->query($event->getNodePath() . '/div[@class="event_droite"]/a')->item(0)->getAttribute('href');

            $e = Event::updateOrCreate([
                'name' => $title,
                'start' => $dates['start'],
            ], [
                'place_id' => $this->_place->id,
                'link' => $link,
                'end' => $dates['end'],
                'description' => $place,
                'premium' => 1,
                'confirm' => new \DateTime(),
            ]);

            if ($e->wasRecentlyCreated) {
                $this->output->writeln('Event ' . $e->name . ' created');

                // On télécharge l'image
                if (Storage::put('silex/' . str_slug($e->name) . '.jpg', file_get_contents($img))) {
                    Picture::insert([
                       'path' => 'silex/' . str_slug($e->name) . '.jpg',
                       'event_id' => $e->id,
                    ]);
                }

                $this->sendToRocketChat([
                    'text' => 'Ajout d\'un nouvel événement',
                    'attachments' => [
                        [
                            'color' => '#05b8c7',
                            'author_name' => 'Le Silex',
                            'title' => $e->name,
                            'image_url' => Storage::url('silex/' . str_slug($e->name) . '.jpg'),
                            'title_link' => $e->link,
                            'text' => trans('silex.event.start') . ' ' . $e->start->isoFormat('dddd D MMMM Y') . ' ' . trans('silex.event.at') . ' ' . $e->start->format('H:i'),
                        ],
                    ],
                ]);
            }
        }

        return $this;
    }
}
