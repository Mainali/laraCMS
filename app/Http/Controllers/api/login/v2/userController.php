<?php

namespace App\Http\Controllers\api\login\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ConstantStatusService;
use App\Services\ConstantService;
use App\Services\ConstantApiMessageService;
use App\Services\UserService;
use App\User;
use Image;
use Session;
use Redirect;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Input;

class userController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function __construct(\Illuminate\Http\Request $request)
  {
    $this->request = $request;
    $this->userService = new UserService;
    $this->user = new User;
  }

  public function mandatoryField($inputData){
  if(empty($inputData['firstName']) && empty($inputData['lastName'])  && empty($inputData['address']) && empty($inputData['mobile']) && empty($inputData['userName']) && empty($inputData['password']) && empty($inputData['confirmPassword'])){
   $messages['msg'][]=ConstantApiMessageService::RequireMessage;
   $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
   return $messages;
  }elseif(empty($inputData['firstName']) || empty($inputData['lastName'])  || empty($inputData['address']) || empty($inputData['mobile']) || empty($inputData['userName']) || empty($inputData['password']) || empty($inputData['confirmPassword'])){
   $messages['msg'][]=ConstantApiMessageService::RequireMessage;
   $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
   return $messages;
  }else{
    $password=md5($inputData['password']);
    $confirmPassword=md5($inputData['confirmPassword']);
    if($password!=$confirmPassword){
     $message['msg'][]=ConstantApiMessageService::PasswordMisMatchMessage;
    $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    }else{
    $userData=$this->userService->checkUserName($inputData['userName']);
    if(!empty($userData)){
    $message['msg'][]=ConstantApiMessageService::AvailableMessage;
    $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    }else{
    $jsonMessage=$this->userService->addUserInfo($inputData,$password);
    $message['msg'][]=$jsonMessage['message'];
    $message['status']=$jsonMessage['status'];
    }
    }
    return $message;
  }
  }
  public function mandatoryFieldForEmail($inputData){
  if(empty($inputData['firstName']) && empty($inputData['lastName']) && empty($inputData['email'])  && empty($inputData['address']) && empty($inputData['mobile']) && empty($inputData['userName']) && empty($inputData['password']) && empty($inputData['confirmPassword'])){
   $messages['msg'][]=ConstantApiMessageService::RequireMessage;
   $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
   return $messages;
  }elseif(empty($inputData['firstName']) || empty($inputData['lastName']) || empty($inputData['email'])  || empty($inputData['address']) || empty($inputData['mobile']) || empty($inputData['userName']) || empty($inputData['password']) || empty($inputData['confirmPassword'])){
   $messages['msg'][]=ConstantApiMessageService::RequireMessage;
   $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
   return $messages;
  }else{
    $password=md5($inputData['password']);
    $confirmPassword=md5($inputData['confirmPassword']);
    if($password!=$confirmPassword){
     $message['msg'][]=ConstantApiMessageService::PasswordMisMatchMessage;
    $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    }else{
    $userData=$this->userService->checkUserName($inputData['userName']);
    if(!empty($userData)){
    $message['msg'][]=ConstantApiMessageService::AvailableMessage;
    $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    }else{
    $jsonMessage=$this->userService->addUserInfo($inputData,$password);
    $message['msg'][]=$jsonMessage['message'];
    $message['status']=$jsonMessage['status'];
    }
    }
    return $message;
  }
  }
  public function emailReactivation(){
  $email=Input::get('email');
  if(empty($email)){
   $messages['msg'][]=ConstantApiMessageService::RequireMessage;
   $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
  }else{
  $checkEmail=$this->isValidEmail($email);
  if($checkEmail==1){
    $userData=$this->user->getUserByEmail($email);
    $nowTime=$this->dateTime();
    $nowTimeStamp = strtotime($nowTime);
    $modifiedTimeStamp=strtotime($userData->modified_at);
    $realTimeStamp=$nowTimeStamp-$modifiedTimeStamp;
    if(!empty($userData)){
    if($userData->no_of_attempt == ConstantService::noOfAttemptThree){
    if(USERREGISTRATIONBLOCKTIME<=$realTimeStamp){
      $noOfAttempt=ConstantService::ZeroValue;
    $this->user->updateNoOfAttempt($userData->id,$noOfAttempt);
    $msg=$this->userService->sendEmail($userData->id);
    $messages['msg'][]=$msg['message'];
    $messages['status']=$msg['status'];
    }else{
    $messages['msg'][]=ConstantApiMessageService::BlockMessage;
    $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    }
    }else{
     $msg=$this->sendEmail($userData);
    $messages['msg'][]=$msg['message'];
    $messages['status']=$msg['status'];
    }
  }
  }
  }
   return response()->json($messages['msg'], $messages['status']);
  }
  public function sendEmail($userData){
    $msg=$this->userService->sendEmail($userData->id);
    $noOfAttempt=$userData->no_of_attempt+1;
    $this->user->updateNoOfAttempt($userData->id,$noOfAttempt);
    return $msg;
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

    public function confirmRegistration($token){
    $this->userService->updateStatus($token);
    $jsonResponse=$this->userService->checkToken($token);
    $msg[]=$jsonResponse['message'];
    return response()->json($msg, $jsonResponse['status']);
  }
  public function mandatoryFieldForSms($inputData){
  if(empty($inputData['firstName']) && empty($inputData['lastName'])  && empty($inputData['address']) && empty($inputData['mobile']) && empty($inputData['userName']) && empty($inputData['password']) && empty($inputData['confirmPassword'])){
   $messages['msg'][]=ConstantApiMessageService::RequireMessage;
   $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
   return $messages;
  }elseif(empty($inputData['firstName']) || empty($inputData['lastName'])  || empty($inputData['address']) || empty($inputData['mobile']) || empty($inputData['userName']) || empty($inputData['password']) || empty($inputData['confirmPassword'])){
   $messages['msg'][]=ConstantApiMessageService::RequireMessage;
   $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
   return $messages;
  }else{
    $password=md5($inputData['password']);
    $confirmPassword=md5($inputData['confirmPassword']);
    if($password!=$confirmPassword){
     $message['msg'][]=ConstantApiMessageService::PasswordMisMatchMessage;
    $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    }else{
    $userData=$this->userService->checkUserName($inputData['userName']);
    if(!empty($userData)){
    $message['msg'][]=ConstantApiMessageService::AvailableMessage;
    $message['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    }else{
    $jsonMessage=$this->userService->addUserInfo($inputData,$password);
    $message['msg'][]=$jsonMessage['message'];
    $message['status']=$jsonMessage['status'];
    }
    }
    return $message;
  }
  }

  public function signUp()
  {
      $inputData=Input::all();
    if(LOGINCONFIGURATION=='email'){
      $messages=$this->mandatoryFieldForEmail($inputData);
    }
    elseif(LOGINCONFIGURATION=='sms'){
    $messages=$this->mandatoryFieldForSms($inputData);
    }else{
    $messages=$this->mandatoryField($inputData);
    }
    
    return response()->json($messages['msg'], $messages['status']);
  }
    public function changePassword(Request $request)
  {
    $id = $request->authKeyData->user_id;
    $inputData = Input::all();
     $userDetail=$this->user->getUserDetailById($id);
     if(empty($inputData)){
      $msgs['message'][]=ConstantApiMessageService::InputMessage;
      $msgs['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
     }elseif(empty($inputData['oldPassword'])||empty($inputData['newPassword'])||empty($inputData['confirmPassword'])){
    $msgs['message'][]=ConstantApiMessageService::RequireMessage;
    $msgs['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
     }else{
     $oldPassword=md5($inputData['oldPassword']);
     $newPassword=md5($inputData['newPassword']);
     $confirmPassword=md5($inputData['confirmPassword']);
     if($newPassword!=$confirmPassword){
      $msgs['message'][]=ConstantApiMessageService::PasswordMisMatchMessage;
      $msgs['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
     }else{
     $message=$this->userService->changePassword($oldPassword,$newPassword,$confirmPassword);
     $msgs['message'][]=$message['message'];
     $msgs['status']=$message['status'];
     }
     }

    return response()->json($msgs['message'], $msgs['status']);
  }

  public function forgotPassword(Request $request){
  $email=Input::get('email');
   $id = $request->authKeyData->user_id;
  if(empty($email)){
    $msgs['message'][]=ConstantApiMessageService::InputMessage;
    $msgs['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
  }else{
    $checkEmail=$this->isValidEmail($email);
    if($checkEmail==1){
    $message=$this->userService->forgotPassword($email,$id);
    $msgs['message'][]=$message['message'];
    $msgs['status']=$message['status'];
  }else{
    $msgs['message'][]=ConstantApiMessageService::InvalidEmailMessage;
    $msgs['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
  }
  }
  return response()->json($msgs['message'], $msgs['status']);
  }
  
  public function confirmForgotPassword(Request $request){
     $id = $request->authKeyData->user_id;
     $inputData=Input::all();
   if(empty($inputData)){
   $msgs['message'][]=ConstantApiMessageService::InputMessage;
    $msgs['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
  }elseif(empty($inputData['newPassword'])||empty($inputData['confirmPassword'])||empty($inputData['token'])){
     $msgs['message'][]=ConstantApiMessageService::RequireMessage;
    $msgs['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
  }
  else{
    $newPassword=md5($inputData['newPassword']);
    $confirmPassword=md5($inputData['confirmPassword']);
    $token=$inputData['token'];
    if($newPassword!=$confirmPassword){
       $msgs['message'][]=ConstantApiMessageService::PasswordMisMatchMessage;
      $msgs['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    }else{
    $message=$this->userService->confirmForgotPassword($id,$newPassword,$confirmPassword,$token);
     $msgs['message'][]= $message['message'];
    $msgs['status']= $message['status'];
    }
  }
  return response()->json($msgs['message'], $msgs['status']);
  }
  public function login(Request $request){
    $inputData=Input::all();
    if(empty($inputData)){
   $messages['message'][]=ConstantApiMessageService::InputMessage;
   $message['authKey']='';
   $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    }elseif(empty($inputData['deviceId'])||empty($inputData['userName'])||empty($inputData['password'])){
    $messages['message'][]=ConstantApiMessageService::RequireMessage;
   $message['authKey']='';
   $messages['status']=ConstantStatusService::UNAUTHORIZEDSTATUS;
    }else{
    $msg=$this->userService->login($inputData);
    $messages['message'][]=$msg['message'];
    $messages['status']=$msg['status'];
    $messages['authKey']=$msg['authKey'];
    }
    if(empty($messages['authKey'])){
      return response()->json($messages['message'], $messages['status']);
    }else{
    return response()->json($messages['message'], $messages['status'])->header('Auth-Key', $messages['authKey']);
  }
  }



}
