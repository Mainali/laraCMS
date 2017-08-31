<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;
use DB;
class BannerLg extends Model
{

  //for soft deleting
  use SoftDeletes;

  protected $table = "tbl_banner_lg";

  protected $fillable = [
    'banner_id',
    'language_id',
    'title',
    'description',
    'status',
    'updated_at',
    'created_at'
    
  ];

  private $rules = [
    // 'page_id' => 'required|unique:tbl_pages_lg,page_id',
    // 'language_id' => 'required|unique:tbl_pages_lg,language_id',
    // 'title' => 'required|min:3',
    'status' => 'required',
    // 'description' => 'required',
    // 'meta_title' => 'required',
    // 'meta_description' => 'required',
    // 'meta_description' => 'required'
  ];

  // private $rulesUpdate = array(
  //   'first_name'  => 'required|min:3',
  //   'last_name'  => 'required',
  //   'modules_permission' => 'required',
  //   'profile_pic' => 'mimes:jpeg,bmp,png,jpg|max:1000',
  //   'username' => 'required|min:3|unique:tbl_admin_login,username,\$this->get("id")'
  // );

  public function add($data)
  {
    return BannerLg::create($data);
  }


  public function edit($data, $id)
  {
    $user = BannerLg::find($id);
    $user->update($data);
  }


  public function updateData($data, $id)
  {
    $user = BannerLg::find($id);
    $user->update($data);

    return true;
  }


  public function deleteData($id)
  {
    $user = BannerLg::find($id);

    return $user->delete();
  }


  public function getAllData()
  {
    $datas = BannerLg::paginate(10);

    return $datas;
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules);
  }


  public function validateUpdate($data)
  {
    $rulesUpdate = [
      // 'page_id' => 'required|unique:tbl_pages_lg,page_id,'.$id,
      // 'language_id' => 'required|unique:tbl_pages_lg,language_id,'.$id,
      // 'title' => 'required|min:3'
      'status' => 'required',
      // 'description' => 'required',
      // 'meta_title' => 'required',
      // 'meta_description' => 'required',
      // 'meta_description' => 'required'
    ];

    return Validator::make($data, $rulesUpdate);
  }


  public function getDataById($id)
  {
    $data = BannerLg::where('id', $id)->first();
    if (empty( $data )) {
      return $data = '';
    } else {
      return $data->toArray();
    }
  }


  public function languages()
  {
    return $this->belongsTo('App\Language', 'language_id', 'id');
  }


  public function banner()
  {
    return $this->belongsTo('App\Banner', 'banner_id', 'id');
  }

  
  public function getAllDataNoPagination()
  {
    $datas = BannerLg::all();

    return $datas;
  }

  public function getAllBanners($language){
        return DB::table('tbl_banner')
                              ->join('tbl_banner_lg','tbl_banner.id','=','tbl_banner_lg.banner_id')
                              ->where('tbl_banner.status','=','active')
                              ->where('tbl_banner_lg.status','=','active')
                              ->whereNull('tbl_banner.deleted_at')
                              ->whereNull('tbl_banner_lg.deleted_at')
                              ->where('tbl_banner_lg.language_id','=',$language)
                              ->orderBy('tbl_banner.position','asc')
                              ->select('tbl_banner_lg.*','tbl_banner.image','tbl_banner.link')
                              ->get();
    }

}
