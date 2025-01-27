<?php

namespace JakGH\LaravelGHDeploy\Commands;

use Illuminate\Console\Command;

class BuildAndDeployCommand extends Command
{
    public $signature = 'gh:deploy';

    public $description = 'Deploy application to server: build, push and sh cal';

    public function handle()
    {
        $this->info('Sto facendo cose');

      
    }
}
