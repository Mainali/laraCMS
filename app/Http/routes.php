<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

define('PREFIX',Config::get('systemConfig.config.cmsPrefix'));
define('UPLOADS',Config::get('systemConfig.config.uploadsFolder'));
define("ABS_URL", Config::get('routesconfig.routes.absUrl').PREFIX.'/');
define("LOGINAPIPREFIX_V1", Config::get('systemConfig.apiv1.login.apiPrefix'));
define("LOGINAPIMODULEV1", Config::get('systemConfig.apiv1.login.apiModule'));
define("DEVICEAPIMODULEV1", Config::get('systemConfig.apiv1.device.apiModule'));
define("DOWNLOADAPIPREFIX_V1", Config::get('systemConfig.apiv1.download.apiPrefix'));
define("DEVICEAPIPREFIX_V1", Config::get('systemConfig.apiv1.device.apiPrefix'));
define("USERAPIPREFIX_V1", Config::get('systemConfig.apiv1.user.apiPrefix'));
define("USERAPIMODULEV1", Config::get('systemConfig.apiv1.user.apiModule'));
define("ACTIVATIONAPIPREFIX_V1", Config::get('systemConfig.apiv1.activation.apiPrefix'));
define("ACTIVATIONAPIMODULEV1", Config::get('systemConfig.apiv1.activation.apiModule'));
define("LOGINAPIPREFIX_V2", Config::get('systemConfig.apiv2.login.apiPrefix'));
define("LOGINAPIMODULEV2", Config::get('systemConfig.apiv2.login.apiModule'));
define("MODULEFOLDER", Config::get('systemConfig.config.moduleFolder'));
define("LOGINCONFIGURATION", Config::get('loginconfig.routes.loginConfiguration'));
define("USERREGISTRATIONBLOCKTIME", Config::get('systemConfig.config.timeStamp'));
define("SignUpGateWay",Config::get('systemConfig.signupApi.loginVerification'));
define("APP_URL",Config::get('app.url'));
//API Routing Goes Here//
Route::get(DEVICEAPIPREFIX_V1.'/devices', ['middleware'=>['loginApicheckV1','apiHitLogV1'],'LoginApiModuleV1'=>'devices_login_v1','uses'=>DEVICEAPIMODULEV1.'\deviceController@addDevices']);
Route::get(DOWNLOADAPIPREFIX_V1.'/download', ['LoginApiModuleV1'=>'downloadApk_download_v1','uses'=>DEVICEAPIMODULEV1.'\deviceController@downloadApk']);
Route::get(LOGINAPIPREFIX_V1.'/signup', ['middleware'=>'loginApicheckV1','LoginApiModuleV1'=>'signup_login_v1','uses'=>LOGINAPIMODULEV1.'\loginController@signUp']);
Route::get(LOGINAPIPREFIX_V1.'/signin', ['middleware'=>['loginApicheckV1','apiHitLogV1'],'LoginApiModuleV1'=>'signin_login_v1','uses'=>LOGINAPIMODULEV1.'\loginController@login']);
Route::post(LOGINAPIPREFIX_V1.'/change/password',['middleware' => ['loginApicheckV1','loginCheckV1'], 'LoginApiModuleV1'=>'changePassword_login_v1', 'uses' =>LOGINAPIMODULEV1.'\loginController@changePassword']);
Route::get(LOGINAPIPREFIX_V1.'/forgot/password',['middleware' => ['loginApicheckV1','loginCheckV1'], 'LoginApiModuleV1'=>'forgotPassword_login_v1', 'uses' =>LOGINAPIMODULEV1.'\loginController@forgotPassword']);
Route::get(LOGINAPIPREFIX_V1.'/forgot/password/confirm',['middleware' => ['loginApicheckV1','loginCheckV1'], 'LoginApiModuleV1'=>'confirmForgotPassword_login_v1', 'uses' =>LOGINAPIMODULEV1.'\loginController@confirmForgotPassword']);
Route::get(USERAPIPREFIX_V1.'/user',['middleware' => ['loginApicheckV1','loginCheckV1'], 'LoginApiModuleV1'=>'listUser_user_v1', 'uses' =>USERAPIMODULEV1.'\userController@getAllUser']);
Route::get(USERAPIPREFIX_V1.'/user/delete',['middleware' => ['loginApicheckV1','loginCheckV1','apiHitLogV1'], 'LoginApiModuleV1'=>'listUser_user_v1', 'uses' =>USERAPIMODULEV1.'\userController@deleteUser']);
Route::post(ACTIVATIONAPIPREFIX_V1.'/add', ['middleware' => ['loginApicheckV1','loginCheckV1','apiHitLogV1'], 'LoginApiModuleV1'=>'addActivation_activation_v1', 'uses' =>ACTIVATIONAPIMODULEV1.'\activationController@add']);
Route::post(ACTIVATIONAPIPREFIX_V1.'/imageupload', ['middleware' => ['loginApicheckV1','loginCheckV1','apiHitLogV1'], 'LoginApiModuleV1'=>'imageUpload_activation_v1', 'uses' =>ACTIVATIONAPIMODULEV1.'\activationController@uploadImage']);
Route::get(ACTIVATIONAPIPREFIX_V1.'/search/passport',['middleware' => ['loginApicheckV1','loginCheckV1','apiHitLogV1'],'LoginApiModuleV1'=>'searchPassport_activation_v1','uses'=> ACTIVATIONAPIMODULEV1.'\activationController@searchPassport']);
Route::get(ACTIVATIONAPIPREFIX_V1.'/search/citizenNumber', ['middleware' => ['loginApicheckV1','loginCheckV1','apiHitLogV1'],'LoginApiModuleV1'=>'searchCitizen_activation_v1','uses'=> ACTIVATIONAPIMODULEV1.'\activationController@searchCitizenNumber']);
//

//Front End Routing Goes here//
Route::get('/','highlandController@index');
Route::get(PREFIX, 'Auth\AuthController@getLogin');
Route::get(PREFIX.'/login', 'Auth\AuthController@getLogin');
Route::get(PREFIX . '/logout','Auth\AuthController@getLogout');
Route::any(PREFIX . '/login/operation/{operation}', 'Auth\AuthController@postLogin');
//Front End Routing


//Backend
Route::group(['prefix' => PREFIX,'middleware'=>array('auth','role')], function () {
    Route::group(['namespace' => 'cms' . '\\modules\\' . Request::segment(2) ], function () {
        
        Route::get('{module}/pages/{page}', Request::segment(4) . 'Controller@index');
        
        Route::get('{module}', Request::segment(2) . 'Controller@index');
        
        Route::get('{module}/{page}', Request::segment(2) . 'Controller@' . Request::segment(3));
        
        Route::post('{module}/{page}', Request::segment(2) . 'Controller@' . Request::segment(3));
        
        Route::get('{module}/{page}/{id}', Request::segment(2) . 'Controller@' . Request::segment(3));
        
        Route::get('{module}/pages/{page}/{id}', Request::segment(4) . 'Controller@' . Request::segment(5));
        
        Route::post('{module}/pages/{page}/{id}', Request::segment(4) . 'Controller@' . Request::segment(5));
        
        Route::get('{module}/pages/{page}/{abc}/{id}', Request::segment(4) . 'Controller@' . Request::segment(5));
        
        Route::post('{module}/pages/{page}/{abc}/{id}', Request::segment(4) . 'Controller@' . Request::segment(5));
    });
}); 

//Backend
