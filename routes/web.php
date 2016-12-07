<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/','UserController@redirectAfterLogin');

Route::get('/test', 'BaseController@test');
Route::get('/test2', function() {
    return view('pages.layout.nav-top-1');
});
Route::get('/test3', function() {
    return view('giangvien');
});



// Route controllers
Auth::routes();

Route::get('/index', function(){
	return view('index');
});

Route::get('/closeTimeDk' , 'Nhan_vien_khoaController@closeTimeDk');
Route::post('/sendEmailToAll', 'Nhan_vien_khoaController@openTimeDk');

Route::post('/uploadGV', 'Nhan_vien_khoaController@uploadGV');
Route::post('/uploadSV', 'Nhan_vien_khoaController@uploadSV');
Route::post('/uploadKt','Nhan_vien_khoaController@uploadKt');
Route::get('/getListGV','Nhan_vien_khoaController@getListGV');
Route::get('/getListBomon','Nhan_vien_khoaController@getListBomon');
Route::get('/getListSV','Nhan_vien_khoaController@getListSV');
Route::get('/getListKhoahoc','Nhan_vien_khoaController@getListKhoahoc');
Route::get('/getListCtdt','Nhan_vien_khoaController@getListCtdt');
Route::get('/getListSVandDt','Nhan_vien_khoaController@svanddt');

Route::get('/addGV/{ma_giang_vien}/{ten_giang_vien}/{email}/{bomon}','Nhan_vien_khoaController@addGV');
Route::get('/addSV/{ma_sinh_vien}/{ten_sinh_vien}/{khoa_hoc}/{ctdt}','Nhan_vien_khoaController@addSV');
Route::get('/addHNC/{ten_huong_nghien_cuu}/{mo_ta}/{listlinhvuc}','Huong_Nghien_CuuController@addHNC');
Route::get('addKhoahoc/{khoa_hoc}', "Nhan_vien_khoaController@addKhoahoc");
Route::get('addCtdt/{ctdt}', "Nhan_vien_khoaController@addCtdt");
Route::get('addSVDDK/{msv}','Nhan_vien_khoaController@addSVDDK');

Route::get('/infoGV', 'Giang_VienController@getBasicInformation');
Route::post('/editGV', 'Giang_VienController@editBasicInformation');
Route::post('/repassGV', 'Giang_VienController@repass');


Route::get('/listBomon','BaseController@listBomon');
Route::get('/listLvcb','BaseController@listLvcb');
Route::get('/listGvLv','BaseController@listGvLv');

Route::post('/guiDeTai', 'De_TaiController@guiDeTai');
Route::get('/layDeTai', 'De_TaiController@layDeTai');
