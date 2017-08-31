<?php 

namespace App\Services;

use Auth;

use App\Device;
use Carbon\Carbon;

use Config;

class DeviceService
{
  public function __construct()
  {
    $this->device= new Device;
  }
  public function addDevices($inputData){
    $thisData['device_id']=$inputData['deviceId'];
    $thisData['device_token']=$inputData['deviceToken'];
    $thisData['created_on']=$this->dateTime();
    $thisData['updated_on']=$this->dateTime();
    $this->device->add($thisData);
     $jsonResponse = array('message' => ConstantApiMessageService::DeviceResponse, 'status' => ConstantStatusService::CREATEDSTATUS);
      return $jsonResponse;
  }

public function dateTime()
{
$dateTime = Carbon::now('Asia/Kathmandu');
return $dateTime->toDateTimeString();
}


}