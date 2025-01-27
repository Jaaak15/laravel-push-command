<?php

namespace JakGH\LaravelGHDeploy\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\confirm;

class BuildAndDeployCommand extends Command
{  
    protected $signature    = 'gh:deploy';
    protected $description  = 'Build, push and invoke pipeline';
    
    const CONFIGKEY         = 'jakgh.deploy_command.';

    public function handle()
    {
       
        $this->npm();
        $this->git();  
        $this->pipeline();

    }

    private function pipeline()
    {

    }
    /*
    /* Build with NPM
    */
    private function npm()
    {
        if ( confirm('Vuoi eseguire NPM RUN BUILD?') ) {

            $output = shell_exec('npm run build');         
            $this->info( print_r( $output, true ) );

            return;

        }

        $this->info('NPM RUN BUILD saltato');
         
    }
    /*
    /* Push to git
    */
    private function git()
    {
        if ( confirm('Vuoi eseguire il push della repo?') ) {

            $output = shell_exec('git add .');        
            $this->info( print_r( $output, true ) );

            $commit = text(
                label: 'Messaggio del commit?',
                placeholder: 'Fix errori css',
                default: 'push',
                hint: 'Il messaggio mostrato come descrizione del commit'
            );

            $output = shell_exec("git commit -m '". $commit ."'");
            $this->info( print_r( $output, true ) ); 

            $output = shell_exec('git push');        
            $this->info( print_r( $output, true ) );

            return;

        }
    }
}
