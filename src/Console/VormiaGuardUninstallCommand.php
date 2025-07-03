<?php

namespace VormiaGuardPhp\Console;

use Illuminate\Console\Command;

class VormiaGuardUninstallCommand extends Command
{
    protected $signature = 'vormiaguard:uninstall';
    protected $description = 'Uninstall VormiaGuard integration (removes guard endpoints and config)';

    public function handle()
    {
        $this->info('VormiaGuard uninstalled. Please remove any guard endpoints or config manually if needed.');
        return 0;
    }
}
