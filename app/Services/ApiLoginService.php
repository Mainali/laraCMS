<?php
namespace App\Services;
use App\Authorization;
use App\Services\ConstantStatusService;
use App\Services\ConstantService;
use App\Services\ConstantApiMessageService;
use Auth;
use Session;
use Crypt;
use Config;
use Input;
use Image;
use Mail;
use App\ApiLogin;
use File;
use Hash;
use Carbon\Carbon;
use App\TemporaryPin;

/**
 * The UserService class.
 *
 * @author Rubens Mariuzzo <rubens@mariuzzo.com>
 */
class ApiLoginService
{


  /*
   *@call the constructor
   */

  public function __construct()
  {
     $this->apiLogin = new ApiLogin;
     $this->authorization= new Authorization;
     $this->temporaryPin = new TemporaryPin;
  }

public function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

  public function addUserInfo($inputData,$password){
    if(LOGINCONFIGURATION=='email'){
      $userId=$this->addUser($inputData,$password);
      $sucessResponse=$this->sendEmail($userId);
    return $sucessResponse;
    }elseif(LOGINCONFIGURATION=='sms'){
          $userId=$this->addUser($inputData,$password);
      $sucessResponse=$this->addTemporaryPin($userId);
      return $sucessResponse;
    }else{
    $this->addUser($inputData);
      $jsonResponse = array('message' => ConstantApiMessageService::sucessResponse, 'status' => ConstantStatusService::CREATEDSTATUS);
      return $jsonResponse;
    }
  }

  public function addUser($InsertData){
    $this->apiLogin->add($InsertData);
     $jsonResponse = array('message' => ConstantApiMessageService::SucessMessage, 'status' => ConstantStatusService::CREATEDSTATUS);
      return $jsonResponse;
  }

  public function checkToken($token){
    $userData=$this->apiLogin->checkToken($token);
    if(!empty($userData)){
    $this->apiLogin->removeToken($userData->id);
    $jsonResponse = array('message' => ConstantApiMessageService::ConfirmationMessage, 'status' => ConstantStatusService::OKSTATUS);
    }else{
   $jsonResponse = array('message' => ConstantApiMessageService::NotConfirmationMessage, 'status' => ConstantService::UNAUTHORIZEDSTATUS);
    }
    return $jsonResponse;
  }
  public function addTemporaryPin($userId){
    $userData=$this->apiLogin->getUserDetailById($userId);
    $randomPinNumber=rand(ConstantService::ZeroValue,ConstantService::RandFourDigitNumber);
    $thisData['pin']=md5($randomPinNumber);
    $thisData['user_id']=$userId;
    $thisData['started_time']=$this->dateTime();
    $thisData['created_at']=$this->dateTime();
    $thisData['modified_on']=$this->dateTime();
    $this->temporaryPin->add($thisData);
    $smsResponse=$this->sendSms($userData,$randomPinNumber);
    return $smsResponse;
  }

    public function sendSms($userData, $randomPinNumber)
  {
    $smsData['mobileNumber'] = $userData->mobile;
    $smsData['fullName'] = $userData->fullName;
    $smsData['pinNumber'] = $randomPinNumber;
    $to = $smsData['mobileNumber'];
    $msg = 'Welcome to EK CMS'. $smsData['fullName'].'your new pin number is' . $smsData['pinNumber'] . '.';
    $args = http_build_query(array(
      'token' => 'z2CRrsrWY7wxX0N5iNDo',
      'from' => 'bigmart',
      'to' => $to,
      'text' => $msg));

    $url = "http://api.sparrowsms.com/v2/sms/";

# Make the call using API.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Response
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $smsResponse = $this->newPinResponse();
    return $smsResponse;
  }
    public function newPinResponse()
  {
    $jsonData['status'] = ConstantStatusService::CREATEDSTATUS;
    $jsonData['message'] =ConstantApiMessageService::NewSmsResponse;
    return $jsonData;
  }

  public function updateStatus($token){
    $this->apiLogin->updateStatus($token);
  }
  public function changePassword($oldPassword,$newPassword,$confirmPassword){
    $userData=$this->apiLogin->getUserDetailByPassword($oldPassword);
    if(empty($userData)){
    $jsonResponse = array('message' => ConstantApiMessageService::InvalidPassword, 'status' => ConstantStatusService::UNAUTHORIZEDSTATUS);
    }else{
     $this->apiLogin->updatePassword($newPassword,$oldPassword);
     $jsonResponse = array('message' => ConstantApiMessageService:: SucessPasswordChangeMessage, 'status' => ConstantStatusService::CREATEDSTATUS);
    }
    return $jsonResponse;
  }

    public function newAuthKey($userId){
    $key = $userId . strtotime('YmdHis') . 'CMSEKBANA' . rand(ConstantService::ZeroValue, ConstantService::RandFourDigitNumber);
    $authKey = Hash::make($key);
    return $authKey;
  }
  public function checkUserName($userName){
   return $this->apiLogin->checkUserName($userName);
  }
    public function sendEmail($userId)
  {
    $userData=$this->apiLogin->getUserDetailById($userId);
    $emailData['email'] = $userData->email;
    $emailData['token']=$userData->token;
     if (empty($userData->middlename)) {
      $emailData['fullName'] = $userData->firstname . ' ' . $userData->last_name;
    } else {
      $emailData['fullName'] = $userData->firstname . ' ' . $userData->middle_name . ' ' . $userData->last_name;
    }
    $emailData['subject'] = ConstantApiMessageService::EmailSubject;
    $validEmail = $this->isValidEmail($emailData['email']);
    if (!empty($validEmail) && (!empty($emailData['email']))) {
      Mail::send('api.email.email', $emailData, function ($message) use ($emailData) {
        $message->from('info@ekbana.com', 'Admin');
        $message->to($emailData['email'], $emailData['fullName'])->subject($emailData['subject']);
      });
      $emailResponse = $this->emailConfirmResponse();
    } else {
      $emailResponse['message'] = ConstantApiMessageService::InvalidEmailMessage;
      $emailResponse['status'] = ConstantStatusService::UNAUTHORIZEDSTATUS;
    }
    return $emailResponse;
  }
  public function forgotPassword($email,$id){ 
  $userData=$this->apiLogin->getUserByIdEmail($email,$id);
  if(empty($userData)){
     $jsonData['message'] = ConstantApiMessageService::NoDataAvailable;
      $jsonData['status'] = ConstantStatusService::NoContentStatus;
  }else{
    $nowTime=$this->dateTime();
    $nowTimeStamp = strtotime($nowTime);
    $modifiedTimeStamp=strtotime($userData->modified_at);
    $realTimeStamp=$nowTimeStamp-$modifiedTimeStamp;
    $token=bin2hex(openssl_random_pseudo_bytes(16));
  if(!empty($userData)){
  if($userData->no_of_attempt==ConstantService::noOfAttemptThree){
    if(USERREGISTRATIONBLOCKTIME<=$realTimeStamp)
    {
    $noOfAttempt=ConstantService::ZeroValue;
    $this->apiLogin->updateNoOfAttempt($userData->id,$noOfAttempt);
    $this->apiLogin->updateToken($email,$id,$token,$noOfAttempt);
    $jsonData=$this->sendEmailForForgotPassword($userData,$token);
    }
      $jsonData=$this->blockMessage();
    }else{
  $noOfAttempt=$userData->no_of_attempt+1;
  $jsonData=$this->sendEmailForForgotPassword($userData,$token);
  $this->apiLogin->updateToken($email,$id,$token,$noOfAttempt);
  }
  
  }
    return $jsonData;
}
return $jsonData;
  }
  public function confirmForgotPassword($id,$newPassword,$confirmPassword,$token){
   $userDetail=$this->apiLogin->getDetailByToken($token);
   if(empty($userDetail)){
   $jsonData['status'] = ConstantStatusService::UNAUTHORIZEDSTATUS;
    $jsonData['message'] = ConstantApiMessageService::UnauthorizeTokenMessage;
    return $jsonData;
   }else{
    $this->apiLogin->updateNewPassword($id,$newPassword);
    $jsonData['status'] = ConstantStatusService::OKSTATUS;
    $jsonData['message'] = ConstantApiMessageService::SucessPasswordChangeMessage;
    return $jsonData;
   }
   
  }
  public function checkUniqueField($dbField,$dbValue){
    return $this->apiLogin->checkUniqueField($dbField,$dbValue);
  }

  public function checkUserNamePasswordDynamic($password,$userName,$dbField){
    return $this->apiLogin->checkUserNamePasswordDynamic($password,$userName,$dbField);
  }

  public function checkLogin($deviceId,$userData){
  $deviceData=$this->authorization->checkDeviceId($deviceId);
  if(!empty($deviceData))$this->authorization->deleteDevice($deviceId);
  $data['auth_token']=$this->newAuthKey($userData->id);
  $data['user_id']=$userData->id;
  $data['device_id']=$deviceId;
  $data['date']=$this->dateTime();
  $data['created_at']=$this->dateTime();
  $authid=$this->authorization->addAuthToken($data);
  $authKey=$this->authorization->getAuthTokenById($authid);
  return array('message'=>ConstantApiMessageService::LoginSucessMessage,'status'=>ConstantStatusService::OKSTATUS,'authKey'=>$authKey);
  }
  public function blockMessage(){
    $jsonData['status'] = ConstantStatusService::UNAUTHORIZEDSTATUS;
    $jsonData['message'] = ConstantApiMessageService::BlockMessage;
    return $jsonData;
  }

      public function sendEmailForForgotPassword($userData,$token)
  {
    $emailData['email'] = $userData->email;
    $emailData['token']=$token;
     if (empty($userData->middlename)) {
      $emailData['fullName'] = $userData->firstname . ' ' . $userData->last_name;
    } else {
      $emailData['fullName'] = $userData->firstname . ' ' . $userData->middle_name . ' ' . $userData->last_name;
    }
    $emailData['subject'] = ConstantApiMessageService::ForgotEmailSubject;
    $validEmail = $this->isValidEmail($emailData['email']);
    if (!empty($validEmail) && (!empty($emailData['email']))) {
      Mail::send('api.email.forgotPassWord', $emailData, function ($message) use ($emailData) {
        $message->from('info@ekbana.com', 'Admin');
        $message->to($emailData['email'], $emailData['fullName'])->subject($emailData['subject']);
      });
      $emailResponse = $this->forgotEmailResponse();
    } else {
      $emailResponse['message'] = ConstantApiMessageService::InvalidEmailMessage;
      $emailResponse['status'] = ConstantService::UNAUTHORIZEDSTATUS;
    }
    return $emailResponse;
  }

 public function forgotEmailResponse(){
  $jsonData['status'] = ConstantStatusService::OKSTATUS;
    $jsonData['message'] = ConstantApiMessageService::forgotEmailResponse;
    return $jsonData;
 }

    public function emailConfirmResponse()
  {
    $jsonData['status'] = ConstantStatusService::CREATEDSTATUS;
    $jsonData['message'] = ConstantApiMessageService::createdEmailResponse;
    return $jsonData;
  }
    public function isValidEmail($email)
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL)
    && preg_match('/@.+\./', $email);
  }

   public function dateTime()
  {
    $dateTime = Carbon::now('Asia/Kathmandu');
    return $dateTime->toDateTimeString();
  }
  public function login($inputData){
  $checkUserData=$this->apiLogin->checkUserNamePassword($inputData['password'],$inputData['userName']);
  if(!empty($checkUserData)){
    if(LOGINCONFIGURATION != 'email' &&  $checkUserData->status=='New'){
      $jsonResponse=$this->loginProcess($inputData['deviceId'],$checkUserData);
      }
  elseif(LOGINCONFIGURATION=='email' && $checkUserData->status=='Active'){
  $jsonResponse=$this->loginProcess($inputData['deviceId'],$checkUserData);
  }elseif(LOGINCONFIGURATION=='email' && $checkUserData->status=='New'){
      $jsonResponse = array('message' => ConstantApiMessageService::EmailVerifyMessage, 'status' => ConstantStatusService::CREATEDSTATUS,'authKey'=>'');
  }
  return $jsonResponse;
  }else{
      $jsonResponse = array('message' => ConstantApiMessageService::LoginFailureMessage, 'status' => ConstantStatusService::CREATEDSTATUS,'authKey'=>'');
    return $jsonResponse;
  }
  }

  public function loginProcess($deviceId,$checkUserData){
      $deviceData=$this->authorization->checkDeviceIdByUserId($deviceId,$checkUserData->id);
      $allDeviceData=$this->authorization->checkDeviceId($deviceId);
      $userData=$this->apiLogin->getUserDetailById($checkUserData->id);
      $authData=$this->authorization->getDataByUserId($checkUserData->id);
      if(!empty($deviceData)){
       $authKey=$deviceData->auth_token;
      $authId=$deviceData->id;
      }elseif(empty($deviceData)&&!empty($allDeviceData)){
      $this->authorization->deleteDevice($deviceId);
      $authKey=$this->newAuthKey($checkUserData->id);
      $authId=$this->authorization->addAuthToken($checkUserData->id,$deviceId,$authKey);
      }else{
      $authKey=$this->newAuthKey($checkUserData->id);
      $authId=$this->authorization->addAuthToken($checkUserData->id,$deviceId,$authKey);
      }
      $authData=$this->authorization->getAuthTokenById($authId);
      $jsonResponse = array('message' => ConstantApiMessageService::LoginSucessMessage, 'status' => ConstantStatusService::OKSTATUS,'authKey'=>$authData->auth_token);
      return $jsonResponse;
  }

}

