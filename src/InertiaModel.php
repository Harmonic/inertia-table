<?php

namespace harmonic\InertiaTable;

use harmonic\InertiaTable\Traits\InertiaTable;
use Illuminate\Database\Eloquent\Model;

class InertiaModel extends Model
{
    use InertiaTable;

    public function resolveRouteBinding($value)
    {
        return $this->where('id', $value)->withTrashed()->first() ?? abort(404);
    }
}
