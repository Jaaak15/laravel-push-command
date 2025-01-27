<?php

namespace JakGH\LaravelGHDeploy\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\confirm;

class PullFromRepository extends Command
{  
    protected $signature    = 'gh:pull';
    protected $description  = 'Pull from repository';
    
    const CONFIGKEY         = 'jakgh.deploy_command.';

    public function handle()
    {        
        
    }
    
}
