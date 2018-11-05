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
        $this->output->writeln('Pollution de la veille (analyse)');
        $process = new Process('phantomjs ' . app_path() . '/../resources/js/phantomjs.js' . ' ' . env('APP_URL') . '/images/pollutants/gauges 750 750 ' . storage_path('app/public/pollutants') . '/' . date('Y-m-d') . '.png true');
        $process->run();
        $this->output->writeln($process->getCommandLine());
        if (! empty($process->getErrorOutput())) {
            $this->output->error($process->getErrorOutput());
        }

        foreach (['MOYJ0', 'MOYJ1', 'MOYJ2', 'MOYJ3'] as $type) {
            $this->output->writeln('Pollution ' . $type);
            $process = new Process('phantomjs ' . app_path() . '/../resources/js/phantomjs.js' . ' "' . env('APP_URL') . '/images/pollutants/gauges?var=' . $type . '&type=prevision" 750 750 ' . storage_path('app/public/pollutants') . '/' . $type . '_' . date('Y-m-d') . '.png true');
            $process->run();
            $this->output->writeln($process->getCommandLine());
            if (! empty($process->getErrorOutput())) {
                $this->output->error($process->getErrorOutput());
            }
        }
    }
}
