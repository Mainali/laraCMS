<?php
namespace App\Http\Controllers\cms\modules\apiusers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ApiUsersService;
use Hash;
use Input;
use Redirect;
use Validator;
use Session;

class apiusersController extends Controller
{
    public $thisPageId = 'Api Users';
    
    public $thisModuleId = "apiusers";
    
    public function __construct() {
        $this->moduleService = new ApiUsersService;
    }
    
    public function index() {

        $filterCat = Input::get('filterCat');

        $data = $this->moduleService->dataForlist($filterCat);
        
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;

        if (Session::has('formEditError'))
        {

           $formdata = $this->moduleService->dataForForm(Session::pull('formEditError'));
           $formdata['showEdit'] = 1;
           return view(MODULEFOLDER . ".modules.apiusers.api-users-list", $data,$formdata);
        }

        if (Session::has('formAddError'))
        {
            
           //$formdata = $this->moduleService->dataForForm();
           $formdata['showAdd'] = Session::pull('formAddError');
           dd($formdata);
           return view(MODULEFOLDER . ".modules.apiusers.api-users-list", $data,$formdata);
        }
        
        
        return view(MODULEFOLDER . ".modules.apiusers.api-users-list", $data);
    }
    public function addnew() {
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;
        
        return view(MODULEFOLDER . ".modules.apiusers.api-users-add", $data)->render();
    }
    public function addPost() {
        //dd(Input::all());
        // $rules = array('firstName' => 'required','lastName' => 'required','userName' => 'required','email' => 'required|email','gender' => 'required','password' => 'required','mobile' => 'required');
        // $validator = Validator::make(Input::all(), $rules);
        // if ($validator->fails()) {

        //     Session::put('formAddError', 1);
            
        //     return redirect(PREFIX . '/apiusers')->withErrors($validator)->withInput();
        //     //return Redirect::back()->withErrors($validator);
        // } 
        //else {
            $apiResponse = $this->moduleService->createApiUsers( Input::except('_token')) ;

            if($apiResponse['status'] == 'ok') $data['msgSuccess'] = $apiResponse['msg']; else $data['msgError'] = $apiResponse['msg'];
            
            return Redirect::back()->withErrors($data);
           
    //}
        }
    public function edit() {
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;
        $data = $this->moduleService->dataForForm(Input::get('id'));
        return view(MODULEFOLDER . ".modules.api.api-users-edit", $data)->render();
    }
    public function editPost() {
        $rules = array('title' => 'required',);
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            Session::put('formEditError', Input::get('id'));
            return redirect(PREFIX . '/api/pages/users')->withErrors($validator)->withInput();
            //return Redirect::back()->withErrors($validator);
        } 
        else {
            $updateData['title'] = Input::get('title');
            $updateData['description'] = Input::get('description');
            $updateData['status'] = Input::get('status');
            try {
                $this->moduleService->editData($updateData, Input::get('id'));
                $data['msgSuccess']="Edited successfully";
                return Redirect::back()->withErrors($data);
            }
            catch(Exception $e) {
                abort(404);
            }
        }
    }

    /**
   *for toggling status.
   *
   * @return Response
   */
  public function toggleStatus()
  {
    $id = Input::get('id');
    $status = $this->moduleService->getDataById($id)->status;
    if($status == 'active')
    {
      $data['status'] = 'inactive';
      if($this->moduleService->editData($data,$id)){
        echo ucfirst($this->moduleService->getDataById($id)->status);
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
      
    }
    elseif($status == "inactive")
    {
      $data['status'] = 'active';
      if($this->moduleService->editData($data,$id)){
        echo ucfirst($this->moduleService->getDataById($id)->status);
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
    }
    else
    {
      header('HTTP/1.1 400 Bad Request');
    }
    exit();

  }
    public function delete() {

        $apiResponse = $this->moduleService->deleteApiUsers( Input::except('_token')) ;

        if($apiResponse['status'] == 'ok') $data['msgSuccess'] = $apiResponse['msg']; else $data['msgError'] = $apiResponse['msg'];
            
        return Redirect::back()->withErrors($data);
       
    }
}
