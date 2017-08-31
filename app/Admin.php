<?php

namespace App;

use Illuminate\Auth\Authenticatable;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Validator;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract
{

  //for soft deleting
  //use SoftDeletes;
  use Authenticatable, CanResetPassword;

  protected $table = 'tbl_admin_login';

  public $timestamps = false;

  protected $fillable = [
    'username',
    'email',
    'password',
    'date_update',
    'date_create',
    'status',
    'type',
    'modules_permission',
    'first_name',
    'middle_name',
    'last_name',
    'profile_pic',
    'profile_edit_pic'
  ];

  protected $hidden = [ 'password', 'remember_token' ];

  //----------------------seeder stufffs-------------------//
  const FULLNAME = "Pukar";
  const USERNAME = "superadmin";
  const EMAIL = "mainalipukar@gmail.com";
  const PASSWORD = "123admin@";
  const MODULE = "all";
  //---------------------end seeder stuffs-------------------//

  //@Validation rules
  private $rules = [
    'username'           => 'required|min:3|unique:tbl_admin_login,username',
    'password'           => 'required|min:3',
    'email'              => 'required|email|unique:tbl_admin_login,email',
    'first_name'         => 'required|min:3',
    'last_name'          => 'required',
    'modules_permission' => 'required',
    'profile_pic'        => 'mimes:jpeg,bmp,png,jpg|max:1000'
  ];

  

  public function getSuperAdmin(){
    $datas = Admin::where('type','=','superadmin')->first();

    return $datas;
  }

  public function add($data)
  { 
    
    return Admin::create($data);
  }


  public function edit($data, $id)
  { 
    $user = Admin::find($id);
    $user->update($data);
  }


  public function deleteData($id)
  {
    $user = Admin::find($id);

    return $user->delete();
  }


  public function getAllData()
  {
    $datas = Admin::where('type','<>','superadmin')->paginate(10);

    return $datas;
  }


  public function getModulePermissions()
  {
    return Admin::where('id', $this->id)->pluck('modules_permission');
  }


  public function checkUsername($username)
  {
    $count = Admin::where('username', $username)->count();
    if ($count > 0) {
      return true;
    } else {
      return false;
    }
  }


  public function checkEmail($email)
  {
    $count = Admin::where('email', $email)->count();
    if ($count > 0) {
      return true;
    } else {
      return false;
    }
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules);
  }


  public function validateUpdate($data,$id)
  {
    $rulesUpdate = [
    'first_name'         => 'required|min:3',
    'last_name'          => 'required',
    // 'new_password'       => 'required_with:confirm_password',
    // 'confirm_password'   => 'required_with:new_password',
    'modules_permission' => 'required',
    'profile_pic'        => 'mimes:jpeg,bmp,png,jpg|max:1000',
    'email'              => 'required|email|unique:tbl_admin_login,email,'.$id,
    'username'           => 'required|min:3|unique:tbl_admin_login,username,'.$id,

  ];
    return Validator::make($data,$rulesUpdate);
  }


  public function getDataById($id)
  {
    $data = Admin::where('id', $id)->first();
    if (empty( $data )) {
      return $data = '';
    } else {
      return $data->toArray();
    }
  }

  public function getSingleAdminData($id)
  {
    $data = Admin::find($id);
    if (empty( $data )) {
      return $data = '';
    } else {
      return $data;
    }
  }
}
