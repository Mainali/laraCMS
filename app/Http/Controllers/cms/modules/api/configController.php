<?php
namespace App\Http\Controllers\cms\modules\api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ApiConfigService;
use Hash;
use Input;
use Redirect;
use Validator;
use Session;

class configController extends Controller
{
    public $thisPageId = 'Api Config';
    
    public $thisModuleId = "api";
    
    public function __construct() {
        $this->moduleService = new ApiConfigService;
    }
    
    public function index() {

        $data = $this->moduleService->dataForlist();

        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;

        if (Session::has('formEditError'))
        {

           $formdata = $this->moduleService->dataForForm(Session::pull('formEditError'));
           $formdata['showEdit'] = 1;
           return view(MODULEFOLDER . ".modules.api.api-config-list", $data,$formdata);
        }

        if (Session::has('formAddError'))
        {
            
           //$formdata = $this->moduleService->dataForForm();
           $formdata['showAdd'] = Session::pull('formAddError');
           return view(MODULEFOLDER . ".modules.api.api-config-list", $data,$formdata);
        }
        
        
        return view(MODULEFOLDER . ".modules.api.api-config-list", $data);
    }
    public function addnew() {
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;
        
        return view(MODULEFOLDER . ".modules.api.api-config-add", $data)->render();
    }
    public function addPost() {
        
        $rules = array('title' => 'required',);
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            Session::put('formAddError', 1);
            $adderror = 1;
            return redirect(PREFIX . '/api/pages/config')->withErrors($validator)->withInput();
            //return Redirect::back()->withErrors($validator);
        } 
        else {
            $key = strtotime('YmdHis') . 'TRAMGIB' . rand(0, 9999);
            $insertData['api_keys'] = Hash::make($key);
            $insertData['title'] = Input::get('title');
            $insertData['description'] = Input::get('description');
            $insertData['status'] = Input::get('status');
            $insertData['date_started'] = date("Y-m-d H:i:s");
            try {
                $this->moduleService->create($insertData);
                $data['msgSuccess']="Added successfully";
                return Redirect::back()->withErrors($data);
            }
            catch(Exception $e) {
                abort(404);
            }
        }
    }
    public function edit() {
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;
        $data = $this->moduleService->dataForForm(Input::get('id'));
        return view(MODULEFOLDER . ".modules.api.api-config-edit", $data)->render();
    }
    public function editPost() {
        $rules = array('title' => 'required',);
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            Session::put('formEditError', Input::get('id'));
            return redirect(PREFIX . '/api/pages/config')->withErrors($validator)->withInput();
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
        $id = Input::get('id');
        try {
             $this->moduleService->deleteData($id);
            $data['msgSuccess']="Deleted successfully";
            return Redirect::back()->withErrors($data);
        }
        catch(Exception $e) {
            abort(404);
        }
    }
}
