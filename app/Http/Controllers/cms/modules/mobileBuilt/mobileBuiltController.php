<?php
namespace App\Http\Controllers\cms\modules\mobileBuilt;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\MobileBuiltService;
use Hash;
use Input;
use Image;
use File;
use Redirect;
use Response;
use Validator;
use Session;
use Carbon\Carbon;
use App\MobileBuilt;

class mobileBuiltController extends Controller
{
    public $thisPageId = 'Mobile Built';
    
    public $thisModuleId = "mobileBuilt";
    
    public function __construct() {
        $this->moduleService = new MobileBuiltService;
        $this->mobileBuilt = new MobileBuilt;
    }
    
    public function index() {
        
        
        $data = $this->moduleService->dataForlist();
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;

        if (Session::has('formEditError'))
        {

           $formdata = $this->moduleService->dataForForm(Session::pull('formEditError'));
           $formdata['showEdit'] = 1;
           return view(MODULEFOLDER . ".modules.mobileBuilt.mobile-built-list", $data,$formdata);
        }

        if (Session::has('formAddError'))
        {
            
           $formdata = $this->moduleService->dataForForm();
           $formdata['showAdd'] = Session::pull('formAddError');
           return view(MODULEFOLDER . ".modules.mobileBuilt.mobile-built-list", $data,$formdata);
        }
        
        return view(MODULEFOLDER . ".modules.mobileBuilt.mobile-built-list", $data);
    }

    public function addnew(){
        return view(MODULEFOLDER . ".modules.mobileBuilt.mobile-built-add")->render();
    }
    
    public function addPost() {
        
        $rules = array('title' => 'required','description'=>'required','apk_version'=>'required');
        $insertData=Input::all();
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            Session::put('formAddError', 1);
            $adderror = 1;
            return redirect(PREFIX . '/mobileBuilt')->withErrors($validator)->withInput();
        } 
        else {
           
            try {
                  $insertData=Input::except('_token');
                   $directory = 'public/apk/';
              $fileInput =Input::file('apk')->getClientOriginalName();
               Input::file('apk')->move($directory,$fileInput);
              $filename = pathinfo($fileInput, PATHINFO_FILENAME);
              $extension = pathinfo($fileInput, PATHINFO_EXTENSION);
                $insertData['apk'] =$filename.'.'.$extension;
                $insertData['status']='Inactive';
                $insertData['created_on']=$this->dateTime();
                $this->moduleService->create($insertData);
                $data['msgSuccess']="Added successfully";
                return Redirect::back()->withErrors($data);
            }
            catch(Exception $e) {
                abort(404);
            }
            
        }
    }
    public function downloadApk(){
        $id=Input::get('id');
        $builtData=$this->mobileBuilt->getDataById($id);
        $file="public/apk/".$builtData->apk;
        return Response::download($file);
    }
    public function edit() {
        $id=Input::get('id');
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;
       $data['builtData']=$this->mobileBuilt->getDataById($id);
        return view(MODULEFOLDER . ".modules.mobileBuilt.mobile-built-edit", $data)->render();
    }
    public function editPost() {
        $rules = array('title' => 'required','description'=>'required','apk_version'=>'required');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
           Session::put('formEditError', Input::get('id'));
            return redirect(PREFIX . '/api/pages/categories')->withErrors($validator)->withInput();
        } 
        else {
            $updateData['title'] = Input::get('title');
            
            try {
              $builtData=$this->mobileBuilt->getDataById(Input::get('id'));         
            $updateData=Input::except('_token');
            if(empty(Input::file('apk'))){
            $updateData['apk'] =$builtData->apk;
            }else{
            if (!empty($builtData->apk) && file_exists("public/apk/" . $builtData->apk)) {
           File::delete("public/apk/" . $builtData->apk);
            }  
            $directory = 'public/apk/';
            $fileInput =Input::file('apk')->getClientOriginalName();
            Input::file('apk')->move($directory,$fileInput);
            $filename = pathinfo($fileInput, PATHINFO_FILENAME);
            $extension = pathinfo($fileInput, PATHINFO_EXTENSION);
            $updateData['apk'] =$filename.'.'.$extension;
            }
            $updateData['created_on']=$this->dateTime();
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
       $builtData=$this->mobileBuilt->getDataById($id);
        if (!empty($builtData->apk) && file_exists("public/apk/" . $builtData->apk)) {
      File::delete("public/apk/" . $builtData->apk);
    }
     $this->moduleService->delete($id);
    $data['msgSuccess']="Deleted successfully";
    return Redirect::back()->withErrors($data);
        
    }
      public function dateTime()
  {
    $dateTime = Carbon::now('Asia/Kathmandu');
    return $dateTime->toDateTimeString();
  }
    public function toggleStatus()
  {
    $id = Input::get('id');
    $this->mobileBuilt->updateStatus($id);
    $thisId=array($id);
   $allId=$this->mobileBuilt->getAllId();
   $A = array_diff($allId,$thisId);
   foreach($A as $B){
    $this->mobileBuilt->updateStatusToInactive($B);
   }
   return Redirect::back();
  }


}
