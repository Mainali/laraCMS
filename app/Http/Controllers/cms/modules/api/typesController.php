<?php
namespace App\Http\Controllers\cms\modules\api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ApiTypeService;
use Validator;
use Input;
use Redirect;
use Session;

class typesController extends Controller
{
    public $thisPageId = 'Api Type';
    
    public $thisModuleId = "api";
    
    public function __construct() {
        $this->moduleService = new ApiTypeService;
    }
    
    public function index() {

    $filterCat = Input::get('filterCat');

    $data = $this->moduleService->dataForlist($filterCat);

    if (isset($filterCat)) {
      $data['filterCat'] = $filterCat ;
    }else{
      $data['filterCat'] = null ;
    }

    $data['thisPageId'] = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    if (Session::has('formEditError'))
    {

       $formdata = $this->moduleService->dataForForm(Session::pull('formEditError'));
       $formdata['showEdit'] = 1;
       return view(MODULEFOLDER . ".modules.api.api-type-list", $data,$formdata);
    }

    if (Session::has('formAddError'))
    {
        
       $formdata = $this->moduleService->dataForForm();
       $formdata['showAdd'] = Session::pull('formAddError');
       return view(MODULEFOLDER . ".modules.api.api-type-list", $data,$formdata);
    }

       
       
        

        return view(MODULEFOLDER . ".modules.api.api-type-list", $data);
    }
    public function addPost() {

        $rules = array('api_name' => 'required',);
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            // $data = $this->moduleService->dataForlist();
            // $formdata = $this->moduleService->dataForForm();
            // $formdata['showAdd'] = 1;
            Session::put('formAddError', 1);
            //$adderror = 1;
            return redirect(PREFIX . '/api/pages/types')->withErrors($validator)->withInput();
            //return view(MODULEFOLDER . ".modules.api.api-type-list", $data,$formdata)->withInput();
            //return Redirect::back()->withErrors($validator);
        } 
        else {
            try {
                $this->moduleService->create(Input::all());
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
        // $data['apiTypeData'] = $this->moduleService->getDataById(Input::get('id'));
        // $data['apiCategories'] = $this->moduleService->getCategorieslist();
        $formdata = $this->moduleService->dataForForm(Input::get('id'));
        return view(MODULEFOLDER . ".modules.api.api-type-edit", $formdata)->render();
    }

    public function addnew(){

        $formdata = $this->moduleService->dataForForm();
        //dd($data);
        return view(MODULEFOLDER . ".modules.api.api-type-add", $formdata)->render();
    }

    public function editPost() {
        $rules = array('api_name' => 'required',);
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            // $data = $this->moduleService->dataForlist();
            // $data['thisPageId'] = $this->thisPageId;
            // $data['thisModuleId'] = $this->thisModuleId;
            // $formdata = $this->moduleService->dataForForm(Input::get('id'));
            // $formdata['showEdit'] = 1;
            //dd($formdata);
            Session::put('formEditError', Input::get('id'));
            return redirect(PREFIX . '/api/pages/types')->withErrors($validator)->withInput();
            //return Redirect::back()->with('showEdit',$formdata['showEdit']);
            //return view(MODULEFOLDER . ".modules.api.api-type-list", $data,$formdata);
        } 
        else {
            try {
                $this->moduleService->editData(Input::except('_token'), Input::get('id'));
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
