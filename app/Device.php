<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'tbl_devices';
    
    protected $fillable = ['device_id', 'device_token', 'created_on','updated_on'];
    
    public $timestamps = false;
    
    public function add($data)
    {
        return Device::create($data);
    }
}
