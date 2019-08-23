<?php

namespace Japazera\LaravelAdmin\Commands;

use Illuminate\Console\Command;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {migration} {model} {--routes} {--nav}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD views, controller and model from migration.';

    protected $migration_name;
    protected $model_name;
    protected $model_name_lower;
    protected $field_names;
    protected $field_types;
	protected $template_dir = __DIR__ . '/../Templates/';

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
        // catch arguments
        $this->migration_name = $this->argument('migration');
        $this->model_name = $this->argument('model');
        $this->model_name_lower = strtolower($this->model_name);

        // find migration file
        $migration_files = scandir(base_path('database/migrations'));
        $migration_file = null;

        // loop migration files
        foreach($migration_files as $key => $filename) {
            //find the migration name in string
            if(strpos($filename, $this->migration_name) !== false) {
                // set migration file
                $migration_file = base_path('database/migrations/' . $filename);
            }
        }

        // check if migration file exists
        if(file_exists($migration_file)) {
            echo 'Migration file exists.' . PHP_EOL;
        } else {
            echo 'Migration file does not exist.' . PHP_EOL;
            return;
        }

        $migration_content = file_get_contents($migration_file);

        // find fields in migration content
        preg_match_all('/\$table->(.*)\(\'(.*)\'\)/m', $migration_content, $matches, PREG_SET_ORDER, 0);

        // tirando id
        array_shift($matches);

        // set field names and types to object
        $this->field_names = array_column($matches, 2);
        $this->field_types = array_column($matches, 1);

        // append routes
        if($this->option('routes')) {
            $this->appendRoutes();
        }

        // append routes
        if($this->option('nav')) {
            $this->appendNav();
        }

        // create model file
        $this->replaceAndExportFile('crud/', 'Model.php', "app/", "$this->model_name.php");

        // create controller
        $this->replaceAndExportFile('crud/', 'ModelController.php', "app/Http/Controllers/", $this->model_name . "Controller.php");

        // create view index
        $this->replaceAndExportFile('crud/model/', 'index.blade.php', "resources/views/admin/$this->model_name_lower/", 'index.blade.php');

        // create view create
        $this->replaceAndExportFile('crud/model/', 'create.blade.php', "resources/views/admin/$this->model_name_lower/", 'create.blade.php');

        // create view edit
        $this->replaceAndExportFile('crud/model/', 'edit.blade.php', "resources/views/admin/$this->model_name_lower/", 'edit.blade.php');

        // create tests
        $this->replaceAndExportFile('crud/', 'ModelTest.php', 'tests/Feature/', $this->model_name . 'Test.php');
    }

    protected function printTabs($n)
    {
        $result = "";
        for($i = 0; $i < $n; $i++) {
            $result .= "\t";
        }
        return $result;
    }

    protected function createPathIfNotExist($path)
    {
        if(!file_exists($path)) {
            mkdir($path, 0777);
        }
    }

    protected function replaceAndExportFile($path_src, $file_src, $path_dst, $file_dst)
    {
        // read template
        $template = file_get_contents($this->template_dir . '/' . $path_src . $file_src);

        // replace placeholders
        $template = $this->replacePlaceholders($template);

        $this->createPathIfNotExist($path_dst);

		// confirm replacement if file exists
        if(file_exists($path_dst . $file_dst)) {
            $replace = $this->ask($path_dst . $file_dst .  ' already exists. Replace? (y/n) : [y]');

            if($replace == 'n') {
                echo $path_dst . $file_dst . ' skipped' . PHP_EOL . PHP_EOL;
                return;
            }
        }

        // write file
        file_put_contents($path_dst . $file_dst, $template);
        echo $path_dst . $file_dst . ' created' . PHP_EOL . PHP_EOL;
    }

    protected function replacePlaceholders($template)
    {
        // model
        $template = str_replace('[FIELD_NAMES]', $this->printFieldNamesForModel(), $template);

        // controller
        $template = str_replace('[MODEL]', $this->model_name, $template);
        $template = str_replace('[MODEL_LOWER]', $this->model_name_lower, $template);
        $template = str_replace('[FIELDS_VALIDATION]', $this->printFieldNamesValidation(), $template);

        // index
        $template = str_replace('[FIELDS_TH]', $this->printFieldNamesTh(), $template);
        $template = str_replace('[FIELDS_TD]', $this->printFieldNamesTd(), $template);

        // create
        $template = str_replace('[MODEL]', $this->model_name, $template);
        $template = str_replace('[MODEL_LOWER]', $this->model_name_lower, $template);
        $template = str_replace('[FIELDS_FORM_GROUP_CREATE]', $this->printFieldNamesFromGroupCreate(), $template);

        // edit
        $template = str_replace('[FIELDS_FORM_GROUP_EDIT]', $this->printFieldNamesFromGroupEdit(), $template);

        // test
        $template = str_replace('[MODEL]', $this->model_name, $template);
        $template = str_replace('[FIELD_NAME_STORE]', $this->printFieldNamesForStore(), $template);
        $template = str_replace('[FIELD_NAME_UPDATE]', $this->printFieldNamesForUpdate(), $template);
        $template = str_replace('[FIELD_NAME_FIRST]', $this->field_names[0], $template);

        return $template;
    }

    public function printFieldNamesForStore($tabs = 3)
    {
        $result = "";
        foreach($this->field_names as $field_name) {
            $result .= $this->printTabs($tabs);
            $result .= "'$field_name' => '$field_name'," .PHP_EOL;
        }
        return $result;
    }

    public function printFieldNamesForUpdate($tabs = 3)
    {
        $result = "";
        foreach($this->field_names as $field_name) {
            $result .= $this->printTabs($tabs);
            $result .= "'$field_name' => '". $field_name ."1'," .PHP_EOL;
        }
        return $result;
    }


    protected function printFieldNamesForModel($tabs = 2)
    {
        $result = "";
        foreach($this->field_names as $field_name) {
            $result .= $this->printTabs($tabs);
            $result .= "'$field_name'," .PHP_EOL;
        }
        return $result;
    }

    protected function printFieldNamesValidation($tabs = 3)
    {
        $result = "";
        foreach($this->field_names as $field_name) {
            $result .= $this->printTabs($tabs);
            $result .= "'$field_name' => 'required'," .PHP_EOL;
        }
        return $result;
    }


    protected function printFieldNamesTh($tabs = 8)
    {
        $result = "";
        foreach ($this->field_names as $field_name) {
            $result .= $this->printTabs($tabs);
            $result .= "<th>$field_name</th>" .PHP_EOL;
        }
        return $result;
    }

    protected function printFieldNamesTd($tabs = 8)
    {
        $result = "";
        foreach ($this->field_names as $field_name) {
            $result .= $this->printTabs($tabs);
            $result .= "<td>{{\$item->".$field_name."}}</td>" .PHP_EOL;
        }
        return $result;
    }

    protected function printFieldNamesFromGroupCreate($tabs = 6)
    {
        $fieldgroup_template = file_get_contents($this->template_dir . 'crud/model/fieldgroup_create.php');
        $fieldgroup_template = str_replace('[MODEL_LOWER]', $this->model_name_lower, $fieldgroup_template);

        $result = "";
        foreach ($this->field_names as $field_name) {
            $result .= $this->printTabs($tabs);
            $result .= str_replace('[FIELD_NAME]', $field_name, $fieldgroup_template);
        }
        return $result;
    }

    protected function printFieldNamesFromGroupEdit($tabs = 6)
    {
        $fieldgroup_template = file_get_contents($this->template_dir . 'crud/model/fieldgroup_edit.php');
        $fieldgroup_template = str_replace('[MODEL_LOWER]', $this->model_name_lower, $fieldgroup_template);

        $result = "";
        foreach ($this->field_names as $field_name) {
            $result .= $this->printTabs($tabs);
            $result .= str_replace('[FIELD_NAME]', $field_name, $fieldgroup_template);
        }
        return $result;
    }

    protected function appendRoutes()
    {
        $path = 'routes/';
        $file_dst = 'web.php';

        // resource model
        file_put_contents(base_path($path. $file_dst), "Route::resource('admin/$this->model_name_lower', '".$this->model_name."Controller');".PHP_EOL , FILE_APPEND | LOCK_EX);
        echo $path. $file_dst . " -> Route::resource('admin/$this->model_name_lower') appended" . PHP_EOL;
    }

    protected function appendNav()
    {
        $path = 'resources/views/admin/';
        $file_dst = 'nav.blade.php';

        $template = "<li class=\"nav-item\">" . PHP_EOL;
        $template .= "\t<a class=\"nav-link\" href=\"{{route('$this->model_name_lower.index')}}\">$this->model_name</a>" . PHP_EOL;
        $template .= "</li>" . PHP_EOL;

        // append to nav
        file_put_contents(base_path($path. $file_dst), $template , FILE_APPEND | LOCK_EX);

        echo $path . $file_dst . ' -> nav link appended' . PHP_EOL;
    }
}
