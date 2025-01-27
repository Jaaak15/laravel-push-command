<?php

namespace JakGH\LaravelGHDeploy\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class PullFromRepository extends Command
{  
    protected $signature    = 'gh:pull {code}';
    protected $description  = 'Pull from repository';
    
    const CONFIGKEY         = 'jakgh.deploy_command.';

    public function handle()
    {   

        $code = $this->argument('code');

        if( $code != config( self::CONFIGKEY. 'secret_code' ) ) 
        {
            $this->info( "Code mismatch" );

            return; 
        }

        $result = Process::run("git pull", function (string $type, string $output) {
              
            $this->info( $output );

        }); 

        if ($result->successful()) {
            
            $this->line('<bg=green;fg=white> Pull eseguito </>');
        }

        return;
    }
    
}
