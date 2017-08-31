<?php

namespace App\Http\Controllers\api\login\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ConstantStatusService;
use App\Services\ConstantService;
use App\Services\ConstantApiMessageService;
use App\Services\ApiLoginService;
use App\ApiLogin;
use Image;
use Session;
use Redirect;
use Carbon\Carbon;
use Validator;
use Config;
use Illuminate\Support\Facades\Input;

class loginController extends Controller
{
/**
* Display a listing of the resource.
*
* @return Response
*/
public function __construct(\Illuminate\Http\Request $request)
{
  $this->request = $request;
  $this->apiLoginService = new ApiLoginService;
  $this->apiLogin = new ApiLogin;
}




public function signUp()
{
  $inputData=Input::all();
$returnData = $this->signUpValidation($inputData);
if($returnData)return response()->json($returnData['msg'], $returnData['status']);
$signUpVerfication=Config::get('systemConfig.loginApiConfig.signUpVerfication');
if($signUpVerfication=='sms'){
$thisData['status'] = 'Pending';
$thisData['password'] =md5(ConstantService::ZeroValue,ConstantService::RandFourDigitNumber);
}
elseif($signUpVerfication=='email'){
$thisData['status'] = 'Pending';
$thisData['password'] = md5(ConstantService::ZeroValue,ConstantService::RandFourDigitNumber);
}
else{
$thisData['status'] = 'Active';
$thisData['password']=md5($inputData['password']);
}
$signupFields=Config::get('systemConfig.loginApiConfig.signupFields');
$dbFields=Config::get('systemConfig.loginApiConfig.dbFields');
foreach($signupFields as $signupField=>$type){
$InsertData[$signupField] = $inputData[$dbFields[$signupField]];
}
$InsertData['last_login'] = $this->dateTime();
$InsertData['created_at'] = $this->dateTime();
$InsertData['modified_at'] = $this->dateTime();
$InsertData['status']=$thisData['status'] ;
$InsertData['password']=$thisData['password'];
$message=$this->apiLoginService->addUser($InsertData);
$msg['message'][]=$message['message'];
$msg['status']=$message['status'];
return response()->json($msg['message'], $msg['status']);
}


public function signUpValidation($inputData){
$dbFields=Config::get('systemConfig.loginApiConfig.dbFields');
$apiFields = array();
foreach ($dbFields as $dbField => $apiField)array_push($apiFields,$apiField);
$signupFields=Config::get('systemConfig.loginApiConfig.signupFields');
foreach($signupFields as $signupField=>$type){
  if(!isset($inputData[$dbFields[$signupField]])){
        $message['msg'][]='Fields Not enough';
        $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
        return $message;
      }
  else
      {
        if($type=='Mandatory'&&empty($inputData[$dbFields[$signupField]])){
        $message['msg'][]=$dbFields[$signupField].' should not be empty';
        $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
        return $message;   
        }
      }
}
$loginFields=Config::get('systemConfig.loginApiConfig.loginFields');
foreach($loginFields as $loginField){
  $dbField =  $loginField;
  $dbValue = $inputData[$dbFields[$loginField]];
  $num=$this->apiLoginService->checkUniqueField($dbField,$dbValue);
  if($num>0){
    $message['msg'][]=$dbFields[$loginField].' already avialabe in DB';
    $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    return $message;
  }
}

return false;
}

public function login(Request $request){
  $inputData=Input::all();
$returnData = $this->loginValidation($inputData);

if($returnData['err']=='empty')return response()->json($returnData['message']['msg'], $returnData['message']['status']);
elseif($returnData['err']=='emptydevice')return response()->json($returnData['message']['msg'], $returnData['message']['status']);
elseif($returnData['err']=='invalid')return response()->json(['Invalid Userame/Password'], ConstantStatusService::UNAUTHORIZEDSTATUS);

elseif($returnData['err']=='invalid')return response()->json(['Invalid Userame/Password'], ConstantStatusService::UNAUTHORIZEDSTATUS);
else{
  $userData=$returnData['data'];
  $msg=$this->apiLoginService->checkLogin($inputData['deviceId'],$userData);
  $message['message'][]=$msg['message'];
  return response()->json($message['message'], $msg['status'])->header('Auth-Key',$msg['authKey']);
  exit;
}

}

public function loginValidation($inputData){
	if(empty($inputData['deviceId'])){
	$message['msg'][]='DeviceId should not be empty';
  $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
  $data['message'] = $message;
  $data['err'] = 'emptydevice';
  return $data;
	}elseif(empty($inputData['userName'])||empty($inputData['password'])){
  $message['msg'][]='Username/Password should not be empty';
  $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
  $data['message'] = $message;
  $data['err'] = 'empty';
  return $data;
}
$loginFields=Config::get('systemConfig.loginApiConfig.loginFields');
$data['err'] = 'invalid';
foreach($loginFields as $loginField){
  $dbField =  $loginField;
  $data['data'] = $this->apiLoginService->checkUserNamePasswordDynamic($inputData['password'],$inputData['userName'],$dbField);
  if($data['data']!=NULL){$data['err']='valid';break;}
  
}
return $data;
}

public function dateTime()
{
  $dateTime = Carbon::now('Asia/Kathmandu');
  return $dateTime->toDateTimeString();
}
public function isValidEmail($email)
{
  return filter_var($email, FILTER_VALIDATE_EMAIL)
  && preg_match('/@.+\./', $email);
}



}
