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
use File;
use Hash;
use Carbon\Carbon;
use App\ApiLogin;
use App\ApiUserHitLog;

/**
 * The UserService class.
 *
 * @author Rubens Mariuzzo <rubens@mariuzzo.com>
 */
class UserService
{


  /*
   *@call the constructor
   */

  public function __construct()
  {
     $this->apiLogin = new ApiLogin;
     $this->authorization= new Authorization;
     $this->apiLogin = new ApiLogin;
     $this->apiUserHitLog = new ApiUserHitLog;

  }
  public function getAllUser($id){
    $userDetail=$this->apiLogin->getUserDetailById($id);
    $userData=$this->userResponse($userDetail);
     $jsonResponse = array('message' =>$userData , 'status' => ConstantStatusService::OKSTATUS);
      return $jsonResponse;
  }
public function userResponse($userDetail){
  $jsonData['firstName']=$userDetail->firstname;
  $jsonData['middleName']=$userDetail->middlename;
  $jsonData['lastName']=$userDetail->lastname;
    if (empty($userDetail->middle_name)) {
      $jsonData['fullName'] = $userDetail->firstname . ' ' . $userDetail->lastname;
    } else {
      $jsonData['fullName'] = $userDetail->firstname . ' ' . $userDetail->middlename . ' ' . $userDetail->lastname;
    }
  $jsonData['gender']=$userDetail->gender;
  $jsonData['address']=$userDetail->address;
  $jsonData['mobile']=$userDetail->mobile;
  if(empty($userDetail->profile_picture))$jsonData['profilePicture']='';
  else$jsonData['profilePicture']=$userDetail->profile_picture;
  if(empty($userDetail->thumb_image))$jsonData['thumbImage']='';
  else$jsonData['thumbImage']=$userDetail->thumb_image;
  $jsonData['email']=$userDetail->email;
  return $jsonData;
}
public function deleteUser($userId){
  $this->authorization->deleteAuthData($userId);
  $this->apiLogin->deleteUser($userId);
  $this->apiUserHitLog->deleteUserById($userId);
  return array('message'=>ConstantApiMessageService::DeleteUserResponse,'status'=>ConstantStatusService::OKSTATUS);
}


}

