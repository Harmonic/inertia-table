# Inertia Table

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Easily create tables using InertiaJS (and Tailwind CSS) and Laravel Models. Tables can be filtered and sorted.
Can scaffold an entire model with one artisan command!

[![Laravel Preset - Click for video](https://github.com/Harmonic/laravel-preset/raw/master/docs/laravel-preset-screenshot.png)](https://www.youtube.com/watch?v=K_d_RboHBbI&feature=youtu.be)

## Installation

This package requires InertiaJS to be installed in your project.
**It is strongly recommended that you also install to corresponding Vue component [inertia-table-vue](https://github.com/Harmonic/inertia-table-vue) to allow end to end scaffolding of an Inertia table in Vue **

Via Composer

``` bash
$ composer require harmonic/inertia-table
```

## Usage

### Via CLI

The quickest and easiest way to create an Inertia Table is using a single Artisan command. It will create the model, controller and Vue components for you automatically simply by supplying a model name as an argument.

``` bash
$ php artisan make:inertiaTable User
```
Where User is the name of the model you wish to create. See the manual process below for what is created.

### Manually

1) Modify your model so that it extends InertiaModel instead of model:

``` php
use harmonic\InertiaTable\InertiaModel;

class user extends InertialModel {
    protected $perPage = 10; // Controlls number of items per page
...
```

2) Create a controller:

UsersController.php
``` php 
namespace App\Http\Controllers;

use harmonic\InertiaTable\Facades\InertiaTable;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\User;

class UsersController extends Controller {
    public function index() {
        $user = new User();
        return InertiaTable::index($user, ['id', 'name', 'email', 'deleted_at']);
    }    
}
```
The index method takes a model and an array of column names which you wish to display as parameters. The array is optional, InertiaTable will show all columns by default.

You can also stipulate which columns can be searched by adding a third parameter, an array of column names that can be filtered. If left blank all columns are searchable.

3) You will need to create your front end. It is recommend you use [inertia-table-vue](https://github.com/Harmonic/inertia-table-vue) for Vue projects. A JS example is provided at the bottom of [that repository](https://github.com/Harmonic/inertia-table-vue).

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email craig@harmonic.com.au instead of using the issue tracker.

## Credits

- [Craig Harman][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/harmonic/inertia-table.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/harmonic/inertia-table.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/harmonic/inertia-table/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/192192722/shield

[link-packagist]: https://packagist.org/packages/harmonic/inertia-table
[link-downloads]: https://packagist.org/packages/harmonic/inertia-table
[link-travis]: https://travis-ci.org/harmonic/inertia-table
[link-styleci]: https://styleci.io/repos/192192722
[link-author]: https://github.com/harmonic
[link-contributors]: ../../contributors
