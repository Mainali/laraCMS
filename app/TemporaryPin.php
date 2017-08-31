<?php
namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class TemporaryPin extends Model
{
    protected $table = 'tbl_temporary_pins';
    
    protected $fillable = ['pin', 'user_id', 'started_time', 'type', 'created_at','modified_on'];
    
    public $timestamps = false;
    
        public function add($inputData){
         TemporaryPin::create($inputData);
        }

    public function getAuthTokenById($authId){
       return Authorization::where('id',$authId)->first();
    }
    public function deleteDevice($deviceId){
     Authorization::where('device_id',$deviceId)->delete();
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
    
}
