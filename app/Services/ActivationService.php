<?php 

namespace App\Services;
use App\Admin;
use App\ImageData;
use App\ActivationDatas;
use Image;
use File;
use URL;
use Carbon\Carbon;
use Excel;
use DB;
use Redirect;

class ActivationService
{
  public function __construct()
  {
    $this->adminModel = new Admin;
    $this->activationdatasModel = new ActivationDatas;
    $this->image = new ImageData;
  }
  public function getActivationDatas(){
    return $this->activationdatasModel->getAllActivionData();
  }
  public function imageSyncStatus($id){
    $this->activationdatasModel->imageSyncStatus($id);
  }

  public function getDataById($id)
  {
    return $this->activationdatasModel->getDataById($id);
  }

  public function add($insertData){
   return $this->activationdatasModel->addActivationDatas($insertData);
  }
  public function changeStatus($id,$status){
    $this->activationdatasModel->changeStatus($id,$status);
  }
  public function editVisaImage($inputData,$id){
 $activationData = $this->activationdatasModel->getActivationDatasById($id);
    if (!empty($activationData->visa_image) && file_exists("uploads/visa_image/" . $activationData->visa_image)) {
      File::delete("uploads/visa_image/" . $activationData->visa_image);
    }
  $thisData['visa_image']=$this->visaImage($inputData['visa_image']);
  $this->activationdatasModel->editVisaImage($thisData['visa_image'],$id);
  }
  public function editPassportImage1($inputData,$id){
    $activationData = $this->activationdatasModel->getActivationDatasById($id);
    if (!empty($activationData->passport_image_1) && file_exists("uploads/passport_image/image1/" . $activationData->passport_image_1)) {
      File::delete("uploads/passport_image/image1/" . $activationData->passport_image_1);
    }
  $thisData['passport_image_1']=$this->passportImage1($inputData['passport_image_1']);
  $this->activationdatasModel->editPassportImage1($thisData['passport_image_1'],$id);
  }
  public function editPassportImage2($inputData,$id){
    $activationData = $this->activationdatasModel->getActivationDatasById($id);
    if (!empty($activationData->passport_image_2) && file_exists("uploads/passport_image/image2/" . $activationData->passport_image_2)) {
      File::delete("uploads/passport_image/image2/" . $activationData->passport_image_2);
    }
  $thisData['passport_image_2']=$this->passportImage2($inputData['passport_image_2']);
  $this->activationdatasModel->editPassportImage2($thisData['passport_image_2'],$id);
  }
  public function editcountryimage1($inputData,$id){
   $activationData = $this->activationdatasModel->getActivationDatasById($id);
    if (!empty($activationData->country_id_image_1) && file_exists("uploads/country_image/image1/" . $activationData->country_id_image_1)) {
      File::delete("uploads/country_image/image1/" . $activationData->country_id_image_1);
    }
  $thisData['country_id_image_1']=$this->countryIdImage1($inputData['country_id_image_1']);
  $this->activationdatasModel->editCountryImage1($thisData['country_id_image_1'],$id);  
  }
    public function editcountryimage2($inputData,$id){
   $activationData = $this->activationdatasModel->getActivationDatasById($id);
    if (!empty($activationData->country_id_image_2) && file_exists("uploads/country_image/image2/" . $activationData->country_id_image_2)) {
      File::delete("uploads/country_image/image2/" . $activationData->country_id_image_2);
    }
  $thisData['country_id_image_2']=$this->countryIdImage2($inputData['country_id_image_2']);
  $this->activationdatasModel->editCountryImage2($thisData['country_id_image_2'],$id);  
  }
public function editformimage($inputData,$id){
   $activationData = $this->activationdatasModel->getActivationDatasById($id);
    if (!empty($activationData->form_image) && file_exists("uploads/form/" . $activationData->form_image)) {
      File::delete("uploads/form/" . $activationData->form_image);
    }
  $thisData['form_image']=$this->formImage($inputData['form_image']);
  $this->activationdatasModel->editformImage($thisData['form_image'],$id); 
}
public function editsimimage($inputData,$id){
    $activationData = $this->activationdatasModel->getActivationDatasById($id);
    if (!empty($activationData->sim_image) && file_exists("uploads/form/" . $activationData->sim_image)) {
      File::delete("uploads/form/" . $activationData->sim_image);
    }
  $thisData['sim_image']=$this->simImage($inputData['sim_image']);
  $this->activationdatasModel->editSimImage($thisData['sim_image'],$id); 
}
public function edituserimage($inputData,$id){
  $activationData = $this->activationdatasModel->getActivationDatasById($id);
    if (!empty($activationData->user_image) && file_exists("uploads/user_image/" . $activationData->user_image)) {
      File::delete("uploads/user_image/" . $activationData->user_image);
    }
  $thisData['user_image']=$this->userImage($inputData['user_image']);
  $this->activationdatasModel->editUserImage($thisData['user_image'],$id); 
}
 
 public function updateImage($InsertData,$id){
  $this->activationdatasModel->updateImage($InsertData,$id);
 }
  public function getActivateDatas(){
 $activationsDatas=$this->activationdatasModel->getAllActivionData();
 foreach ($activationsDatas as $activationDatas) {
  $thisData['fullName']=$activationDatas->fullname;
  $thisData['passportNumber']=$activationDatas->passport_num;
  $thisData['citizenshipNumber']=$activationDatas->citizenship_num;
$thisData['country']=$activationDatas->country;
$thisData['countryId']=$activationDatas->country_id;
$thisData['visaImage']=$activationDatas->visa_image;
$thisData['formImage']=$activationDatas->form_image;
$thisData['simImage']=$activationDatas->sim_image;
$thisData['passportImage1']=$activationDatas->passport_image_1;
$thisData['passportImage2']=$activationDatas->passport_image_2;
return $thisData;
 }
  } 
  public function countryIdImage1($image){
    $originalName = $image->getClientOriginalName();
    $realImage = str_replace(' ', '-', $originalName);
    $originalImageName = rand(1000,9999) . strtotime(date('Ymdhis')) . "-main-" . $realImage;
    Image::make($image)->save(ConstantService::countryIdImage1Path . $originalImageName);
    $thisData['countryIdImage1'] = $originalImageName;
    return $thisData['countryIdImage1'];
  }

  public function countryIdImage2($image){
    $originalName = $image->getClientOriginalName();
    $realImage = str_replace(' ', '-', $originalName);
    $originalImageName = rand(1000,9999) . strtotime(date('Ymdhis')) . "-main-" . $realImage;
    Image::make($image)->save(ConstantService::countryIdImage2Path . $originalImageName);
    $thisData['countryIdImage2'] = $originalImageName;
    return $thisData['countryIdImage2'];
  }

  public function userImage($image){
    $originalName = $image->getClientOriginalName();
    $realImage = str_replace(' ', '-', $originalName);
    $originalImageName = rand(1000,9999) . strtotime(date('Ymdhis')) . "-main-" . $realImage;
    Image::make($image)->save(ConstantService::userPath . $originalImageName);
    $thisData['userImage'] = $originalImageName;
    return $thisData['userImage'];
  }
  public function passportImage1($image){
  $originalName = $image->getClientOriginalName();
    $realImage = str_replace(' ', '-', $originalName);
    $originalImageName = rand(1000,9999) . strtotime(date('Ymdhis')) . "-main-" . $realImage;
    Image::make($image)->save(ConstantService::passportImage1Path . $originalImageName);
    $thisData['passportImage1'] = $originalImageName;
    return $thisData['passportImage1'];
  }
  public function passportImage2($image){
  $originalName = $image->getClientOriginalName();
    $realImage = str_replace(' ', '-', $originalName);
    $originalImageName = rand(1000,9999) . strtotime(date('Ymdhis')) . "-main-" . $realImage;
    Image::make($image)->save(ConstantService::passportImage2Path . $originalImageName);
    $thisData['passportImage1'] = $originalImageName;
    return $thisData['passportImage1'];
  }
  public function visaImage($image){
    $originalName = $image->getClientOriginalName();
    $realImage = str_replace(' ', '-', $originalName);
    $originalImageName = rand(1000,9999) . strtotime(date('Ymdhis')) . "-main-" . $realImage;
    Image::make($image)->save(ConstantService::visaImagePath . $originalImageName);
    $thisData['visaImage'] = $originalImageName;
    return $thisData['visaImage'];
  }
  public function formImage($image){
    $originalName = $image->getClientOriginalName();
    $realImage = str_replace(' ', '-', $originalName);
    $originalImageName = rand(1000,9999) . strtotime(date('Ymdhis')) . "-main-" . $realImage;
    Image::make($image)->save(ConstantService::formImagePath . $originalImageName);
    $thisData['formImage'] = $originalImageName;
    return $thisData['formImage'];
  }
  public function searchByCitizenNumber($citizenNumber){
   $thisData=$this->activationdatasModel->searchByCitizenNumber($citizenNumber);
   if(empty($thisData)){
    $jsonData['DataAvailable']='No';
    $response = array('message' =>$jsonData, 'status' => ConstantService::NOTFOUNDSTATUS);
    return $response;
   }else{
    $jsonData['country']=$thisData->country;
$jsonData['fullName']=$thisData->fullname;
if(empty($thisData->user_image))$jsonData['userImage']='';
else$jsonData['userImage']=APP_URL.USERIMAGEPATH.$thisData->user_image;
if(empty($thisData->sim_image))$jsonData['simImage']='';
else$jsonData['simImage']=APP_URL.SIMIMAGEPATH.$thisData->sim_image;
if(empty($thisData->visa_image))$jsonData['visaImage']='';
else$jsonData['visaImage']=APP_URL.VISAIMAGEPATH.$thisData->visa_image;
if(empty($thisData->form_image))$jsonData['formImage']='';
else$jsonData['formImage']=APP_URL.FORMIMAGEPATH.$thisData->form_image;
if(empty($thisData->passport_image_1))$jsonData['passportImage1']='';
else$jsonData['passportImage1']=APP_URL.PASSPORTIMAGE1PATH.$thisData->passport_image_1;
if(empty($thisData->passport_image_2))$jsonData['passportImage2']='';
else$jsonData['passportImage2']=APP_URL.PASSPORTIMAGE2PATH.$thisData->passport_image_2;
if(empty($thisData->country_image_1))$jsonData['countryIdImage1']='';
else$jsonData['countryIdImage1']=APP_URL.COUNTRYID1IMAGEPATH.$thisData->country_image_1;
if(empty($thisData->country_image_2))$jsonData['countryIdImage2']='';
else$jsonData['countryIdImage2']=APP_URL.COUNTRYID2IMAGEPATH.$thisData->country_image_2;
$jsonData['citizenshipNumber']=$thisData->citizenship_num;
$jsonData['passportNumber']=$thisData->passport_num;
$jsonData['DataAvailable']='Yes';
  $response = array('message' =>$jsonData, 'status' => ConstantService::OKSTATUS);
    return $response;
   }
  }
  public function searchDynamicFields($dbField, $dbValue){
  $thisData=$this->activationdatasModel->searchDynamicFields($dbField, $dbValue);
  if(!empty($thisData)){
   $jsonData['DataAvailable']=['Yes'];
  $response = array('message' =>$jsonData, 'status' => ConstantStatusService::OKSTATUS);
   }
   else{
    $jsonData['DataAvailable']=['No'];
   $response = array('message' =>$jsonData, 'status' => ConstantStatusService::NOTFOUNDSTATUS);
   }
  return $response;
  }
    public function simImage($image){
    $originalName = $image->getClientOriginalName();
    $realImage = str_replace(' ', '-', $originalName);
    $originalImageName = rand(1000,9999) . strtotime(date('Ymdhis')) . "-main-" . $realImage;
    Image::make($image)->save(ConstantService::simImagePath . $originalImageName);
    $thisData['simImage'] = $originalImageName;
    return $thisData['simImage'];
  }
   public function getAdminList(){
      return $this->adminModel->getAllData();
    }
   public function dateTime()
  {
    $dateTime = Carbon::now('Asia/Kathmandu');
    return $dateTime->toDateTimeString();
  }
  public function deleteDatas($id){
    $this->activationdatasModel->deleteDatas($id);
  }
  public function testAdd($inputData){
   $image=$inputData['image'];
$originalName = $image->getClientOriginalName();
    $realImage = str_replace(' ', '-', $originalName);
    $originalImageName = rand(1000,9999) . strtotime(date('Ymdhis')) . "-main-" . $realImage;
    Image::make($image)->save(ConstantService::imagePath . $originalImageName);
    $thisData['image'] = $originalImageName;
    $this->image->add($thisData);
     $response = array('message' =>['Sucessfully Uploaded.'], 'status' => ConstantService::OKSTATUS);
    return $response;
  }
  public function getActivationDatasById($id,$status){
    $this->activationdatasModel->updateStatus($id,$status);
  return $this->activationdatasModel->getActivationDatasById($id);
  }


  public function dataForlist($filterCat=null)
    {

        if(null!==$filterCat && $filterCat !=="live")
        {
          if($filterCat == "all")
          {
            $data['activationDatas'] = $this->activationdatasModel->getAllDataWithTrashed();
          }
          elseif ($filterCat == "trashed") {
            $data['activationDatas'] = $this->activationdatasModel->getOnlyTrashedData();
          }
          else
          {
            $data['activationDatas'] = $this->activationdatasModel->filterByStatus($filterCat);
          }
          
           $data['filterCat'] = $filterCat; 
        }   
        else
        {
          $data['activationDatas'] = $this->getActivationDatas();
            $data['filterCat'] = 'live';  
        }
        
            
        return $data;
    }

  public function getUrlForView()
  {
    $data['editUrl']= URL::to(PREFIX.'/activation/editload');
    $data['addUrl'] = URL::to(PREFIX.'/activation/addnew');
    $data['issuesUrl'] = URL::to(PREFIX.'/activation/pages/issues');
    $data['deleteUrl'] = URL::to(PREFIX.'/activation/delete');
    $data['detailsUrl'] = URL::to(PREFIX.'/activation/detailsview');
    $data['excelgenerateUrl'] = URL::to(PREFIX.'/activation/generateXls');
    $data['toggleUrl'] = URL::to(PREFIX.'/activation/toggleStatus'); 
    $data['multitrashurl'] = URL::to(PREFIX.'/activation/multitrash'); 
    return $data;
  }

  public function dataForForm($id)
    {   
      $data['editFormData'] = $this->activationdatasModel->getDataById($id);
      $data['editUrl']=URL::to(PREFIX.'/activation/updateStatus');
        
      return $data;
    }

    public function getExcelSheet()
    {
      return Excel::create('UsersList', function($excel) {

        $items = ActivationDatas::select('fullname', 'passport_num', 'citizenship_num', 'country','status','created_date')->get();
        //$items = DB::table('tbl_activation_datas')->select( 'fullname', 'passport_num', 'citizenship_num', 'country','status','created_date')->get();
        //dd($items);
        $excel->sheet('SheetName', function($sheet) use($items) {
            $sheet->fromModel($items, null, 'A1', true);
            });
        })->export('xls');
    }


    public function updateAllData($data,$id)
    {
      return $this->activationdatasModel->edit($data,$id);

    }

    public function trash($id)
    {
      return $this->activationdatasModel->trash($id);
    }

    public function multiTrash($data)
    {
      $res = array();
      if($this->activationdatasModel->multiTrash($data))
      {
        $res['status']=1;
        $res['msg'] = count($data)." items moved to trash.";
      }
      else
        {
          $res['status']=0;
          $res['msg']="Error moving to trash.";
        }

        return $res;
    }

    public function filtered($data)
    {
      if($data['filterCat']=="all")
      {
        $trashed='any';
        
        $status = 'any';
      }
      elseif($data['filterCat'] =="trashed")
      {
        $trashed= 1;
        
        $status = 'any';
      }
      elseif($data['filterCat'] =="live")
      {
        $trashed = 0;
        $status = 'any';
      }
      else
      {
        $trashed = 'any';
        $status = $data['filterCat'];
      }


      if($data['keyword'] !=="")
      {
        $keyword= $data['keyword'];
        if($data['date'] !=="")
        {
          $date=$data['date'];
          return $this->activationdatasModel->filterDateAndKeyword($keyword,$date,$trashed,$status);
        }
        else
        {
          return $this->activationdatasModel->filterKeyword($keyword,$trashed,$status);
        }
      }
      else
      {
        if($data['date'] !=="")
        {
          $date=$data['date'];
          return $this->activationdatasModel->filterDate($date,$trashed,$status);
        }
        else
        {
          $data['msgSuccess']="Please enter keyword or date to apply filter";
          return  $this->getActivationDatas();
        }
      }
      

    }


    
}