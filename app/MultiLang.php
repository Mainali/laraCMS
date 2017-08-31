<?php

namespace App;

use Validator;
use DB;
use Illuminate\Database\Eloquent\Model;

use App\Language;

class MultiLang extends Model
{

  //for soft deleting

  protected $table = "tbl_multi_lang";

  protected $fillable = [ 'code', 'name', 'native', 'title' ];

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

  public function add($data)
  {
    return MultiLang::create($data);
  }


  public function edit($data, $id)
  {
    $user = MultiLang::find($id);
    $user->update($data);
  }


  public function deleteData($id)
  {
    $user = MultiLang::find($id);

    return $user->delete();
  }


  public function getAllData()
  {
    $datas = MultiLang::paginate(10);

    return $datas;
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules);
  }


  public function validateUpdate($data)
  {
    return Validator::make($data, $this->$rulesUpdate);
  }


  public function multiLangList()
  {
    return [ '' => 'Select Language' ] + MultiLang::select(DB::raw("CONCAT(name,' (',native,')')AS full_name,id"))->whereNotIn('code',
      Language::select('slug')->get()->toArray())->lists('full_name', 'id')->toArray();
  }


  public function getDataById($id)
  {
    $data = MultiLang::find($id);

    if (empty( $data )) {
      return $data = '';

    } else {

      return $data;

    }

  }

}
