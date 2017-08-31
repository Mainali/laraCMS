<?php
namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class MobileBuilt extends Model
{
    protected $table = 'tbl_apk_built';
    
    protected $fillable = ['title', 'description', 'status', 'apk','apk_version','created_on'];
    
    public $timestamps = false;

   public function getAllBuilt(){
        return MobileBuilt::orderBy('created_on','DESC')->get();
    }
    public function getDataById($id) {
        $data = MobileBuilt::where('id', $id)->first();
        return $data;
    }
    public function getDataByApiId($apiId) {
        $data = ApiProject::where('api_id', $apiId)->first();
        return $data;
    }
    
    public function add($data) {
        return MobileBuilt::create($data);
    }
    public function edit($data, $id) {
     MobileBuilt::where('id', $id)->update($data);
    }
    public function deleteApk($id) {
        $ApiProject = MobileBuilt::find($id);
        return $ApiProject->delete();
    }

    public function getProjectsAsList()
    {
        $data=[''=>'Select Project']+ApiProject::lists('title','id')->toArray();
        return $data;
    }

    public function getOneProjectsAsList($pid)
    {
        $data = ApiProject::where('id',$pid)->lists('title','id')->toArray();
        return $data;
    }

    public function getProjectsFromIds($ids)
    {
        return ApiProject::whereIn('id', $ids)->get();
    }

    public function projectExists($pid)
    {
        $data = ApiProject::where('id',$pid)->where('status','Publish')->get();
        if(!is_null($data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function updateStatusToInactive($id){
   return MobileBuilt::where('id',$id)->update(array('status'=>'Inactive'));
    }
    public function getAllId(){
        return MobileBuilt::lists('id')->toArray();
    }
    public function updateStatus($id){
     return MobileBuilt::where('id',$id)->update(array('status'=>'Active'));   
    }
    public function getApiVersion(){
       return MobileBuilt::where('status','Active')->pluck('apk_version');  
    }
      public function getApK(){
       return MobileBuilt::where('status','Active')->pluck('apk');  
    }
    
}