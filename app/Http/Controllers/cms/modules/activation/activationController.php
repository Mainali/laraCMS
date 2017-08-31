<?php

namespace App\Http\Controllers\cms\modules\activation;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ActivationService;
use App\ActivationDatas;
use Input;
use Redirect;
use Html;
use Image;
use File;
use Excel;
use Carbon\Carbon;
use Validator;
use Session;
use Auth;

class activationController extends Controller
{
  public $thisPageId = 'Activation';
  public $thisModuleId = "activation";

  public function __construct()
  {
    $this->activationService = new ActivationService;
    $this->activationdatasModel = new ActivationDatas;
  }


  public function index()
  {
    $filterCat = Input::get('filterCat');

    $data = $this->activationService->dataForlist($filterCat);
    $data['thisPageId'] = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['adminData'] = $this->activationService->getAdminList();
    //$data['activationDatas'] = $this->activationService->getActivationDatas();
    $urlData = $this->activationService->getUrlForView();

     if (Session::has('formEditError'))
        {
          
           $formdata = $this->activationService->dataForForm(Session::pull('formEditError'));
           $formdata['showEdit'] = 1;
           return view(MODULEFOLDER . ".modules.activation.home", $data,$formdata)->with($urlData);
        }
       
        
    return view(PREFIX."/modules.activation.home",$data,$urlData);
  }

  public function add()
  {
    $inputData=Input::all();
  }
   /**
   *for toggling status.
   *
   * @return Response
   */
  public function toggleStatus()
  {
    $id = Input::get('id');
    $status = $this->activationService->getDataById($id)->status;
    if($status == 'Activated')
    {
      $data['status'] = 'Pending';
      if($this->activationService->updateAllData($data,$id)){
        return $this->activationService->getDataById($id)->status;
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
      
    }
    elseif($status == "Pending")
    {
      $data['status'] = 'Activated';
      if($this->activationService->updateAllData($data,$id)){
        return $this->activationService->getDataById($id)->status;
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
    }
     elseif($status == "")
    {
      $data['status'] = 'Activated';
      if($this->activationService->updateAllData($data,$id)){
        return $this->activationService->getDataById($id)->status;
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



 public function status(){
  $status=Input::get('status');
  $id=Input::get('id');
$this->activationService->changeStatus($id,$status);
return Redirect::to(PREFIX.'/activation');
 }
 public function delete(){
$id=Input::get('id');
$this->activationService->deleteDatas($id);
return Redirect::to(PREFIX.'/activation');
 }
 public function view(){
  $id=Input::get('id');
  $status=Input::get('status');
  $data['thisPageId'] = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['adminData'] = $this->activationService->getAdminList();
    $data['activationData']=$this->activationService->getActivationDatasById($id,$status);

    return view(PREFIX."/modules.activation.viewactivationdatas",$data);
 }

   public function detailsview()
   {
       $id=Input::get('id');
      $data['adminData'] = $this->activationService->getAdminList();
      $data['activationData']=$this->activationService->getActivationDatasById($id,null);

      return view(MODULEFOLDER . ".modules.activation.sim-users-details", $data)->render();
   }

   public function generateXls()
   {
      return $this->activationService->getExcelSheet();
   }

  public function editload() {
      $activationData=$this->activationdatasModel->getDataById(Input::get('id'));
      $updateData['last_updated_by']=Auth::user()->first_name;
      $updateData['last_updated_on']=$this->dateTime();
      if($activationData->last_update_status=='Pending'&&empty($activationData->last_updated_by)){
      $updateData['last_update_status']='Pending';
      $this->activationService->updateAllData($updateData, Input::get('id'));
      $formdata = $this->activationService->dataForForm(Input::get('id'));
      return view(MODULEFOLDER . ".modules.activation.sim-users-edit", $formdata)->render();
      }elseif($activationData->last_update_status=='Pending'&& $activationData->last_updated_by==Auth::user()->first_name){
      $updateData['last_update_status']='Pending';
      $this->activationService->updateAllData($updateData, Input::get('id'));
      $formdata = $this->activationService->dataForForm(Input::get('id'));
      return view(MODULEFOLDER . ".modules.activation.sim-users-edit", $formdata)->render();
      }elseif($activationData->last_update_status=='Done'&& $activationData->last_updated_by!=Auth::user()->first_name){
      $updateData['last_update_status']='Pending';
      $this->activationService->updateAllData($updateData, Input::get('id'));
      $formdata = $this->activationService->dataForForm(Input::get('id'));
      return view(MODULEFOLDER . ".modules.activation.sim-users-edit", $formdata)->render();
      }elseif($activationData->last_update_status=='Done'&& $activationData->last_updated_by==Auth::user()->first_name){
      $updateData['last_update_status']='Pending';
      $this->activationService->updateAllData($updateData, Input::get('id'));
      $formdata = $this->activationService->dataForForm(Input::get('id'));
      return view(MODULEFOLDER . ".modules.activation.sim-users-edit", $formdata)->render();
      }else{
       $data['error']="The form you are trying to edit is being updated by some other user.Please wait till the form has been updated.";   
      return view(MODULEFOLDER . ".modules.activation.error", $data)->render(); 
      } 
    }
    public function updateStatus(){
      $activationData=$this->activationdatasModel->getDataById(Input::get('id'));
      $updateData['last_updated_by']=Auth::user()->first_name;
      $updateData['last_updated_on']=$this->dateTime();
      $updateData['last_update_status']='Done';
      $this->activationService->updateAllData($updateData, Input::get('id'));
      $data['error']="Cancelled.";   
      return 1;
    }


    public function comparingTime($activationData){
      $endTime=strtotime("+15 minutes", strtotime($activationData->last_updated_on));
       $dateAfterFewMin=$this->date().' '.date('h:i:s', $endTime);
      if($this->dateTime() >= $dateAfterFewMin && (Auth::user()->first_name==$activationData->last_updated_by)){
      $formdata = $this->activationService->dataForForm(Input::get('id'));
      return view(MODULEFOLDER . ".modules.activation.sim-users-edit", $formdata)->render(); 
      }elseif($this->dateTime() >= $dateAfterFewMin && (Auth::user()->first_name!=$activationData->last_updated_by)){
      $formdata = $this->activationService->dataForForm(Input::get('id'));
      return view(MODULEFOLDER . ".modules.activation.sim-users-edit", $formdata)->render(); 
      }else{
      $data['error']="The form you are trying to edit is unavailable.Please try again after 15 minutes";   
      return view(MODULEFOLDER . ".modules.activation.error", $data)->render(); 
      }
    }

    public function saveEdit()
    {
      $rules = array('fullname' => 'required','country'=>'required','passport_num'=>'required','citizenship_num'=>'required');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            //dd(Input::get('id'));
             //Session::put('formEditError', Input::get('id'));
            return Redirect::back()->with('formEditError',Input::get('id'))->withErrors($validator)->withInput();
            //return Redirect::back()->withErrors($validator);
        }
        else {
            
            try {
              $thisData=Input::except('_token');
              $thisData['last_updated_by']=Auth::user()->first_name;
              $thisData['last_updated_on']=$this->dateTime();
              $thisData['last_update_status']='Done';
                $this->activationService->updateAllData($thisData, Input::get('id'));
                $data['msgSuccess']="Edited successfully";
                return Redirect::back()->withErrors($data);
            }
            catch(Exception $e) {
                abort(404);
            }
        }
      
    }

   

 public function edit(){
   $editid=Input::get('editid');
   $inputData=Input::all();
   $this->activationService->editVisaImage($inputData,$editid);
    $data['activationData']=$this->activationService->getActivationDatasById($editid);
    return Redirect::to(PREFIX.'/activation/view?id='.$editid);
 }
 public function editpassportimage(){
   $editid=Input::get('editid');
   $inputData=Input::all();
   $this->activationService->editPassportImage1($inputData,$editid);
    $data['activationData']=$this->activationService->getActivationDatasById($editid);
   return Redirect::to(PREFIX.'/activation/view?id='.$editid);
 }
 public function editpassportimage2(){
   $editid=Input::get('editid');
   $inputData=Input::all();
   $this->activationService->editPassportImage2($inputData,$editid);
    $data['activationData']=$this->activationService->getActivationDatasById($editid);
   return Redirect::to(PREFIX.'/activation/view?id='.$editid);
 }
 public function editcountryimage1(){
 $editid=Input::get('editid');
   $inputData=Input::all();
   $this->activationService->editcountryimage1($inputData,$editid);
    $data['activationData']=$this->activationService->getActivationDatasById($editid);
   return Redirect::to(PREFIX.'/activation/view?id='.$editid);
 }
  public function editcountryimage2(){
   $editid=Input::get('editid');
   $inputData=Input::all();
   $this->activationService->editcountryimage2($inputData,$editid);
    $data['activationData']=$this->activationService->getActivationDatasById($editid);
   return Redirect::to(PREFIX.'/activation/view?id='.$editid);
 }
  public function editformimage(){
   $editid=Input::get('editid');
   $inputData=Input::all();
   $this->activationService->editformimage($inputData,$editid);
    $data['activationData']=$this->activationService->getActivationDatasById($editid);
   return Redirect::to(PREFIX.'/activation/view?id='.$editid);
 }
  public function editsimimage(){
   $editid=Input::get('editid');
   $inputData=Input::all();
   $this->activationService->editsimimage($inputData,$editid);
    $data['activationData']=$this->activationService->getActivationDatasById($editid);
   return Redirect::to(PREFIX.'/activation/view?id='.$editid);
 }
  public function edituserimage(){
   $editid=Input::get('editid');
   $inputData=Input::all();
   $this->activationService->edituserimage($inputData,$editid);
    $data['activationData']=$this->activationService->getActivationDatasById($editid);
   return Redirect::to(PREFIX.'/activation/view?id='.$editid);
 }

 public function trash()
 {
    $id = Input::get('id');
        try {
            $this->activationService->trash($id);
            $data['msgSuccess']="Moved To Trash successfully";
            return Redirect::back()->withErrors($data);
        }
        catch(Exception $e) {
            abort(404);
        }
 }

 public function multitrash()
 {

   if(!empty(Input::get('multi-select'))) {
            $usersArray = Input::get('multi-select');
           
              $op = $this->activationService->multiTrash($usersArray);
              $data['msgSuccess']=$op['msg'];
              return Redirect::back()->withErrors($data);

            }

            else
            {
              $data['msgError']="Please Select users to move to trash";
              return Redirect::back()->withErrors($data);
            }
              
   
 }

 public function filtered()
 {
    if(is_null(Input::all()))
    {

      return Redirect::back();
    }

    

    //$data = $this->moduleService->dataForlist($filterCat);
    $data['thisPageId'] = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['adminData'] = $this->activationService->getAdminList();
    $data['filterCat'] = Input::get('filterCat');
    $data['keyword'] = Input::get('keyword');
    $data['datefilter'] = Input::get('date');
    $data['activationDatas'] = $this->activationService->filtered(Input::all());
    $urlData = $this->activationService->getUrlForView();
//dd( $data['activationDatas']);
     if (Session::has('formEditError'))
        {
          
           $formdata = $this->activationService->dataForForm(Session::pull('formEditError'));
           $formdata['showEdit'] = 1;
           //dd($formdata);
           return view(MODULEFOLDER . ".modules.activation.home", $data,$formdata)->with($urlData);
        }
       
        
    return view(MODULEFOLDER . ".modules.activation.home",$data,$urlData);

 }
  public function dateTime()
  {
    $dateTime = Carbon::now('Asia/Kathmandu');
    return $dateTime->toDateTimeString();
  }
  public function date(){
    $dateTime = Carbon::now('Asia/Kathmandu');
    return $dateTime->toDateString();
  }
}
