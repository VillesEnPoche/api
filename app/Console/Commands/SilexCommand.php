<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Events\Picture;
use App\Models\Place;
use Carbon\Carbon;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SilexCommand extends Command
{
    const WEEZEVENT_URL = 'https://www.weezevent.com/widget_multi.php?19012.1.9';

    const XPATH_EVENTS = '//body[@id=\'multiWidgetBody\']/div[@class="event "]';

    const PLACE_NAME = 'Le Silex';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'silex:import';

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
        $this->_getDom()->_getPlace()->_saveEvents();
    }

    /**
     * Récupère le lieu de l'évenement.
     *
     * @return $this
     */
    private function _getPlace()
    {
        $this->_place = Place::where('name', '=', self::PLACE_NAME)->first();
        if (is_null($this->_place)) {
            new \Exception(self::PLACE_NAME . ' not found');
        }

        return $this;
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
                if (Storage::disk('public')->put('silex/' . str_slug($e->name) . '.jpg', file_get_contents($img))) {
                    Picture::insert([
                       'path' => 'silex/' . str_slug($e->name) . '.jpg',
                       'event_id' => $e->id,
                    ]);
                }
            }
        }

        return $this;
    }
}
