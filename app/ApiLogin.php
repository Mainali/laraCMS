<?php
namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class ApiLogin extends Model
{
    protected $table = 'tbl_api_login';
    
    protected $fillable = ['firstname', 'middlename', 'lastname', 'gender', 'address', 'mobile', 'profile_picture','thumb_image','last_login','status','no_of_attempt','pin','email','password','created_at','modified_at','username'];
    
    public $timestamps = false;

    public function getAllData() {
        $datas = ApiLogin::orderBy('last_login' ,'desc')->get();
        return $datas;
    }

    public function getWhereStatus($status)
    {
      return ApiLogin::where('status','=',$status)->get();
    }
    
    public function add($inputData){
     return ApiLogin::create($inputData);
    }
    public function checkUniqueField($dbField,$dbValue){
      return ApiLogin::where($dbField,$dbValue)->count();
    }
    public function checkUserName($userName){
    return ApiLogin::where('username',$userName)->where('status','New')->first();
    }
    public function getUserDetailById($userId){
     return ApiLogin::where('id',$userId)->first();
    }
    public function getUserByEmail($email){
      return ApiLogin::where('email',$email)->first();
    }
    public function updateNoOfAttempt($id,$noOfAttempt){
      $modifiedAt=$this->dateTime();
       ApiLogin::where('id',$id)->update(array('no_of_attempt'=>$noOfAttempt,
                                          'modified_at'=>$modifiedAt));
    }
    public function updateToken($email,$id,$token,$noOfAttempt){
       $modifiedAt=$this->dateTime();
      ApiLogin::where('id',$id)->where('email',$email)->update(array('token'=>$token,
                                          'modified_at'=>$modifiedAt,'no_of_attempt'=>$noOfAttempt));
    }
    public function updateNewPassword($id,$newPassword){
      ApiLogin::where('id',$id)->update(array('token'=>'','password'=>$newPassword));
    }
    public function getUserByIdEmail($email,$id){
    return ApiLogin::where('id',$id)->where('email',$email)->first();
    }
    public function getDetailByToken($token){
      return ApiLogin::where('token',$token)->first();
    }
    public function getUserDetailByPassword($password){
     return ApiLogin::where('password',$password)->first();
    }
    public function checkToken($token){
      return ApiLogin::where('token',$token)->first();
    }
    public function removeToken($id){
       ApiLogin::where('id',$id)->update(array('token'=>''));
    }
    public function updatePassword($newPassword,$oldPassword){
     ApiLogin::where('password',$oldPassword)->update(array('password'=>$newPassword));
    }
    public function updateStatus($token){
      $status='Active';
      ApiLogin::where('token',$token)->update(array('status'=>$status));
    }
      public function dateTime()
      {
        $dateTime = Carbon::now('Asia/Kathmandu');
        return $dateTime->toDateTimeString();
      }

      public function checkUserNamePasswordDynamic($password,$userName,$dbField){
            $hashPassword=md5($password);
      return ApiLogin::where('password', $hashPassword)
          ->where($dbField, $userName)->first();
    }

    public function checkUserNamePassword($password,$userName){
            $hashPassword=md5($password);
      return ApiLogin::where(function ($q) use ($hashPassword, $userName) {
      $q->where('password', $hashPassword)
        ->where('username', $userName);
    })
      ->orWhere(function ($q) use ($hashPassword, $userName) {
        $q->where('password', $hashPassword)
          ->where('email', $userName);
      })
      ->first();
    }

public function deleteUser($userId){
 return ApiLogin::where('id',$userId)->delete();
}



}
