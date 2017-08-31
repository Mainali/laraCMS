<?php
namespace App\Services;

use App\ApiLogin;
use App\Authorization;
use URL;
use Config;

class ApiUsersService
{
    public function __construct() {
        $this->eqModal = new ApiLogin;
        $this->authModal = new Authorization;
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
           $data['apiUsersData'] = $this->eqModal->getWhereStatus($filterCat);
           $data['filterCat'] = $filterCat; 
        }
            
        else
        {
          $data['apiUsersData'] = $this->eqModal->getAllData();
            $data['filterCat'] = '';  
        }

        $data['apiUsersStatus']  = array('' =>'Select Status' ,'New' =>'New','Active' =>'Active','Blocked' => 'Blocked');

        $data['editUrl']= URL::to(PREFIX.'/api/pages/config/edit');
        $data['addUrl'] = URL::to(PREFIX.'/apiusers/addnew');
        $data['toggleUrl'] = URL::to(PREFIX.'/api/pages/config/toggleStatus'); 
        $data['deleteUrl'] = URL::to(PREFIX.'/apiusers/delete');  
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

    public function createApiUsers($input)
    {
        //dd($input['firstName']);
        $apikey = Config::get('apiUsersConfig.apiUsers.apiKey');
        $url = Config::get('apiUsersConfig.apiUsers.signupUrl');

        //dd(http_build_query($input). $url );

        $url= $url."?".http_build_query($input);

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('API-KEY:'.$apikey)); 
        curl_setopt($curl,CURLOPT_URL, $url );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if($http_status == 200) $data['status'] = 'ok'; else $data['status'] = 'fail';
    
        $data['msg'] = $result;
        return $data;
    }

    public function deleteApiUsers($input)
    {
        //dd($input['firstName']);
        $oauthtoken = $this->authModal->getAuthTokenByUserId($input['id']);
        $apikey = Config::get('apiUsersConfig.apiUsers.apiKey');
        $url = Config::get('apiUsersConfig.apiUsers.deleteUrl');

       //dd($input['id']);
       if(is_null($oauthtoken))
       {
            $data['status'] = 'fail';
            $data['msg'] = 'auth token not found';
            return $data;
       }

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('API-KEY:'.$apikey,'oauthtoken:'.$oauthtoken)); 
        curl_setopt($curl,CURLOPT_URL, $url );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if($http_status == 200) $data['status'] = 'ok'; else $data['status'] = 'fail';
    
        $data['msg'] = $result;
        return $data;
    }
}
