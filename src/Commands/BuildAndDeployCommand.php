<?php

namespace JakGH\LaravelGHDeploy\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\confirm;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;

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
        
        $url  = config( self::CONFIGKEY. 'production_url' );       

        if( empty( $url ) )
        {
            $this->warn( 'Nessuna configurazione per invocare lo script sul server di produzione' );

            return;
        }

        $target_url = config( self::CONFIGKEY. 'url' )."/gh/pull-command/" . config( self::CONFIGKEY. 'secret_code' );
      
        if ( confirm('Vuoi eseguire il pull dal server?') ) {

            $response = Http::withoutVerifying()->get( $target_url );

            $this->info( $response->body() );
        

        }else {

            $this->info('Completato');
        }


    }
    /*
    /* Build with NPM
    */
    private function npm()
    {
        if ( confirm('Vuoi eseguire NPM RUN BUILD?') ) {

            $result = Process::run('npm run build', function (string $type, string $output) {
              
                $this->info( $output );

            });     
            
            if ($result->successful()) {
                
                $this->line('<bg=green;fg=white> Build dei file js completata </>');
            }

            return;

        }

        $this->warn('NPM RUN BUILD saltato');
         
    }
    /*
    /* Push to git
    */
    private function git()
    {
        if ( confirm('Vuoi eseguire il push della repo?') ) {

            Process::run('git add .', function (string $type, string $output) {
              
                $this->info( $output );

            });            

            $commit = text(
                label: 'Messaggio del commit?',
                placeholder: 'Fix errori css',
                default: 'push',
                hint: 'Il messaggio mostrato come descrizione del commit'
            );

            $result = Process::run("git commit -m '". $commit ."' && git push", function (string $type, string $output) {
              
                $this->info( $output );

            }); 

            if ($result->successful()) {
                
                $this->line('<bg=green;fg=white> Push completato </>');
            }

            return;

        }
    }
}
