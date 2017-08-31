<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiUserHitLog extends Model
{
    protected $table = 'tbl_api_user_hit_logs';
    
    protected $fillable = ['api_type_id', 'user_id', 'created_at'];
    
    public $timestamps = false;
    
    public function add($data)
    {
        return ApiUserHitLog::create($data);
    }
    public function deleteUserById($userId){
     return ApiUserHitLog::where('user_id',$userId)->delete();	
    }
}
