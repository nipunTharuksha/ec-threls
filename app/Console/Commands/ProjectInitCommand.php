<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProjectInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializes things from ground level';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('migrate:fresh', ['--seed' => true]);
        $this->info(Artisan::output());
        Artisan::call('passport:install');
        $this->info(Artisan::output());

        $this->newLine();
        $this->info('Initial user information');

        $this->table(['email', 'password'],[['admin@threls.com','password'],['user@threls.com','password']]);

    }
}
