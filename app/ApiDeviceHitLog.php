<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiDeviceHitLog extends Model
{
    protected $table = 'tbl_api_device_hit_logs';
    
    protected $fillable = ['api_type_id', 'device_id', 'created_at'];
    
    public $timestamps = false;
    
    public function add($data)
    {
        return ApiDeviceHitLog::create($data);
    }
}
