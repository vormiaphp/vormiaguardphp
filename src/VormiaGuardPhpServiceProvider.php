<?php

namespace VormiaGuardPhp;

use Illuminate\Support\ServiceProvider;
use VormiaGuardPhp\Console\VormiaGuardInstallCommand;
use VormiaGuardPhp\Console\VormiaGuardUpdateCommand;
use VormiaGuardPhp\Console\VormiaGuardUninstallCommand;

class VormiaGuardPhpServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                VormiaGuardInstallCommand::class,
                VormiaGuardUpdateCommand::class,
                VormiaGuardUninstallCommand::class,
            ]);
        }
    }
}
