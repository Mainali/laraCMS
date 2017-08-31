<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;

class PicturesLg extends Model
{

  //for soft deleting
  use SoftDeletes;

  protected $table = "tbl_pictures_lg";

  protected $fillable = [ 'picture_id', 'language_id', 'caption', 'status', 'created_at', 'updated_at' ];

  //@Validation rules
  private $rules = [
    'language_id' => 'required',
    'picture_id'  => 'required',
    'status'      => 'required'
  ];

   private $messages = [
        'language_id.required' => 'Please input Language ! ',
        'picture_id.required' => 'Please input Picture ! '               
  ];

  public function add($data)
  {
    return PicturesLg::create($data);
  }


  public function updateData($data, $id)
  {
    $user = PicturesLg::find($id);
    $user->update($data);

    return true;
  }


  public function deleteData($id)
  {
    $user = PicturesLg::find($id);
    $user->delete();

    return true;
  }


  public function getAllData()
  {
    $datas = PicturesLg::paginate(10);

    return $datas;
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules,$this->messages);
  }


  public function validateUpdate($data, $id)
  {

    $rulesUpdate = [
      'language_id' => 'required',
      'status'      => 'required'
    ];

    return Validator::make($data, $rulesUpdate,$this->messages);
  }


  public function getDataById($id)
  {
    $data = PicturesLg::find($id);

    if (empty( $data )) {
      return $data = '';

    } else {

      return $data;

    }

  }


  public function languages()
  {
    return $this->belongsTo('App\Language', 'language_id', 'id');
  }


  public function pictures()
  {
    return $this->belongsTo('App\Pictures', 'picture_id', 'id');
  }


  public function getAllDataNoPagination()
  {
    $datas = PicturesLg::all();

    return $datas;
  }

}
