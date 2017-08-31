<?php
namespace App\Services;

use App\ApiConfig;
use URL;

class ApiConfigService
{
    public function __construct() {
        $this->eqModal = new ApiConfig;
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
    public function dataForlist($filterCat=null)
    {
        
        if(null!==$filterCat && $filterCat !=="")
        {
           $data['apiConfigData'] = $this->eqModal->getFilteredList($filterCat);
           $data['filterCat'] = $filterCat; 
        }
            
        else
        {
          $data['apiConfigData'] = $this->eqModal->getAllData();
            $data['filterCat'] = '';  
        }
        $data['editUrl']= URL::to(PREFIX.'/api/pages/config/edit');
        $data['addUrl'] = URL::to(PREFIX.'/api/pages/config/addnew');
        $data['toggleUrl'] = URL::to(PREFIX.'/api/pages/config/toggleStatus'); 
        $data['deleteUrl'] = URL::to(PREFIX.'/api/pages/config/delete');  
        return $data;
    }
    public function dataForForm($id=null)
    {   
        if($id !== null)
        {
            $data['apiConfigFormData'] = $this->eqModal->getDataById($id);
            
        }
        //$data['apiCategories'] = $this->eqModal->getCategorieslist();
        return $data;
    }
}
