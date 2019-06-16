<?php

namespace harmonic\InertiaTable\Commands;

use Illuminate\Console\Command;

class MakeInertiaTable extends Command
{
    use \Illuminate\Console\AppNamespaceDetectorTrait;

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

        $modelClass = $this->getAppNamespace() . '\\' . Str::studly(Str::singular($model));
        if (!is_subclass_of($modelClass, 'Illuminate\Database\Eloquent\Model')) {
            //TODO: Instead of this CREATE the model!
            $this->error($model . ' is not a Laravel Model');
            exit();
        }
    }
}
