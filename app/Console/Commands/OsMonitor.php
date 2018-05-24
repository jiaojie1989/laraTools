<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OsMonitor extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'os:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show current CPU frequency & Temperuature';

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
        $output = '';

        $sensor = new \Symfony\Component\Process\Process('sensors');
        $sensor->start();
        while ($sensor->isRunning()) {
            
        }
        $sensorOutput = $sensor->getOutput();
        foreach (explode("\n", $sensorOutput) as $line) {
            if (false !== strpos($line, "Core")) {
                $output .= $line . "\n";
            }
        }
        $cpu = new \Symfony\Component\Process\Process(['cat', '/proc/cpuinfo']);
        $cpu->start();
        while ($cpu->isRunning()) {
            
        }
        $cpuOutput = $cpu->getOutput();
        foreach (explode("\n", $cpuOutput) as $line) {
            if (false !== strpos($line, "MHz")) {
                $output .= $line . "\n";
            }
        }

        $nod = new \Nod\Notification();
        $nod->setTitle("CPU Monitor")
                ->setMessage($output)
                ->setExpiry(10000)
                ->setIcon('/usr/share/icons/elementary-xfce/devices/64/processor.png')
                ->send();
    }

}
