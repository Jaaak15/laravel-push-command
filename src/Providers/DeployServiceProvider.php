<?php

namespace JakGH\LaravelGHDeploy\Providers;

use Illuminate\Support\ServiceProvider;
use JakGH\LaravelGHDeploy\Commands\BuildAndDeployCommand;


class DeployServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerConfigurations();

        $this->commands([
            BuildAndDeployCommand::class,
        ]);
    }

    /**
     * Register the package configurations.
     *
     * @return void
     */
    protected function registerConfigurations()
    {
        $this->mergeConfigFrom( $this->packagePath('config/config.php'), 'jakgh.deploy_command' );
            $this->publishes( [ 
                $this->packagePath('config/config.php') => config_path('jakgh/deploy_command.php')
            ], 
            ['jakghdeploy'] 
        );
    }

    /**
     * Loads a path relative to the package base directory.
     *
     * @param  string  $path
     * @return string
     */
    protected function packagePath($path = '')
    {
        return sprintf('%s/../%s', __DIR__, $path);
    }
}
