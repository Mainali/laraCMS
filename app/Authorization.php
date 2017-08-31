<?php
namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $table = 'tbl_authorization';
    
    protected $fillable = ['auth_token', 'user_id', 'device_id', 'date', 'created_at'];
    
    public $timestamps = false;
    
    public function addAuthToken($thisData){
    $data=Authorization::create($thisData);
    return $data->id;
    }

    public function getAuthTokenById($authId){
       return Authorization::where('id',$authId)->pluck('auth_token');
    }

    public function getAuthTokenByUserId($userId)
    {
      $data =  Authorization::select('auth_token')->where('user_id',$userId)->first();
      if(!is_null($data)) return $data->pluck('auth_token'); else return $data; 
    }

    public function deleteDevice($deviceId){
     Authorization::where('device_id',$deviceId)->delete();
    }
    public function checkDeviceIdByUserId($deviceId,$userId){
     return Authorization::where('device_id',$deviceId)->where('user_id',$userId)->first();
    }
     public function checkDeviceId($deviceId){
     return Authorization::where('device_id',$deviceId)->first();
    }
    public function getDataByAuthKey($authKey){
    return Authorization::where('auth_token',$authKey)->first();
    }
    public function getDataByUserId($userId){
    return Authorization::where('user_id',$userId)->first();
    }

      public function dateTime()
  {
    $dateTime = Carbon::now('Asia/Kathmandu');
    return $dateTime->toDateTimeString();
  }
  public function getUserId($authKey){
    return Authorization::where('auth_token',$authKey)->pluck('user_id');
  }
    public function deleteDeviceId($deviceId){
      return Authorization::where('device_id',$deviceId)->delete();
    }
    public function getDataByDeviceId($deviceId){
      return Authorization::where('device_id',$deviceId)->first();
    }
    public function deleteAuthData($userId){
      return Authorization::where('user_id',$userId)->delete();
    }
}
