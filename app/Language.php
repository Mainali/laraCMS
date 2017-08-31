<?php

namespace App;

use Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{

  //for soft deleting
  //use SoftDeletes;
  protected $table = "tbl_languages";

  protected $fillable = [ 'slug', 'flag', 'status', 'title' ];

  //@Validation rules
  // private $rules = array(
  //   'username' => 'required|min:3|unique:tbl_admin_login,username',
  //   'password' => 'required|min:3',
  //   'email' => 'required|email|unique:tbl_admin_login,email',
  //   'first_name'  => 'required|min:3',
  //   'last_name'  => 'required',
  //   'modules_permission' => 'required',
  //   'profile_pic' => 'mimes:jpeg,bmp,png,jpg|max:1000'
  // );

  // private $rulesUpdate = array(
  //   'first_name'  => 'required|min:3',
  //   'last_name'  => 'required',
  //   'modules_permission' => 'required',
  //   'profile_pic' => 'mimes:jpeg,bmp,png,jpg|max:1000',
  //   'username' => 'required|min:3|unique:tbl_admin_login,username,\$this->get("id")'
  // );

  private $rules = [
    'multilang_id' => 'required',
    'status'       => 'required',
    'flag'         => 'required|mimes:jpeg,bmp,png,jpg|max:1000'
  ];

   private $messages = [
        'multilang_id.required' => 'you need to select Title! '              
  ];

  public function add($data)
  {
    return Language::create($data);
  }


  public function edit($data, $id)
  {
    $user = Language::find($id);
    $user->update($data);
  }


  public function updateData($data, $id)
  {
    $user = Language::find($id);
    $user->update($data);

    return true;
  }


  public function deleteData($id)
  {
    $user = Language::find($id);

    return $user->delete();
  }


  public function deleteDataPerm($id)
  {
    $user = Language::find($id);

    return $user->forceDelete();
  }


  public function getAllData()
  {
    $datas = Language::paginate(10);

    return $datas;
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules,$this->messages);
  }


  public function validateUpdate($data, $id)
  {

    $rulesUpdate = [
      'status' => 'required',
      'flag'   => 'mimes:jpeg,bmp,png,jpg|max:1000'
    ];

    return Validator::make($data, $rulesUpdate);
  }


  public function langSlugArray()
  {
    $languageSlugList = Language::where('status', 'active')->lists('slug', 'id')->toArray();
    if (empty( $languageSlugList )) {
      return [ ];
    } else {
      return $languageSlugList;
    }

  }


  public function getDataById($id)
  {
    $data = Language::where('id', $id)->first();
    if (empty( $data )) {
      return $data = '';
    } else {
      return $data;
    }
  }


  public function pagesLg()
  {
    return $this->hasMany('App\PageLg', 'language_id', 'id');
  }


  public function picturesLg()
  {
    return $this->hasMany('App\PicturesLg', 'language_id', 'id');
  }


  public function getAllDataNoPagination()
  {
    $datas = Language::all();

    return $datas;
  }


  public function whereClause($fparam, $sparam, $isObject = false)
  {
    if ($isObject === true) {
      $datas = Language::where($fparam, '=', $sparam)->first();
    } else {
      $datas = Language::where($fparam, '=', $sparam)->get();
    }

    return $datas;
  }


  public function whereClauseAnd($fparam, $sparam, $thirdParam, $fourthParam, $isObject = false)
  {
    if ($isObject === true) {
      $datas = Language::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->first();
    } else {
      $datas = Language::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->get();
    }

    return $datas;
  }


}
