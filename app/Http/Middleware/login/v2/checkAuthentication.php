<?php

namespace App\Http\Middleware\login\v2;

use Closure;
use Request;
use App\Authorization;
use App\Services\ConstantStatusService;
use App\Services\ConstantApiMessageService;

class checkAuthentication
{


  public function __construct()
  {

    $this->authorization = new Authorization;
  }


  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (!Request::header('oauthtoken'))return response()->json(['error' => ConstantApiMessageService::AuthKeyRequiredMessage], ConstantStatusService::BADREQUESTSTATUS);
    $authKey = Request::header('oauthtoken');
	  $request->authKeyData= $this->authorization->getDataByAuthKey($authKey);
	  if (!empty($request->authKeyData))
		{
    return $next($request);
		}
    else return response()->json(['error' => ConstantApiMessageService::InvalidAuthMessage], ConstantStatusService::BADREQUESTSTATUS);
    }
}
