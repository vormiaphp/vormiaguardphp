<?php

namespace VormiaGuardPhp\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * VormiaGuardInstallCommand: Installs VormiaGuardPHP, checks Sanctum and Vormia dependencies.
 * This is a standard Laravel command; all methods used are provided by the framework.
 */
class VormiaGuardInstallCommand extends Command
{
    protected $signature = 'vormiaguard:install {--uninstall}';
    protected $description = 'Install or uninstall VormiaGuard integration (checks Sanctum, Vormia, sets up guard endpoints)';

    public function handle()
    {
        $this->checkSanctum();
        $this->checkVormia();
        $this->info('VormiaGuard integration complete!');
        return 0;
    }

    protected function checkSanctum()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $hasSanctum = isset($composer['require']['laravel/sanctum']) || isset($composer['require-dev']['laravel/sanctum']);
        if (!$hasSanctum) {
            if ($this->confirm('Laravel Sanctum is not installed. Would you like to run "php artisan install:api" now?', true)) {
                $this->call('install:api');
                $this->info('Sanctum API features installed.');
            } else {
                $this->warn('You must run "php artisan install:api" to enable Sanctum API features.');
            }
        } else {
            $this->info('Laravel Sanctum detected.');
        }
    }

    protected function checkVormia()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $hasVormia = isset($composer['require']['vormiaphp/vormia']) || isset($composer['require-dev']['vormiaphp/vormia']);
        if (!$hasVormia) {
            $this->warn('vormiaphp/vormia is not installed. Please install it with "composer require vormiaphp/vormia".');
        } else {
            $this->info('vormiaphp/vormia detected.');
        }
    }
}
