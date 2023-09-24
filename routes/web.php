<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


route::group(['prefix'=>'roles'],function() {
    route::get('/showAll', 'RolesController@showPermission')->name('roles.showall');
    route::get('/', 'Controller@index')->name('roles.index');
    route::post('/store', 'RolesController@storeRole')->name('roles.store');
    route::post('/update/{id}', 'RolesController@updateRole')->name('roles.update');

});
route::post('/store', 'RolesController@storeRole')->name('roles.store');
route::post('/login', 'loginController@login')->name('login.index');
route::post('/logout', 'loginController@logout')->name('logout.index');
