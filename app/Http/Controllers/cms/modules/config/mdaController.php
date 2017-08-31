<?php

namespace App\Http\Controllers\cms\modules\config;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\MdaService;
use App\Services\ActionService;
use App\Services\FunctionService;
use App\Services\LanguageService;
use Input;
use Redirect;

class mdaController extends Controller
{
    public $thisPageId = 'Tools / Config';
    public $thisModuleId = "config";

    public function __construct(){
        $this->mdaService = new MdaService;
        $this->actionService = new ActionService;
        $this->functionService = new FunctionService;
        $this->languageService = new LanguageService;
    }

    public function index()
    {
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;
        $data['languages'] = $this->languageService->getAllActiveData();
        $data['functions'] = $this->functionService->getAllActiveData();
        $data['actions'] = $this->actionService->getAllActiveData();
        return view(PREFIX.".modules.config.mda.main",$data);
    } 

    public function addMda()
    {/*
        $validator=$this->adminService->adminValidation(Input::all());
        if($validator->fails())return Redirect::back()->withErrors($validator)->withInput(Input::all());   
        if($this->adminService->checkUsernameExists(Input::get('username')))
        {
            $errors['username']='Username already exists';
            return Redirect::back()->withErrors($errors);
        }
        if($this->adminService->checkEmailExists(Input::get('email')))
        {
            $errors['email']='Email already exists';
            return Redirect::back()->withErrors($errors);
        } */
        $error['msg'] = 'added';
        $this->mdaService->create(Input::all());
        return Redirect::back()->withErrors($error);
    }

    public function search(){
        $keywords=Input::get('keywords');
        $data['searchData']=$this->productService->searchData($keywords);
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;
        $data['keywords']=$keywords;
        return view(PREFIX.".modules.products.products-search-results",$data);
    }
}
