<?php

namespace App\Http\Middleware\login\v1;

use Closure;
use Request;
use App\Services\ConstantApiMessageService;
use App\Services\ConstantStatusService;
use App\ApiConfig;
use App\ApiType;
use Carbon\Carbon;
use App\ApiCategories;
use App\Authorization;
use App\ApiDeviceHitLog;
use App\ApiUserHitLog;
use Input;

class checkApiHitLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	 
	 public function __construct()
	 	{
			$this->ApiConfig = new ApiConfig;
			$this->ApiType = new ApiType;
			$this->ApiCategories = new ApiCategories;
			$this->authorization = new Authorization;
			$this->apiUserHitLog = new ApiUserHitLog;
			$this->apiDeviceHitLog = new ApiDeviceHitLog;
		}
	 
    public function handle($request, Closure $next)
    {
		if (!Request::header('API-KEY')) {
            return response()->json(['error' => ConstantApiMessageService::APIRequireMessage], ConstantStatusService::BADREQUESTSTATUS);
        }
		else
		{
			$apiKey = Request::header('API-KEY');
			$authKey= Request::header('Auth-key');
			$apiKeyData = $this->ApiConfig->getDataByApiKey($apiKey);	
			$apiId = $this->getModule($request);
			$apiData = explode('_',$apiId);
			$apiTitle= $apiData[0];
			$apiCategory = $apiData[1];
			$apiVersion = $apiData[2];	
			$apiDetail=$this->ApiType->getDataByApiId($apiTitle);	
	   if(empty($authKey)){
				if(empty(Input::get('deviceId'))){
					return response()->json(['error' => ConstantApiMessageService::DeviceIdResponse], ConstantStatusService::UNAUTHORIZEDSTATUS);
				}
				$data['api_type_id']=$apiDetail->id;
				$data['device_id']=Input::get('deviceId');
				$data['created_at']=$this->dateTime();
				$this->apiDeviceHitLog->add($data);
				$deviceData=$this->authorization->getDataByDeviceId(Input::get('deviceId'));
				if(!empty($deviceData)){
				$data['user_id']=$deviceData->user_id;
				$this->apiUserHitLog->add($data);
				}
			}else{
      $thisData['user_id']=$this->authorization->getUserId($authKey);
      $authData=$this->authorization->getDataByAuthKey($authKey);
      $thisData['api_type_id']=$apiDetail->id;
      $thisData['device_id']=$authData->device_id;
      $data['created_at']=$this->dateTime();
      $this->apiUserHitLog->add($thisData);
      $this->apiDeviceHitLog->add($thisData);
			}
				
		}
		 return $next($request);
    }
	
	public function getModule($request)
		{
			$action = $request->route()->getAction();
			return $action['LoginApiModuleV1'];
		}

	public function dateTime()
	{
	$dateTime = Carbon::now('Asia/Kathmandu');
	return $dateTime->toDateTimeString();
	}
}
