<?php

namespace harmonic\InertiaTable;

use Illuminate\Database\Eloquent\Model;
use harmonic\InertiaTable\Traits\InertiaTable;

class InertiaModel extends Model {
    use InertiaTable;

    public function resolveRouteBinding($value) {
        return $this->where('id', $value)->withTrashed()->first() ?? abort(404);
    }
}
