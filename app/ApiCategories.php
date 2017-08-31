<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ApiType;

class ApiCategories extends Model
{
    protected $table = 'tbl_api_categories';
    
    protected $fillable = ['title'];
    
    public $timestamps = false;
    
    public function getAllData() {
        $datas = ApiCategories::paginate(20);
        return $datas;
    }
    public function getDataById($id) {
        $data = ApiCategories::where('id', $id)->first();
        return $data;
    }

    public function getDataByTitle($title) {
        $data = ApiCategories::where('title', $title)->first();
        return $data;
    }

    public function add($data) {
        return ApiCategories::create($data);
    }
    public function edit($data, $id) {
        $apiType = ApiCategories::where('id', $id);
        return $apiType->update($data);
    }
    public function deleteData($id) {
        $apiType = ApiCategories::find($id);
        return $apiType->delete();
    }
    public function api_type()
    {
        return $this->hasMany('App\ApiType','category_id','id');
    }
    
}
