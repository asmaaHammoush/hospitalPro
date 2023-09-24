<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
#############################Role##########################################
  route::group(['prefix'=>'roles'],function() {
  //  route::get('/showAll', 'RolesController@showPermission')->name('roles.showall');
    route::get('/', 'RolesController@index')->name('roles.index');
    route::post('/store', 'RolesController@storeRole')->name('roles.store');
    route::post('/update/{id}', 'RolesController@updateRole')->name('roles.update');

});
###########################register#########################################
route::group(['prefix'=>'accountEmploy','middleware'=>['auth:user-api','scopes:user']],function() {
    route::get('/', 'accountController@index')->name('account.index');
    route::get('/showId/{id}', 'accountController@indexId')->name('account.index');
    route::post('/store', 'accountController@store')->name('account.store');
    route::post('/update/{id}', 'accountController@update')->name('account.update');
    route::delete('/delete/{id}', 'accountController@delete')->name('account.delete');
    route::get('/search/{phoneNum}', 'accountController@search')->name('account.search');
    route::get('/csrf', 'accountController@csrf');
});

##########################registerPatient#########################################
route::group(['prefix'=>'accountPatient'],function() {
    route::get('/', 'accountPatientController@index')->name('accountPatient.index');
    route::post('/store', 'accountPatientController@store')->name('accountPatient.store');
    route::post('/update/{id}', 'accountPatientController@update')->name('accountPatient.update');
    route::post('/delete/{id}', 'accountPatientController@delete')->name('accountPatient.delete');
    route::get('/search/{phoneNum}', 'accountPatientController@search')->name('accountPatient.search');
});

##########################registerDoctor#########################################
route::group(['prefix'=>'accountDoctor'],function() {
    route::get('/', 'accountDoctorController@index')->name('accountDoctor.index');
    route::post('/store', 'accountDoctorController@store')->name('accountDoctor.store');
    route::post('/update/{id}', 'accountDoctorController@update')->name('accountDoctor.update');
    route::post('/delete/{id}', 'accountDoctorController@delete')->name('accountDoctor.delete');
    route::get('/search/{phoneNum}', 'accountDoctorController@search')->name('accountDoctor.search');
    route::get('/showListConfirmReservation/{id}', 'accountDoctorController@showListConfirmReservation')->name('accountDoctor.showListConfirmReservation');//
    route::post('/confirmReservation/{id}', 'accountDoctorController@confirmReservation')->name('accountDoctor.confirmReservation');//->middleware(['auth:doctor-api','scopes:doctor']);
    route::get('/showListConfirmInternalAccept/{id}', 'accountDoctorController@showListConfirmInternalAccept')->name('accountDoctor.showListConfirmInternalAccept');//->middleware(['auth:doctor-api','scopes:doctor']);
    route::post('/confirmInternalAccept/{id}', 'accountDoctorController@confirmInternalAccept')->name('accountDoctor.confirmInternalAccept');

});


##########################Internal Accept#########################################
route::group(['prefix'=>'internalAccept'],function() {

    route::post('/store', 'internalAcceptController@store')->name('internalAccept.store');
    route::post('/update/{id}', 'internalAcceptController@update')->name('internalAccept.update');
    route::post('/delete/{id}', 'internalAcceptController@delete')->name('internalAccept.delete');
    route::get('/indexId/{id}', 'internalAcceptController@indexId')->name('internalAccept.indexId');
   // route::get('/search/{fullName}/{phoneNum}', 'internalAcceptController@search')->name('accountDoctor.search');
    route::get('/', 'internalAcceptController@index')->name('internalAccept.index');
});
######################login##############################################



route::group(['prefix'=>'user'],function() {
    //Route::post('admin/login',[LoginController::class, 'adminLogin'])->name('adminLogin');
    route::post('/loginUser', 'loginController@loginUser')->name('loginUser.index');
    route::post('/logoutUser', 'loginController@logoutUser')->name('logout.index')->middleware(['auth:user-api','scopes:user']);
    route::post('/logoutDoctor', 'loginController@logoutDoctor')->name('logout.index')->middleware(['auth:doctor-api','scopes:doctor']);
    route::post('/logoutPatient', 'loginController@logoutPatient')->name('logout.index')->middleware(['auth:patient-api','scopes:patient']);

});
#############################acceptanse#########################################
route::group(['prefix'=>'acceptance'],function() {
    route::get('/', 'acceptController@index')->name('accept.index')->middleware(['auth:user-api','scopes:user']);
    route::post('/store', 'acceptController@store')->name('accept.store');
    route::post('/update/{id}', 'acceptController@update')->name('accept.update');
    route::delete('/delete/{id}', 'acceptController@delete')->name('accept.delete');
    route::get('/search/{id}', 'acceptController@search')->name('accept.search');
    route::get('/indexId/{id}', 'acceptController@indexId')->name('accept.indexId');
});

#############################Room#########################################
route::group(['prefix'=>'room'],function() {
    route::get('/', 'roomController@index')->name('room.index');
    route::post('/store', 'roomController@store')->name('room.store');
    route::post('/update/{id}', 'roomController@update')->name('room.update');
    route::post('/delete/{id}', 'roomController@delete')->name('room.delete');
   // route::get('/search/{id}', 'acceptController@search')->name('accept.search');

});


#############################Operating Room#########################################
route::group(['prefix'=>'operatingRoom'],function() {
    route::get('/show', 'operatingRoomController@index')->name('operatingRoom.index');
    route::post('/store', 'operatingRoomController@store')->name('operatingRoom.store');
    route::post('/update/{id}', 'operatingRoomController@update')->name('operatingRoom.update');
    route::post('/delete/{id}', 'operatingRoomController@delete')->name('operatingRoom.delete');
   // route::get('/showOperationDate/{id}', 'dailyCalendarController@showOperationDate')->name('dailyCalendar.search');
    route::get('/showDoctorWithDay/{date}', 'dailyCalendarController@showDoctorWithDay')->name('showDoctorWithDay.show');

});


############################# Reservatin of operation  Calender#########################################
route::group(['prefix'=>'operation'],function() {
    route::post('/store', 'operationController@store')->name('operation.store');
    route::post('/update/{id}', 'operationController@update')->name('operation.update');
    route::post('/delete/{id}', 'operationController@delete')->name('operation.delete');
   // route::get('/showOperationDate/{id}', 'operationController@search')->name('operation.search');
    route::get('/showOperationForSpecialDoctorAndDate/{id}/{date}','operationController@showOperationForSpecialDoctorAndDate');//->middleware(['auth:doctor-api','scopes:doctor']);
    route::get('/operationForSpecialFolder/{id}','operationController@operationForSpecialFolder');
    route::get('/show/{date}/{specification}', 'operationController@index')->name('operation.index');
    route::get('/indexId/{id}', 'operationController@indexId')->name('operation.indexId');
});

#############################Time Doctor#########################################
route::group(['prefix'=>'doctorTime'],function() {
    route::get('/', 'timeDoctorController@index')->name('timeDoctor.index');
    route::post('/store', 'timeDoctorController@store')->name('timeDoctor.store')->middleware(['auth:doctor-api','scopes:doctor']);
    route::post('/update/{id}', 'timeDoctorController@update')->name('timeDoctor.update');
    route::post('/delete/{id}', 'timeDoctorController@delete')->name('timeDoctor.delete');
     route::get('/showTimeDoctor/{name}', 'timeDoctorController@showTimeDoctor')->name('timeDoctor.search');

});
#############################acceptForm#########################################
route::group(['prefix'=>'accept'],function() {
    route::get('/', 'acceptFormController@index')->name('acceptForm.index');
    route::post('/addColumn', 'acceptFormController@addCol')->name('acceptForm.store');
   route::post('/update/{id}', 'acceptFormController@updateColumnAcceptForm')->name('acceptForm.update');
   route::post('/delete/{id}', 'acceptFormController@deleteColumnSmall')->name('acceptForm.delete');
});

#############################folderForm#########################################
route::group(['prefix'=>'folderForm'],function() {
    route::get('/', 'internalFolderFormController@index')->name('folderForm.index');
    route::post('/addColumn', 'internalFolderFormController@addCol')->name('folderForm.store');
    route::post('/update/{id}', 'internalFolderFormController@updateColumnFolderForm')->name('folderForm.update');
    route::post('/delete/{id}', 'internalFolderFormController@deleteColumnSmall')->name('folderForm.delete');
});

#############################Folder#########################################
route::group(['prefix'=>'folder'],function() {
    route::get('/', 'internalFolderController@index')->name('Folder.index');
    route::post('/store', 'internalFolderController@store')->name('Folder.store');
    route::post('/update/{id}', 'internalFolderController@updateFolder')->name('Folder.update');
    route::post('/delete/{id}', 'internalFolderController@deleteFolder')->name('Folder.delete');
    route::get('/search/{id}', 'internalFolderController@search')->name('Folder.search');
    route::get('/indexId/{id}', 'internalFolderController@indexId')->name('Folder.indexId');
});
