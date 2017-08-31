<?php
//Backend

Route::group(['prefix' => 'system','middleware'=>['auth','role','log','permission:'.basename(request()->path())]], function () {

    Route::get('log/pages/Exception-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

  Route::group(['namespace' => 'Admin' ], function () {

      Route::get('/home','home\homeController@index');
      Route::resource('log', 'log\logController');
      Route::resource('user', 'user\usersController');
      Route::resource('role', 'user\rolesController');
      Route::get('LogViewer','log\LogViewerController@index');
      Route::get('password/updatepassword','password\passwordController@index');
      Route::get('/user/password/{id}','user\usersController@password');
      Route::post('/user/update_password/{id}','user\usersController@updatepassword');
      Route::get('/user/change_password/{id}','password\passwordController@change_password');
      Route::post('/user/change_password/{id}','password\passwordController@updatepassword');
      Route::post('/change_language','config\settingsController@store');


      Route::get('{module}/pages/{page}', Request::segment(4) . 'Controller@index')->middleware('permission:'.Request::segment(4));

      Route::get('{module}', Request::segment(2) . 'Controller@index')->middleware('permission:'.Request::segment(2));

      Route::get('{module}/{page}', Request::segment(2) . 'Controller@' . Request::segment(3))->middleware('permission:'.Request::segment(2));

      Route::post('{module}/{page}', Request::segment(2) . 'Controller@' . Request::segment(3))->middleware('permission:'.Request::segment(2));

      Route::get('{module}/{page}/{id}', Request::segment(2) . 'Controller@' . Request::segment(3))->middleware('permission:'.Request::segment(2));

      Route::get('{module}/pages/{page}/{id}', Request::segment(4) . 'Controller@' . Request::segment(5))->middleware('permission:'.Request::segment(4));

      Route::post('{module}/pages/{page}/{id}', Request::segment(4) . 'Controller@' . Request::segment(5))->middleware('permission:'.Request::segment(4));

      Route::get('{module}/pages/{page}/{abc}/{id}', Request::segment(4) . 'Controller@' . Request::segment(5))->middleware('permission:'.Request::segment(4));

      Route::post('{module}/pages/{page}/{abc}/{id}', Request::segment(4) . 'Controller@' . Request::segment(5))->middleware('permission:'.Request::segment(4));


  });

});
