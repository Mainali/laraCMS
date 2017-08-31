<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ApiConfig extends Model
{
    protected $table = 'tbl_api_keys';
    
    protected $fillable = ['api_keys', 'title', 'description', 'status', 'date_started', 'hits'];
    
    public $timestamps = false;
    
    public function getAllData() {
        $datas = ApiConfig::paginate(20);
        return $datas;
    }
    public function getDataById($id) {
        $data = ApiConfig::where('id', $id)->first();
        return $data;
    }
    
    public function getDataByApiKey($apiKey) {
        $data = ApiConfig::where('api_keys', $apiKey)->first();
        return $data;
    }
    
    public function add($data) {
        return ApiConfig::create($data);
    }
    public function edit($data, $id) {
        $apiConfig = ApiConfig::where('id', $id);
        return $apiConfig->update($data);
    }
    public function deleteData($id) {
        $apiConfig = ApiConfig::find($id);
        return $apiConfig->delete();
    }
}
