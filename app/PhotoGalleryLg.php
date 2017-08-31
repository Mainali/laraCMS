<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;

class PhotoGalleryLg extends Model
{

  //for soft deleting
  use SoftDeletes;

  protected $table = "tbl_photogalleries_lg";

  protected $fillable = [
    'gallery_id',
    'language_id',
    'title',
    'description',
    'status',
    'meta_title',
    'meta_description',
    'keyword'
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
    return PhotoGalleryLg::create($data);
  }


  public function edit($data, $id)
  {
    $user = PhotoGalleryLg::find($id);
    $user->update($data);
  }


  public function updateData($data, $id)
  {
    $user = PhotoGalleryLg::find($id);
    $user->update($data);

    return true;
  }


  public function deleteData($id)
  {
    $user = PhotoGalleryLg::find($id);

    return $user->delete();
  }


  public function getAllData()
  {
    $datas = PhotoGalleryLg::paginate(10);

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
    $data = PhotoGalleryLg::where('id', $id)->first();
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


  public function gallery()
  {
    return $this->belongsTo('App\PhotoGallery', 'gallery_id', 'id');
  }


  public function getAllDataNoPagination()
  {
    $datas = PhotoGalleryLg::all();

    return $datas;
  }


}
