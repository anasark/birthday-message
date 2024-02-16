<?php

use App\Models\User;
use Carbon\Carbon;
use Igaster\LaravelCities\Geo;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $list = ['total' => 0];
    
    foreach (User::getTimezone() as $tz) {
        $data              = User::getBirthday($tz);
        $list['list'][$tz] = [
            'total' => count($data),
            'data'  => $data
        ];

        $list['total'] = $list['total'] + count($data);
    }

    return $list;

    

    return 'Hello World!';
});
