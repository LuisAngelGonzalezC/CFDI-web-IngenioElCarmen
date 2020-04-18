<?php
/* Página de inicio (Login) */
Route::get('/', 'Auth\LoginController@home')->name('home');

/* Inicializar y finalizar sesión */
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/* Panel de administrador */
Route::prefix('admin')->group(function () {
	
	/* Página de inicio */
	Route::get('/', 'AdminDashboardController@index')->name('admin.home');
	
	/* CRUD Usuarios */
	Route::resource('user', 'UserController');

	/* CRUD Etiquetas */
	Route::resource('tag', 'TagController');

	//Enviar CFDIs
	Route::get('sendCFDIs/{id}', 'TagController@send')->name('tag.send');
	Route::get('sendCFDI/{cfdi}/tag/{tag}/user/{user}','CfdiController@send')->name('cfdi.send');

	/* CRUD CFDI */
	Route::resource('cfdi', 'CfdiController');
	Route::get('getCFDI', 'CfdiController@getCfdi')->name('getCFDI');
	Route::get('readCFDI', 'CfdiController@readCfdi')->name('readCFDI');
});

Route::get('api/user', 'UserController@apiUser')->name('api.user');
Route::get('api/cfdi/{id}', 'CfdiController@apiCfdi')->name('api.cfdi');

/* Panel de usuario */
Route::get('user','UserDashboardController@index')->name('user');
Route::get('getfile','UserDashboardController@getFile')->name('getFile');

Route::post('/verify/{id}', 'UserDashboardController@verify')->name('email.verify');
Route::get('/validate/{confirmation_code}/email/{email}', 'UserDashboardController@validation')->name('email.validation');

//Revisar la vista del correo electrónico
Route::get('/demo', 'UserDashboardController@demo');

//Errores
Route::get('404', 'ErrorHandlerController@errorCode404')->name('404');
Route::get('405', 'ErrorHandlerController@errorCode405')->name('405');
Route::get('419', 'ErrorHandlerController@errorCode419')->name('419');
Route::get('429', 'ErrorHandlerController@errorCode429')->name('429');
Route::get('500', 'ErrorHandlerController@errorCode500')->name('500');
Route::get('503', 'ErrorHandlerController@errorCode503')->name('503');

