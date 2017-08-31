<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;

class Pictures extends Model
{

  //for soft deleting
  use SoftDeletes;

  protected $table = "tbl_pictures";

  protected $fillable = [ 'gallery_id', 'picture', 'status', 'created_at', 'updated_at' ];

  //@Validation rules
  private $rules = [
    'gallery_id' => 'required',
    'status'     => 'required',
    'picture'    => 'required|mimes:jpeg,bmp,png,jpg|max:1000'
  ];

   private $messages = [
        'gallery_id.required' => 'Please,Select a gallery ! '              
  ];

  // public function pageList()
  // {
  // $categories =Pictures::lists('slug', 'id')->toArray();
  // return $categories;
  // }

  public function add($data)
  {
    return Pictures::create($data);
  }


  public function updateData($data, $id)
  {
    $user = Pictures::find($id);
    $user->update($data);

    return true;
  }


  public function deleteData($id)
  {
    $user = Pictures::find($id);
    if ($user->delete()) {
      return true;
    } else {
      return false;
    }

  }


  public function getAllData()
  {
    $datas = Pictures::paginate(10);

    return $datas;
  }


  public function listByGallery($id)
  {
    $datas = Pictures::where('gallery_id', '=', $id)->paginate(10);

    return $datas;
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules,$this->messages);
  }


  public function validateUpdate($data, $id)
  {

    $rulesUpdate = [
      'gallery_id' => 'required',
      'status'     => 'required',
      'picture'    => 'required|mimes:jpeg,bmp,png,jpg|max:1000'
    ];

    return Validator::make($data, $rulesUpdate,$this->messages);
  }


  public function getDataById($id)
  {
    $data = Pictures::find($id);

    if (empty( $data )) {
      return $data = '';

    } else {

      return $data;

    }

  }


  public function gallery()
  {
    return $this->belongsTo('App\PhotoGallery', 'gallery_id', 'id');
  }


  public function picturesLg()
  {
    return $this->hasMany('App\PicturesLg', 'picture_id', 'id');
  }


}
