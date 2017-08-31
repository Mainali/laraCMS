<?php

namespace App\Http\Controllers\api\devices\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ConstantStatusService;
use App\Services\ConstantService;
use App\Services\DeviceService;
use App\Services\ConstantApiMessageService;
use Carbon\Carbon;
use Response;
use App\MobileBuilt;
use Illuminate\Support\Facades\Input;

class deviceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function __construct(\Illuminate\Http\Request $request)
  {
    $this->request = $request;
    $this->deviceService = new DeviceService;
    $this->mobileBuilt = new MobileBuilt;
  }

public function addDevices(Request $request){
  $inputData=Input::all();
 if(empty($inputData)){
  $msg['message'][]=ConstantApiMessageService::InputMessage;
  $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
 }else{
  if(empty($inputData['deviceId'])&&empty($inputData['deviceToken'])){
  $msg['message'][]=ConstantApiMessageService::DeviceRequireMessage;
  $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
  }else{
  $msgs=$this->deviceService->addDevices($inputData);
  $msg['message'][]=$msgs['message'];
  $messages['status']=$msgs['status'];
  }
   }
   $msg['apiVersion']=$this->mobileBuilt->getApiVersion();
  return response()->json($msg, $messages['status']);
  }
public function dateTime()
{
$dateTime = Carbon::now('Asia/Kathmandu');
return $dateTime->toDateTimeString();
}

  public function downloadApk(){
    $mobileBuilt=$this->mobileBuilt->getApK();
    $file="public/apk/".$mobileBuilt;
    return Response::download($file);
  }
  
  



}
