<?php

namespace harmonic\InertiaTable;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;

class InertiaTable
{
    /**
     * Generates inertia view data for model.
     *
     * @param InertiaModel $model The model to use to retrieve data
     * @param array $columns An array of column names to send to front end (null for all columns)
     * @return void
     */
    public function index(InertiaModel $model, array $columns = null)
    {
        $modelName = class_basename($model);

        if ($columns == null) { // default to all columns
            $table = $model->getTable();
            $columns = Schema::getColumnListing($table);
        }

        $modelPlural = Str::plural($modelName);

        return Inertia::render($modelPlural.'/Index', [
            'filters' => Request::all('search', 'trashed'),
            'order' => Request::all('orderColumn', 'orderDirection'),
            strtolower($modelPlural) => $model
                ->order(Request::input('orderColumn') ?? 'name', Request::input('orderDirection'))
                ->filter(Request::only('search', 'trashed'), ['name', 'email'])
                ->get()
                ->transform(function ($item) use ($columns) {
                    $data = [];
                    foreach ($columns as $column) {
                        $data[$column] = $item->$column;
                    }

                    return $data;
                }),
        ]);
    }
}
