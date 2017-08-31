<?php

namespace App\Http\Middleware\login\v2;

use Closure;
use Request;
use App\Sessionkey;
use App\Services\ConstantApiMessageService;
use App\Services\ConstantStatusService;
use App\ApiConfig;
use App\ApiType;
use App\ApiCategories;

class checkApiKey
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
		}
	 
    public function handle($request, Closure $next)
    {
		if (!Request::header('API-KEY')) {
            return response()->json(['error' => ConstantApiMessageService::APIRequireMessage], ConstantStatusService::BADREQUESTSTATUS);
        }
		else
		{
			
			$apiKey = Request::header('API-KEY');
			$apiKeyData = $this->ApiConfig->getDataByApiKey($apiKey);			
			if ($apiKeyData==NULL) {
            return response()->json(['error' => ConstantApiMessageService::InvalidApiMessage], ConstantStatusService::BADREQUESTSTATUS);
       		 }
			$hits = $apiKeyData->hits+1;
			$this->ApiConfig->edit(array("hits"=>$hits),$apiKeyData->id);
			$apiId = $this->getModule($request);
			//var_dump($apiId);exit;
			$apiData = explode('_',$apiId);
			$apiId = $apiData[0];
			$apiCategory = $apiData[1];
			$apiVersion = $apiData[2];

			$apiCategory = $this->ApiCategories->getDataByTitle($apiCategory);
			$apiTypeData = $this->ApiType->getDataByCategoryId($apiCategory->id);
			$apiTypeData->manual_response;
			if(!empty($apiTypeData->manual_response)){
				return $apiTypeData->manual_response;
			}

			$hits = $apiTypeData->total_calls+1;
			$this->ApiType->edit(array("total_calls"=>$hits),$apiTypeData->id);
			
		}
		
        return $next($request);
    }
	
	public function getModule($request)
		{
			$action = $request->route()->getAction();
			return $action['LoginApiModuleV2'];
		}
}
