<?php

namespace @namespace\Http\Controllers;

use harmonic\InertiaTable\Facades\InertiaTable;

class @controllerNameController extends Controller {
	public function index() {
        $model = new @modelName();
		return InertiaTable::index($model);
	}
}