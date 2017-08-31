<?php
namespace App\Http\Controllers\cms\modules\api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ApiCategoriesService;
use Hash;
use Input;
use Redirect;
use Validator;
use Session;

class categoriesController extends Controller
{
    public $thisPageId = 'Api Config';
    
    public $thisModuleId = "api";
    
    public function __construct() {
        $this->moduleService = new ApiCategoriesService;
    }
    
    public function index() {
        
        
        $data = $this->moduleService->dataForlist();
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;

        if (Session::has('formEditError'))
        {

           $formdata = $this->moduleService->dataForForm(Session::pull('formEditError'));
           $formdata['showEdit'] = 1;
           return view(MODULEFOLDER . ".modules.api.api-categories-list", $data,$formdata);
        }

        if (Session::has('formAddError'))
        {
            
           $formdata = $this->moduleService->dataForForm();
           $formdata['showAdd'] = Session::pull('formAddError');
           return view(MODULEFOLDER . ".modules.api.api-categories-list", $data,$formdata);
        }
        
        return view(MODULEFOLDER . ".modules.api.api-categories-list", $data);
    }

    public function addnew(){

        //$formdata = $this->moduleService->dataForForm();
        //dd($data);
        return view(MODULEFOLDER . ".modules.api.api-categories-add")->render();
    }
    
    public function addPost() {
        
        $rules = array('title' => 'required',);
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            Session::put('formAddError', 1);
            $adderror = 1;
            return redirect(PREFIX . '/api/pages/categories')->withErrors($validator)->withInput();
        } 
        else {
            
            $insertData['title'] = Input::get('title');
           
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
       $formdata = $this->moduleService->dataForForm(Input::get('id'));
        return view(MODULEFOLDER . ".modules.api.api-categories-edit", $data,$formdata)->render();
    }
    public function editPost() {
        $rules = array('title' => 'required',);
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
           Session::put('formEditError', Input::get('id'));
            return redirect(PREFIX . '/api/pages/categories')->withErrors($validator)->withInput();
        } 
        else {
            $updateData['title'] = Input::get('title');
            
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

   
    public function delete() {
        $id = Input::get('id');
        if($this->moduleService->getDataById($id)->api_type->count() > 0)
        {
            $data['msgError']="Category in use, Cannot Delete.";
            return Redirect::back()->withErrors($data);
        }
        else{
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
}
