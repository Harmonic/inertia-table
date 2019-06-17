<?php

namespace @namespace\Http\Controllers;

use harmonic\InertiaTable\Facades\InertiaTable;
use @namespace\@modelName;

class @controllerName extends Controller {
	public function index() {
        $model = new @modelName();
		return InertiaTable::index($model);
	}
}