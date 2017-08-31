<?php
namespace App\Services;

use App\Services\EloquentService;
use App\ApiCategories;
use URL;

class ApiCategoriesService extends EloquentService
{
    public function __construct() {
        $this->eqModal = new ApiCategories;
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
    public function dataForlist($filterCat=null)
    {
        
        if(null!==$filterCat && $filterCat !=="")
        {
           $data['apiCatData'] = $this->eqModal->getFilteredList($filterCat);
           $data['filterCat'] = $filterCat; 
        }
            
        else
        {
          $data['apiCatData'] = $this->eqModal->getAllData();
            $data['filterCat'] = '';  
        }
        $data['editUrl']= URL::to(PREFIX.'/api/pages/categories/edit');
        $data['addUrl'] = URL::to(PREFIX.'/api/pages/categories/addnew');
        $data['toggleUrl'] = URL::to(PREFIX.'/api/pages/categories/toggleStatus'); 
        $data['deleteUrl'] = URL::to(PREFIX.'/api/pages/categories/delete');  
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
    


}
