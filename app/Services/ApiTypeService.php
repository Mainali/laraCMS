<?php
namespace App\Services;

use App\Services\EloquentService;
use App\ApiType;
use URL;

class ApiTypeService extends EloquentService
{
    public function __construct() {
        $this->eqModal = new ApiType;
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
    public function getCategorieslist() {
        return $this->eqModal->getCategorieslist();
    }
    public function api_category() {
        return $this->eqModal->api_category();
    }
    public function getFilteredList($fil) {
        return $this->eqModal->getFilteredList($fil);
    }
    // public function find($id){
    //     return $this->
    // }
    public function dataForlist($filterCat=null)
    {
        $data['apiCategories'] = $this->eqModal->getCategorieslist();
        if(null!==$filterCat && $filterCat !=="")
        {
           $data['apiTypeData'] = $this->eqModal->getFilteredList($filterCat);
           $data['filterCat'] = $filterCat; 
        }
            
        else
        {
          $data['apiTypeData'] = $this->eqModal->getAllData();
            $data['filterCat'] = '';  
        }
        $data['editUrl']= URL::to(PREFIX.'/api/pages/types/edit');
        $data['addUrl'] = URL::to(PREFIX.'/api/pages/types/addnew');
        $data['toggleUrl'] = URL::to(PREFIX.'/api/pages/types/toggleStatus');
        $data['deleteUrl'] = URL::to(PREFIX.'/api/pages/types/delete');  
            
        return $data;
    }
    public function dataForForm($id=null)
    {   
        if($id !== null)
        {
            $data['apiTypeFormData'] = $this->eqModal->getDataById($id);
            
        }
        $data['apiCategories'] = $this->eqModal->getCategorieslist();
        return $data;
    }


}
