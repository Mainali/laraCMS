<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;


class Banner extends Model
{

  //for soft deleting
  use SoftDeletes;

  protected $table = "tbl_banner";

  protected $fillable = [ 'image', 'position','link', 'status','created_at', 'updated_at' ];

  //@Validation rules
  //The title check is for default language title,only validation rule is taken from here
  private $rules = [
    
    'position' => 'numeric',
    'title'    => 'min:3|unique:tbl_banner_lg,title',
  ];

  public function add($data)
  {
    return Banner::create($data);
  }


  public function updateData($data, $id)
  {
    $user = Banner::find($id);
    $user->update($data);

    return true;
  }


  public function deleteData($id)
  {
    $user = Banner::find($id);
    $user->delete();

    return true;
  }


  public function getAllData()
  {
    $datas = Banner::paginate(10);

    return $datas;
  }
  
  public function getAllDataNoPagination() {
    $datas = Banner::all();
    
    return $datas;
  }

  public function getAllOrderBy() {
        
    return Banner::orderBy('position')->get();
  }

  public function validate($data)
  {
    return Validator::make($data, $this->rules);
  }


  public function validateUpdate($data, $id)
  {

    $rulesUpdate = [
      'position' => 'numeric',
      'title'    => 'min:3|unique:tbl_banner_lg,title,' . $id. ',id'
    ];

    return Validator::make($data, $rulesUpdate);
  }


  public function getDataById($id)
  {
    $data = Banner::find($id);

    if (empty( $data )) {
      return $data = '';

    } else {

      return $data;

    }

  }


  


  public function bannerLg()
  {
    return $this->hasMany('App\BannerLg', 'banner_id', 'id');
  }


}
