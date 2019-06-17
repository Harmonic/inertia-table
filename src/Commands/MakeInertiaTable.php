<?php

namespace harmonic\InertiaTable\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class MakeInertiaTable extends Command
{
    use \Illuminate\Console\DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:inertiaTable {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates scaffolding for an inertia JS table';

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
        $model = $this->argument('model');

        // Create Model
        $str = file_get_contents(__DIR__ . '/../Stubs/Model.php');
        $str = str_replace("@namespace", substr($this->getAppNamespace(), 0, -1), $str);
        $str = str_replace("@modelName", $model, $str);
        file_put_contents(app_path($model . '.php'), $str);

        // Create Controller
        $controllerName = Str::plural($model) . 'Controller';
        $str = file_get_contents(__DIR__ . '/../Stubs/Controller.php');
        $str = str_replace("@namespace", substr($this->getAppNamespace(), 0, -1), $str);
        $str = str_replace("@controllerName", $controllerName, $str);
        $str = str_replace("@modelName", $model, $str);
        file_put_contents(app_path('Http/Controllers/' . $controllerName . '.php'), $str);

        //TODO: Create a InertiaTable.vue component and then create Index.vue using it
        $this->info('Model, Controller and Vue Components successfully created.');
    }
}
