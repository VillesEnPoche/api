<?php

namespace App\Console\Commands;

use App\Traits\RocketChat;
use Illuminate\Console\Command;

class Optimize extends Command
{
    use RocketChat;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache the framework bootstrap files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendToRocketChat(['text' => 'Déploiement en cours.']);
        $this->call('route:cache');

        $this->info('Files cached successfully!');
    }
}
