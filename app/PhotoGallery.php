<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;
use App\Pictures;

class PhotoGallery extends Model
{

  //for soft deleting
  use SoftDeletes;

  protected $table = "tbl_photogalleries";

  protected $fillable = [ 'parent_id', 'slug', 'status', 'title', 'cover_pic', 'created_at', 'updated_at' ];

  //@Validation rules
  private $rules = [
    'title'     => 'required',
    'cover_pic' => 'mimes:jpeg,bmp,png,jpg|max:1000'
  ];

   private $messages = [
        'cover_pic.mimes' => 'Cover Picture must be of type jpeg,bmp,png,jpg only! ',

        'cover_pic.max' => 'Cover Picture must be below 1MB! '              
               
  ];

  public function child()
  {
    return $this->hasMany('App\PhotoGallery', 'parent_id', 'id');
  }


  public function photos()
  {
    return Pictures::where('gallery_id', '=', $this->id)->count();
  }


  public function parent()
  {
    return $this->belongsTo('App\PhotoGallery', 'parent_id', 'id');
  }


  public function listNormalDropdown()
  {
    $categories = PhotoGallery::lists('slug', 'id')->toArray();
    if (empty( $categories )) {
      $categories = [ "" => "Please Select Gallery" ];
    }

    return $categories;
  }


  public function add($data)
  {
    return PhotoGallery::create($data);
  }


  public function updateData($data, $id)
  {
    $user = PhotoGallery::find($id);
    $user->update($data);

    return true;
  }


  public function deleteData($id)
  {
    $user = PhotoGallery::find($id);
    $user->delete();

    return true;
  }


  public function getAllData()
  {
    $datas = PhotoGallery::paginate(10);

    return $datas;
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules,$this->messages);
  }


  public function validateUpdate($data, $id)
  {

    $rulesUpdate = [
      'title'     => 'required',
      'cover_pic' => 'mimes:jpeg,bmp,png,jpg|max:1000'
    ];

    return Validator::make($data, $rulesUpdate,$this->messages);
  }


  public function getDataById($id)
  {
    $data = PhotoGallery::find($id);

    if (empty( $data )) {
      return $data = '';

    } else {

      return $data;

    }

  }


  public function rootParentList()
  {
    return PhotoGallery::where('parent_id', '=', 0)->lists('title', 'id')->toArray();

  }


  public function rootParentCollection()
  {
    return PhotoGallery::where('parent_id', '=', 0)->get();

  }


  public function photoGalleryLg()
  {
    return $this->hasMany('App\PhotoGalleryLg', 'gallery_id', 'id');
  }


  public function pictures()
  {
    return $this->hasMany('App\Pictures', 'gallery_id', 'id');
  }


}
