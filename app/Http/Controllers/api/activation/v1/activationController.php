<?php

namespace App\Http\Controllers\api\activation\v1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ActivationService;
use App\Services\ConstantService;
use App\Services\ConstantApiMessageService;
use App\Services\ConstantStatusService;
use Input;
use Redirect;
use Html;
use Image;
use File;
use Config;
use Carbon\Carbon;

class activationController extends Controller
{
 
  public function __construct(\Illuminate\Http\Request $request)
  {
    $this->activationService = new ActivationService;
     $this->constantService = new ConstantService;
       $this->request = $request;
  }


  public function index()
  {
    $data['thisPageId'] = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['adminData'] = $this->activationService->getAdminList();
    $data['activationDatas'] = $this->activationService->getActivationDatas();
    return view(PREFIX."/modules.activation.home",$data);
  }

  public function add(Request $request){
$operatorId = $request->authKeyData->user_id;
$inputData=Input::all();
$returnData = $this->activationValidation($inputData);
if($returnData)return response()->json($returnData['msg'], $returnData['status']);
$activationFields=Config::get('systemConfig.activationApiConfig.activationFields');
$dbFields=Config::get('systemConfig.activationApiConfig.dbFields');
foreach($activationFields as $activationField=>$type){
$InsertData[$activationField] = $inputData[$dbFields[$activationField]];
}
$InsertData['created_date'] = $this->dateTime();
$InsertData['status']='Not Viewed';
$InsertData['operator_id']=$operatorId;
$activationId=$this->activationService->add($InsertData);
$jsonResponse['id']=$activationId;
$jsonResponse['message'][]=ConstantApiMessageService::ActivationMessage;
$msg['status']=ConstantStatusService::CREATEDSTATUS;
return response()->json($jsonResponse, $msg['status']);
  }


  public function activationValidation($inputData){
$dbFields=Config::get('systemConfig.activationApiConfig.dbFields');
$apiFields = array();
foreach ($dbFields as $dbField => $apiField)array_push($apiFields,$apiField);
$activationFields=Config::get('systemConfig.activationApiConfig.activationFields');
foreach($activationFields as $activationField=>$type){
  if(!isset($inputData[$dbFields[$activationField]])){
        $message['msg'][]='Fields Not enough';
        $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
        return $message;
      }
  else
      {
        if($type=='Mandatory'&&empty($inputData[$dbFields[$activationField]])){
        $message['msg'][]=$dbFields[$activationField].' should not be empty';
        $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
        return $message;   
        }
      }
}
return false;
  }

  public function dateTime()
{
  $dateTime = Carbon::now('Asia/Kathmandu');
  return $dateTime->toDateTimeString();
}
public function uploadImage(){
  $id=Input::get('id');
  $inputData=Input::all();
$activationPaths=Config::get('systemConfig.activationApiConfig.imagePath');
$dbFields=Config::get('systemConfig.activationApiConfig.dbFields');
foreach($activationPaths as $activationField=>$activationPath){
  if(!empty($inputData[$dbFields[$activationField]])){
    $originalName = $inputData[$dbFields[$activationField]]->getClientOriginalName();
    $realImage = str_replace(' ', '-', $originalName);
    $originalImageName = rand(1000,9999) . strtotime(date('Ymdhis')) . "-main-" . $realImage;
    Image::make($inputData[$dbFields[$activationField]])->save($activationPath . $originalImageName);
$InsertData[$activationField] = $originalImageName;
}
}
$InsertData['created_date'] = $this->dateTime();
$InsertData['status']='Pending';
$this->activationService->updateImage($InsertData,$id);
$this->activationService->imageSyncStatus($id);
$jsonResponse['message'][]=ConstantApiMessageService::ActivationMessage;
$msg['status']=ConstantStatusService::CREATEDSTATUS;
return response()->json($jsonResponse['message'], $msg['status']);
}

  public function searchPassport(){
    $inputData=Input::all();
    if(empty($inputData)){
      $msgs['message'][]=ConstantApiMessageService::InputMessage;
      $msgs['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    return response()->json($msgs['message'], $msgs['status']);
    }else{
$passportFields=Config::get('systemConfig.activationApiConfig.passportFields');
$dbFields=Config::get('systemConfig.activationApiConfig.dbFields');
$data['err'] = 'invalid';
foreach($passportFields as $passportField){
  $dbField =  $passportField;
  $dbValue = $inputData[$dbFields[$passportField]];
  $msgs= $this->activationService->searchDynamicFields($dbField, $dbValue);
  return response()->json($msgs['message'], $msgs['status']);
}
 }
}

  public function searchCitizenNumber(){
    $inputData=Input::all();
    if(empty($inputData)){
      $msgs['message'][]=ConstantApiMessageService::InputMessage;
      $msgs['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    return response()->json($msgs['message'], $msgs['status']);
    }else{
$citizenshipFields=Config::get('systemConfig.activationApiConfig.citizenshipFields');
$dbFields=Config::get('systemConfig.activationApiConfig.dbFields');
$data['err'] = 'invalid';
foreach($citizenshipFields as $citizenshipField){
  $dbField =  $citizenshipField;
  $dbValue = $inputData[$dbFields[$citizenshipField]];
  $msgs= $this->activationService->searchDynamicFields($dbField, $dbValue);
  return response()->json($msgs['message'], $msgs['status']);
}
 }
}


public function testAdd(){
  $inputData=Input::all();
    if(empty($inputData)){
    $msgs['message']=['Please Provide valid input.'];
    $msgs['status']=constantService::UNAUTHORIZEDSTATUS;
    }else{
    $msgs=$this->activationService->testAdd($inputData);
}
     return response()->json($msgs['message'], $msgs['status']);
}

}
