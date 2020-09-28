<?php
Route::get('/', function () {
    return view('page.dashboard');
});

Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
Route::post('dashboard', 'DashboardController@store')->name('dashboard.store');
Route::group(['middleware' => 'cekStatusLogin'], function() {
	Route::resource('cek-koneksi', 'CekKoneksiMesinController');
	Route::resource('upload-log-user', 'UploadLogUserController');
	Route::resource('upload-log-mesin', 'UploadLogAbsensiController');
	Route::get('register-mesin/data', 'RegisterMesinController@data')->name('register-mesin.data');
	Route::resource('register-mesin', 'RegisterMesinController');
});

