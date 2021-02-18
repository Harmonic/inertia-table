<?php

namespace harmonic\InertiaTable\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MakeInertiaTable extends Command
{
    // use \Illuminate\Console\DetectsApplicationNamespace;

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

    private function inertiaTableJSExists()
    {
        $process = new Process('npm list --depth=0 | grep inertia-table');
        $process->run();

        // executes after the command finishes
        if (! $process->isSuccessful()) {
            if ($process->getOutput() == '') {
                return false;
            }
            $this->error('Failed looking for inertia-table JS package. Is inertia installed?');
            throw new ProcessFailedException($process);
        }

        $result = $process->getOutput();
        if (strpos($result, ' inertia-table@') !== false) {
            return true;
        }

        return false;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = ucfirst($this->argument('model'));

        if (! file_exists(app_path($model).'.php') && ! file_exists(app_path('Models\\'.$model).'.php')) {
            // Create Model
            $str = file_get_contents(__DIR__.'/../Stubs/Model.php');
            $str = str_replace('@namespace', 'App\Models', $str);
            $str = str_replace('@modelName', $model, $str);
            file_put_contents(app_path($model.'.php'), $str);
        }

        // Create Controller
        $pluralName = Str::plural($model);
        $controllerName = $pluralName.'Controller';
        $str = file_get_contents(__DIR__.'/../Stubs/Controller.php');
        $str = str_replace('@namespace', 'App\Models', $str);
        $str = str_replace('@controllerName', $controllerName, $str);
        $str = str_replace('@modelName', $model, $str);
        file_put_contents(app_path('Http/Controllers/'.$controllerName.'.php'), $str);

        // Add routes
        $this->warn('You need to manually add route: Route::inertiaTable(\''.Str::plural(strtolower($model)).'\');');

        // if ($this->inertiaTableJSExists()) {
            $pluralNameLowercase = \strtolower($pluralName);
            $modelLowercase = \strtolower($model);

            // Get column names from table
            $class = 'App\Models\\'.$model;
            $columns = Schema::getColumnListing(with(new $class)->getTable());

            // Create an InertiaTable.vue component and then create Index.vue using it
            $tableElementPath = resource_path('js/Pages/'.$pluralName);
            File::makeDirectory($tableElementPath, 0755, true);
            $str = file_get_contents(__DIR__.'/../Stubs/Index.vue');
            $str = str_replace('@pluralNameLowercase', $pluralNameLowercase, $str);
            $str = str_replace('@plural', $pluralName, $str);
            $str = str_replace('@columns', '"'.implode('","', $columns).'"', $str);
            $str = str_replace('@modelLowercase', $modelLowercase, $str);
            file_put_contents($tableElementPath.'/Index.vue', $str);
        // }

        $this->info('Model, Controller and Vue Components successfully created.');
    }
}
