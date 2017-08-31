<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ApiCategories;

class ApiType extends Model
{
    protected $table = 'tbl_api_type';
    
    protected $fillable = ['type', 'total_calls', 'api_name', 'category_id','version','manual_response', 'api_id', 'api_method', 'api_description', 'api_url'];
    
    public $timestamps = false;
    
    public function getAllData() {
        $datas = ApiType::paginate(20);
        return $datas;
    }
    public function getCategorieslist() {
        $data=[''=>'Select Category']+ApiCategories::lists('title','id')->toArray();
        return $data;
    }

    public function getDataById($id) {
        $data = ApiType::where('id', $id)->first();
        return $data;
    }

    public function getDataByCategoryId($categoryId) {
        $data = ApiType::where('category_id', $categoryId)->first();
        return $data;
    }
    
    public function getDataByApiId($apiId) {
        $data = ApiType::where('api_id', $apiId)->first();
        return $data;
    }
    
    public function add($data) {
        return ApiType::create($data);
    }
    public function edit($totalCalls, $apiId) {
        $apiType = ApiType::where('api_id', $apiId)->update(array('total_calls'=>$totalCalls));
    }
    public function deleteData($id) {
        $apiType = ApiType::find($id);
        return $apiType->delete();
    }
    public function getFilteredList($fil) {
        return ApiType::where('category_id', $fil)->get();
    }

    public function api_category()
    {
        return $this->belongsTo('App\ApiCategories','category_id','id');
    }
}
