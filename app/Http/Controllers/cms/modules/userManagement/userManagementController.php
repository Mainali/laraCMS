<?php

namespace App\Http\Controllers\cms\modules\userManagement;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Input;
use Redirect;
use Html;
use Image;
use File;
use Illuminate\Support\Facades\Auth;
use Hash;

class userManagementController extends Controller
{

  public $thisPageId = 'User Management';

  public $thisModuleId = "userManagement";


  public function __construct()
  {
    $this->adminService = new AdminService;
  }


  public function index()
  {
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['adminData']    = $this->adminService->getAdminList();
    $data['superAdmin'] = $this->adminService->getSuperAdmin();
    return view(PREFIX . "/modules.userManagement.home", $data);
  }


  public function add()
  {
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view(PREFIX . "/modules/userManagement/add", $data);
  }


  public function addAdmin()
  {
    $validator = $this->adminService->adminValidation(Input::all());
    if ($validator->fails()) {
      return redirect(PREFIX . '/userManagement/add')->withErrors($validator)->withInput();
    }
    
    
    try{
      $this->adminService->create(Input::all());
      return redirect(PREFIX . '/userManagement');
    }catch(Exception $e){
      $error['msg'] = 'added';
      return redirect(PREFIX . '/userManagement/add')->withErrors($error)->withInput();
    }
    

    
  }


  public function edit()
  {
    $id                   = Input::get('id');
    $data['adminData']    = $this->adminService->getSingleAdminData($id);

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view(PREFIX . "/modules/userManagement/edit", $data);
  }

  public function changePass()
  {
    $id                   = Input::get('id');
    $data['adminData']    = $this->adminService->getSingleAdminData($id);
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view(PREFIX . "/modules/userManagement/changepass", $data);
  }

  public function updatePass()
  {
    $id = Input::get('id');
    

    if ((Input::get('new_password') != "") && (Input::get('confirm_password') != "")) {
      $new_password = Input::get('new_password');
      $confirm_password = Input::get('confirm_password');
      if ($new_password != $confirm_password) {
        $data['msgError'] = 'The New password and confirmation password does not match each other';
        return redirect(PREFIX . '/userManagement/changePass?id='.$id)->withErrors($data);
      }else{
        $input = ['password' => ''];
        $input['password'] = Hash::make($new_password);
      }
    }else{
      $data['msgError'] = 'Both Fields are required';
      return redirect(PREFIX . '/userManagement/changePass?id='.$id)->withErrors($data);
    }

    try{
      $this->adminService->changePassword($input,$id);
      $data['msgSuccess'] = 'Successfully Updated User Info.';
      return redirect(PREFIX . '/userManagement')->withErrors($data);
    }catch(Exception $e){
      $error['edit'] = 'Error! updating changes';
       return redirect(PREFIX . '/userManagement/changePass?id='.$id)->withErrors($error);
    }
  }


  public function editAdmin()
  {
    
    $id = Input::get('id');
    $input = Input::all();
    $validator = $this->adminService->validateUpdate(Input::all(),$id);
    if($validator->fails()){
      return redirect(PREFIX . '/userManagement/edit?id='.$id)->withErrors($validator)->withInput();
    }

    // if (Input::get('current_password') != "") {
    //   $current_password = Input::get('current_password');
    //   $user = $this->adminService->getSingleAdminData($id);
    //   if (!Hash::check($current_password, $user->password)) {
    //     $data['msgError'] = 'Your Current Password is incorrect';
    //     return redirect(PREFIX . '/userManagement/edit?id='.$id)->withErrors($data)->withInput();
    //   }
    // }

    // if ((Input::get('new_password') != "") && (Input::get('confirm_password') != "")) {
    //   $new_password = Input::get('new_password');
    //   $confirm_password = Input::get('confirm_password');
    //   if ($new_password != $confirm_password) {
    //     $data['msgError'] = 'The New password and confirmation password does not match each other';
    //     return redirect(PREFIX . '/userManagement/edit?id='.$id)->withErrors($data)->withInput();
    //   }else{
    //     $input['password'] = Hash::make($new_password);
    //   }
    // }

    try{
      $this->adminService->update($input,$id);
      $data['msgSuccess'] = 'Successfully Updated User Info.';
      return redirect(PREFIX . '/userManagement')->withErrors($data);
    }catch(Exception $e){
      $error['edit'] = 'edit';
       return redirect(PREFIX . '/userManagement/edit?id='.$id)->withErrors($error);
    }
    

     
  }


  public function delete()
  {
    $id = Input::get('id');
    $this->adminService->removeFile($id);
    $this->adminService->delete($id);
    $error['delmsg'] = 'delete';

    return Redirect::to(PREFIX . '/userManagement')->withErrors($error);
  }


  public function deleteFile()
  {
    $id = Input::get('id');
    $this->adminService->removeFile($id);

    return Redirect::to(PREFIX . '/userManagement/edit?id=' . $id);
  }
}
