<?php
namespace App\Services;

use App\Services\EloquentService;
use App\MobileBuilt;
use URL;

class MobileBuiltService extends EloquentService
{
    public function __construct() {
        $this->eqModal = new MobileBuilt;
    }
    public function getAllData() {
        return $this->eqModal->getAllData();
    }
    public function create($data) {
        return $this->eqModal->add($data);
    }
    public function getDataById($id) {
        return $this->eqModal->getDataById($id);
    }
    public function deleteData($id) {
        return $this->eqModal->deleteData($id);
    }
    public function editData($data, $id) {
        return $this->eqModal->edit($data, $id);
    }
    public function api_type()
    {
        return $this->eqModal->api_type();
    }
     public function updateAllData($data,$id)
    {
      return $this->eqModal->edit($data,$id);

    }


    public function dataForlist($filterCat=null)
    {
        
        if(null!==$filterCat && $filterCat !=="")
        {
           $data['getApkBuilt'] = $this->eqModal->getAllBuilt();
           $data['filterCat'] = $filterCat; 
        }
            
        else
        {
          $data['getApkBuilt'] = $this->eqModal->getAllBuilt();
            $data['filterCat'] = '';  
        }
        $data['editUrl']= URL::to(PREFIX.'/mobileBuilt/edit');
        $data['addUrl'] = URL::to(PREFIX.'/mobileBuilt/addnew');
        $data['toggleUrl'] = URL::to(PREFIX.'/mobileBuilt/toggleStatus'); 
        $data['deleteUrl'] = URL::to(PREFIX.'/mobileBuilt/delete');  
        return $data;
    }
    public function dataForForm($id=null)
    {   
        if($id !== null)
        {
            $data['apiCatFormData'] = $this->eqModal->getDataById($id);
            
        }
        //$data['apiCategories'] = $this->eqModal->getCategorieslist();
        return $data;
    }
   public function delete($id){
return $this->eqModal->deleteApk($id);
   } 


}
