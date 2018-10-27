<?php

namespace App\Console\Commands\Images;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Pollutant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:pollutant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère l\'image sur les polluants';

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
        $process = new Process('phantomjs ' . app_path() . '/../resources/js/phantomjs.js' . ' ' . env('APP_URL') . '/images/pollutants/gauges 750 750 ' . storage_path('app/public/pollutants') . '/' . date('Y-m-d') . '.png true');
        $process->run();
    }
}
