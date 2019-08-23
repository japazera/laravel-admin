<?php

namespace Japazera\LaravelAdmin\Commands;

use Illuminate\Console\Command;
use Japazera\LaravelAdmin\Commands\Utils;

class MakeCrm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a CRM Module to Laravel Admin.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		// TODO: check if route already exist

		// resource routes
		Utils::appendRoute($this, "Route::resource('/admin/lead', 'LeadController');");
		Utils::appendRoute($this, "Route::post('/send', 'LeadController@send');");

		// nav
		Utils::appendNav($this, 'Leads', 'lead', 'fa-address-book');

		// export folders
		$templates_path = __DIR__ . "/../Templates/Crm/";
		Utils::exportFolder($this, "database",  $templates_path);
		Utils::exportFolder($this, "app",       $templates_path);
		Utils::exportFolder($this, "resources", $templates_path);
		Utils::exportFolder($this, "tests", $templates_path);

    }


}
