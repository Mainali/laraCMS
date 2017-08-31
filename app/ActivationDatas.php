<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ActivationDatas extends Model
{
    protected $table = 'tbl_activation_datas';
	public $timestamps = false;
 protected $fillable = ['status', 'fullname', 'operator_id','passport_num', 'citizenship_num','visa_num','country_num','sim_num', 'country', 'user_image','passport_image_1','passport_image_2','country_id_image_1','country_id_image_2','visa_image','form_image','sim_image','last_updated_on','last_updated_by','last_update_status','created_date'];

  public function scopeStatus($query,$status)
  {
    if($status == "any")
      return $query;
    else
      return $query->where('status',$status);
  }

  public function getAllData()
  {
    return ActivationDatas::all();
  }

  public function scopeTrashed($query,$trashed)
  {
    if($trashed == "any")
      return $query;
    else
      return $query->where('trashed',$trashed);
  }

	public function getAllActivionData()
  	{
  		return ActivationDatas::where('trashed',0)->orderBy('created_date', 'desc')->paginate(10);
  	}
    public function imageSyncStatus($id){
     return ActivationDatas::where('id',$id)->update(array('image_synced'=>'1'));
    }
    public function getDataById($id) {
        $data = ActivationDatas::where('id', $id)->first();
        return $data;
    }
  	public function addActivationDatas($data){
  		$data=ActivationDatas::create($data);
      return $data->id;
  	}
    public function edit($data, $id) {
        $Act = ActivationDatas::where('id', $id);
        return $Act->update($data);
    }
  	public function changeStatus($id,$status){
  		ActivationDatas::where('id',$id)->update(array('status'=>$status));
  	}
    public function searchDynamicFields($dbField, $dbValue){
   return ActivationDatas::where($dbField, $dbValue)->first();
    }

  public function updateImage($InsertData,$id){
    return ActivationDatas::where('id',$id)->update($InsertData);
 }
 public function updateStatus($id,$status){
 ActivationDatas::where('id',$id)->update(array('status'=>$status));
 }

    public function searchByCitizenNumber($citizenNumber){
       return ActivationDatas::where('citizenship_num',$citizenNumber)->first();
    }
    public function deleteDatas($id){
      ActivationDatas::where('id',$id)->delete(); 
    }
    public function getActivationDatasById($id){
      return ActivationDatas::where('id',$id)->first();
    }
    public function editVisaImage($image,$id){
return ActivationDatas::where('id',$id)->update(array('visa_image'=>$image));
    }
    public function editPassportImage1($image,$id){
      return ActivationDatas::where('id',$id)->update(array('passport_image_1'=>$image));
    }
    public function editPassportImage2($image,$id){
     return ActivationDatas::where('id',$id)->update(array('passport_image_2'=>$image)); 
    }
     public function editCountryImage1($image,$id){
     return ActivationDatas::where('id',$id)->update(array('country_id_image_1'=>$image)); 
    }
       public function editCountryImage2($image,$id){
     return ActivationDatas::where('id',$id)->update(array('country_id_image_2'=>$image)); 
    }
    public function editformImage($image,$id){
      return ActivationDatas::where('id',$id)->update(array('form_image'=>$image));
    }
    public function editSimImage($image,$id){
      return ActivationDatas::where('id',$id)->update(array('sim_image'=>$image));
    }
    public function editUserImage($image,$id){
     return ActivationDatas::where('id',$id)->update(array('user_image'=>$image)); 
    }

    public function trash($id)
    {
      $data = ActivationDatas::where('id',$id)->first();
      $data->trashed =1;
      return $data->save();

    }

    public function multiTrash($data)
    {
      $data =ActivationDatas::whereIn('id', $data)->update(array('trashed'=>'1'));
      return $data;
    }

    public function filterByStatus($status)
    {
      if($status=="")
      {
        return ActivationDatas::where('status','Pending')->orderBy('created_date', 'desc')->paginate(10);
      }
      $data = ActivationDatas::where('status',$status)->orderBy('created_date', 'desc')->paginate(10);
      return $data;
    }

    public function getOnlyTrashedData()
    {
      return ActivationDatas::where('trashed',1)->orderBy('created_date', 'desc')->paginate(10);
    }

    public function getAllDataWithTrashed()
    {
      return ActivationDatas::orderBy('created_date', 'desc')->paginate(10);
    }

    public function filterDateAndKeyword($keywords,$date,$trashed,$status)
    {
     return ActivationDatas::where(function ($query) use ($trashed) {
            if($trashed == "any")
             $query;
          else
             $query->where('status',$status);
        })->where(function ($query) use ($status){
           if($status == "any")
             $query;
          else
             $query->where('status',$status);
                  
        })->where(function ($query) use ($date){
          
             $query->where('created_date','LIKE',''.$date.'%');
                  
        })->where(function ($query) use ($keywords){
            $query->where('fullname','LIKE','%'.$keywords.'%')->orWhere('country', 'LIKE','%'.$keywords.'%')->orWhere('passport_num','LIKE','%'.$keywords.'%')->orWhere('citizenship_num', 'LIKE','%'.$keywords.'%');
                  
        })->orderBy('created_date', 'desc')->paginate(10);
    }

    // public function filterKeyword($keywords,$trashed,$status)
    // {
    //   $data = ActivationDatas::trashed($trashed)->status($status)->where('fullname','LIKE','%'.$keywords.'%')->orWhere('country', 'LIKE','%'.$keywords.'%')->orWhere('passport_num','LIKE','%'.$keywords.'%')->orWhere('citizenship_num', 'LIKE','%'.$keywords.'%')->orderBy('created_date', 'desc')->paginate(10);
    //   return $data;
    // }

    public function filterKeyword($keywords,$trashed,$status)
    {

      return ActivationDatas::where(function ($query) use ($trashed) {
            if($trashed == "any")
             $query;
          else
             $query->where('status',$status);
        })->where(function ($query) use ($status){
           if($status == "any")
             $query;
          else
             $query->where('status',$status);
                  
        })->where(function ($query) use ($keywords){
            $query->where('fullname','LIKE','%'.$keywords.'%')->orWhere('country', 'LIKE','%'.$keywords.'%')->orWhere('passport_num','LIKE','%'.$keywords.'%')->orWhere('citizenship_num', 'LIKE','%'.$keywords.'%');
                  
        })->orderBy('created_date', 'desc')->paginate(10);
    }

    public function filterDate($date,$trashed,$status)
    {
      return ActivationDatas::where(function ($query) use ($trashed) {
            if($trashed == "any")
             $query;
          else
             $query->where('status',$status);
        })->where(function ($query) use ($status){
           if($status == "any")
             $query;
          else
             $query->where('status',$status);
                  
        })->where(function ($query) use ($date){
          
             $query->where('created_date','LIKE',''.$date.'%');
                  
        })->orderBy('created_date', 'desc')->paginate(10);
    }


    public function getCountRequestByDate()
    {
      $data = ActivationDatas::select(DB::raw('DATE(created_date) as date'), DB::raw('count(*) as total'))
                     //->where('status', '<>', 1)
                     ->groupBy('date')
                     ->orderBy('date','desc')
                     ->limit(7)
                     ->get();
                     return $data;
    }


}