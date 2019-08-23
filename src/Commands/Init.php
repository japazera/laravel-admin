<?php

namespace Japazera\LaravelAdmin\Commands;

use Illuminate\Console\Command;
use Japazera\LaravelAdmin\Commands\Utils;

class Init extends Command
{
	protected $signature = 'admin:init';
	protected $description = 'Initialize Laravel Admin';

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
		// ask to replace
		$this->question("This command export and replace many files");
		$replace = $this->ask("Do you want to continue? (y/n) : [y]");

		if($replace == 'n') {
			$this->error("Refused to replace. Aborting...");
			return;
		}

		$templates_path = __DIR__ . "/../Templates/Init/";

		Utils::exportFolder($this, "public",          $templates_path);
		Utils::exportFolder($this, "routes",          $templates_path);
		Utils::exportFolder($this, "app",             $templates_path);
		Utils::exportFolder($this, "resources/views", $templates_path);
		Utils::exportFolder($this, "tests",           $templates_path);
	}


}
