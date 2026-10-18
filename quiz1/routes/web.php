<?php

use Illuminate\Support\Facades\Route;

Route::get('/','App\Http\Controllers\logincontroller@index');
Route::post('/login','App\Http\Controllers\logincontroller@aksilogin');

Route::get('/home','App\Http\Controllers\logincontroller@home')->name('home');
Route::get('/logout','App\Http\Controllers\logincontroller@logout');

Route::get('/edit/{user}','App\Http\Controllers\logincontroller@editview')->name('pengguna.edit');
Route::put('/edit/{user}','App\Http\Controllers\logincontroller@update')->name('pengguna.update');
Route::delete('/delete/{user}','App\Http\Controllers\logincontroller@delete')->name('pengguna.hapus');

Route::get('/servis/buat', 'App\Http\Controllers\logincontroller@buatServis')->name('servis.buat');
Route::post('/servis', 'App\Http\Controllers\logincontroller@simpanServis')->name('servis.simpan');
Route::get('/servis/{id}/edit', 'App\Http\Controllers\logincontroller@editServis')->name('servis.edit');
Route::put('/servis/{id}', 'App\Http\Controllers\logincontroller@updateServis')->name('servis.update');
Route::delete('/servis/{id}', 'App\Http\Controllers\logincontroller@hapusServis')->name('servis.hapus');

Route::get('/suku-cadang/buat', 'App\Http\Controllers\logincontroller@buatSukuCadang')->name('suku-cadang.buat');
Route::post('/suku-cadang', 'App\Http\Controllers\logincontroller@simpanSukuCadang')->name('suku-cadang.simpan');
Route::get('/suku-cadang/{id}/edit', 'App\Http\Controllers\logincontroller@editSukuCadang')->name('suku-cadang.edit');
Route::put('/suku-cadang/{id}', 'App\Http\Controllers\logincontroller@updateSukuCadang')->name('suku-cadang.update');
Route::delete('/suku-cadang/{id}', 'App\Http\Controllers\logincontroller@hapusSukuCadang')->name('suku-cadang.hapus');

Route::get('/laporan/export/{format}', [App\Http\Controllers\logincontroller::class,'exportLaporan'])
    ->whereIn('format',['print','excel','word'])
    ->name('laporan.export');


Route::get('/karyawan','App\Http\Controllers\logincontroller@karyawan')->name('karyawan.index');


Route::get('/tkry','App\Http\Controllers\logincontroller@tkry');
Route::post('/aksi_tkry','App\Http\Controllers\logincontroller@aksi_tkry');


