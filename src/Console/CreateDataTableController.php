<?php

namespace SagarYonjan\VueDatatable\Console;

use Illuminate\Console\Command;
use DataTable;

class CreateDataTableController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datatable:controller {controller} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will create the datatable controller for you';

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
        if(file_exists(base_path($this->argument('model').'.php'))) {

            if(method_exists(app($this->argument('model')), 'getTable'))
               $this->createController($this->argument('controller'), $this->argument('model'));
            else
               $this->error('Must be instance of eloquent');

        } else
            $this->error('Model not found!! Exception');

    }

    /**
     * @param $controller
     * @param $model
     */
    public  function createController($controller , $model)
    {
        if (!file_exists(base_path('app/Http/Controllers/DataTable'))) {
            mkdir(base_path('app/Http/Controllers/DataTable'));
        }

        $templateDirectory = __DIR__ . '/../stubs';
        $md = file_get_contents($templateDirectory . "/controller.stub");
        $md = str_replace("__controller_class_name__", $controller, $md);
        $md = str_replace("__model_name__", $model, $md);

        file_put_contents( base_path('app/Http/Controllers/DataTable/' . $controller . ".php"), $md );
    }



}
