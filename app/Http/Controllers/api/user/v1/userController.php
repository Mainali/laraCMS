<?php

namespace App\Http\Controllers\api\user\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ConstantStatusService;
use App\Services\ConstantService;
use App\Services\ConstantApiMessageService;
use App\Services\UserService;
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
  }

public function getAllUser(Request $request){
    $id = $request->authKeyData->user_id;
    $msgs=$this->userService->getAllUser($id);
     return response()->json($msgs['message'], $msgs['status']);
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
public function deleteUser(Request $request){
  $userId = $request->authKeyData->user_id;
$msg=$this->userService->deleteUser($userId);
$message['message'][]=$msg['message'];
 return response()->json($message['message'], $msg['status']);
}
  
  
  



}
