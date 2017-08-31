<?php

namespace App\Services;

use App\Admin;
use Image;
use File;
use Hash;
use Illuminate\Support\Facades\Auth;
class AdminService
{ 

  public function __construct()
  {
    $this->adminModel = new Admin;
  }


  public function getSuperAdmin()
  {
    return $this->adminModel->getSuperAdmin();
  }

  public function create($data)
  {
    $password = bcrypt($data['password']);
    $modules  = $data['modules_permission'];
    $module   = 'home,';
    foreach ($modules as $mod) {
      $module = $module . $mod . ',';
    }
    $implodeData                      = rtrim($module, ',');
    $insertData['username']           = $data['username'];
    $insertData['password']           = $password;
    $insertData['modules_permission'] = $implodeData;
    $insertData['email']              = $data['email'];
    $insertData['first_name']         = $data['first_name'];
    $insertData['middle_name']        = $data['middle_name'];
    $insertData['last_name']          = $data['last_name'];
    $insertData['status']             = $data['status'];
    $insertData['date_create']        = date('Y-m-d');
    $insertData['type'] = 'admin';
    if ( ! empty( $data['profile_pic'] )) {
      $file            = [ 'thumb' => $data['profile_pic'] ];
      $destinationPath = 'userUploads/admin/'; // upload path
      $extension       = $data['profile_pic']->getClientOriginalExtension(); // getting image extension
      $originalName    = $data['profile_pic']->getClientOriginalName();
      $mainImageName   = date('ymdhis') . "-main-" . $originalName; // renameing image
      //$thumDestination='uploads/thumb/';
      $thumbImageName = date('ymdhis') . "-thumb-" . $originalName;
      $editImageName  = date('ymdhis') . "-edit-" . $originalName;
      //Image::make(Input::file('profile_pic'))->save($destinationPath.$mainImageName);
      //Image::make(Input::file('profile_pic'))->fit(219, 219)->save($thumDestination.$thumbImageName);
      Image::make($data['profile_pic'])->resize(29, 29)->save($destinationPath . $thumbImageName);
      Image::make($data['profile_pic'])->resize(250, 200)->save($destinationPath . $editImageName);
      $thumb                          = $thumbImageName;
      $editImage                      = $editImageName;
      $insertData['profile_pic']      = $thumb;
      $insertData['profile_edit_pic'] = $editImage;
      //$size=round(File::size('uploads/main/'.$mainImageName)/1024);
      //$size=getimagesize('uploads/main/'.$mainImageName);
    }

    return $this->adminModel->add($insertData);
  }

  public function changePassword($data, $id)
  {
    return $this->adminModel->edit($data, $id);
  }

  public function update($data, $id)
  {
    $modules = $data['modules_permission'];
    $module  = '';
    // if(!is_array($modules))
    //   $modules = explode(' ', $modules);
    
    foreach ($modules as $mod) {
      $module = $module . $mod . ',';
    }
    $implodeData                    = rtrim($module, ',');
    $editData['username']           = $data['username'];
    $editData['modules_permission'] = $implodeData;
    $editData['email']              = $data['email'];
    $editData['first_name']         = $data['first_name'];
    $editData['middle_name']        = $data['middle_name'];
    $editData['last_name']          = $data['last_name'];
    if ((Auth::user()->id) != $id) {
      $editData['status']             = $data['status'];
    }
    $editData['date_update']        = date('Y-m-d');

    //$editData['password']           = Hash::make($data['new_password']);

    if ( ! empty( $data['profile_pic'] )) {
      $file            = [ 'thumb' => $data['profile_pic'] ];
      $destinationPath = 'userUploads/admin/';
      $extension       = $data['profile_pic']->getClientOriginalExtension();
      $originalName    = $data['profile_pic']->getClientOriginalName();
      $thumbImageName  = date('ymdhis') . "-thumb-" . $originalName;
      $editImageName   = date('ymdhis') . "-edit-" . $originalName;
      Image::make($data['profile_pic'])->resize(29, 29)->save($destinationPath . $thumbImageName);
      Image::make($data['profile_pic'])->resize(250, 200)->save($destinationPath . $editImageName);
      $thumb                        = $thumbImageName;
      $editImage                    = $editImageName;
      $editData['profile_pic']      = $thumb;
      $editData['profile_edit_pic'] = $editImage;
    }

    return $this->adminModel->edit($editData, $id);
  }


  public function delete($id)
  {
    return $this->adminModel->deleteData($id);
  }


  public function removeFile($id)
  {
    $adminData = $this->getSingleAdminData($id);
    if ($adminData['profile_pic'] != '' && file_exists("userUploads/admin/" . $adminData['profile_pic'])) {
      File::delete("userUploads/admin/" . $adminData['profile_pic']);
      File::delete("userUploads/admin/" . $adminData['profile_edit_pic']);
    }
    $updateData['profile_pic']      = '';
    $updateData['profile_edit_pic'] = '';

    return $this->adminModel->edit($updateData, $id);
  }


  public function getAdminList()
  {
    return $this->adminModel->getAllData();
  }


  public function checkUsernameExists($username)
  {
    return $this->adminModel->checkUsername($username);
  }


  public function checkEmailExists($email)
  {
    return $this->adminModel->checkEmail($email);
  }


  public function adminValidation($data)
  {
    return $this->adminModel->validate($data);
  }

  public function validateUpdate($data,$id)
  {
    return $this->adminModel->validateUpdate($data,$id);
  }


  public function getSingleAdminData($id)
  {
    return $this->adminModel->getSingleAdminData($id);
  }
}