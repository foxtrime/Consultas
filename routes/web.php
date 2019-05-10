<?php

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


// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', 'AuthController@index')->name('login');
Route::post('/login', 'AuthController@login');

Route::group(['middleware'=>['auth']],function(){

/*==================================LOGOUT=================================*/
Route::post('/logout',function(){
    Auth::logout();
    return redirect()->route('login');
});
Route::get('/logout',function(){
    Auth::logout();
    return redirect()->route('login');
});
/*============================================================================*/


Route::resource('consulta', 'ConsultaController');


Route::get('refreshsematt/{unidade}/{especializacao}/{datai}/{dataf}/{tipo_consulta}', 'ConsultaController@queryFull');
Route::get('refreshsematt/{unidade}/{especializacao}/{datai}/{dataf}', 'ConsultaController@querySemiFull');
Route::get('refreshsematt/{unidade}/{datai}/{dataf}', 'ConsultaController@querySimple');

Route::get('especializacoes/{unidade}','ConsultaController@especializacao');
Route::get('tipoconsulta/{unidade}','ConsultaController@tipoConsulta');

});
