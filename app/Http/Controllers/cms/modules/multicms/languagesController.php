<?php

namespace App\Http\Controllers\cms\modules\multicms;

use Input;
use Illuminate\Http\Request;
use App\Services\LanguageService;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\MultiLangService;
use Image;
use File;
use App\customHelper\InputHelper;
use App\Services\DefaultLanguageService;
use App\customHelper\InputHelpers;
use URL;
class languagesController extends Controller
{

  public $thisPageId = 'language';

  public $thisModuleId = "multicms";
  
  public function __construct(LanguageService $lang, MultiLangService $multilang, DefaultLanguageService $defLang)
  {

    $this->lang      = $lang;
    $this->multilang = $multilang;
    $this->defLang   = $defLang;

  }


  


  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['langData']     = $this->lang->getAllData();
    $data['def_lang']     = $this->defLang->getDefaultLang();
    $data['toggleUrl']    = URL::to(PREFIX.'/multicms/pages/languages/toggleStatus');
    return view('cms.modules.multicms.language_listall', $data);
  }

  /**
   *for toggling status.
   *
   * @return Response
   */
  public function toggleStatus()
  {
    $id = Input::get('id');
    $status = $this->lang->getDataById($id)->status;
    if($status == 'active')
    { 
      //dd($this->lang->getDataById($id)->id);
      $checkDefault = $this->lang->getDataById($id)->id;

      if ($this->defLang->getDefaultLang() == $checkDefault) {
        header('HTTP/1.1 400 Bad Request,can not deactivate default language');
      }

      $data['status'] = 'inactive';
      if($this->lang->updateData($data,$id)){
        echo ucfirst($this->lang->getDataById($id)->status);
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
      
    }
    elseif($status == "inactive")
    {
      $data['status'] = 'active';
      if($this->lang->updateData($data,$id)){
        echo ucfirst($this->lang->getDataById($id)->status);
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

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $data['thisPageId']    = $this->thisPageId;
    $data['thisModuleId']  = $this->thisModuleId;
    $data['multilangData'] = $this->multilang->multiLangList();
    $data['multilang']     = $this->multilang->getAllData();

    return view('cms.modules.multicms.language_addnew', $data);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  Request $request
   *
   * @return Response
   */
  public function store()
  {
    $inputs = Input::all();

    $validator = $this->lang->validate($inputs);
    if ($validator->fails()) {
      return redirect(PREFIX . '/multicms/pages/languages/create')->withErrors($validator)->withInput();
    }

    if (null !== ( Input::get('default_lang') )) {
      $inputs['status'] = "active";
    }

    $inputs['title'] = $this->multilang->getDataById(Input::get('multilang_id'))->name;
    $inputs['slug']  = $this->multilang->getDataById(Input::get('multilang_id'))->code;

    if (Input::hasFile('flag')) {
      //directory for saving flag images.
      $directory = base_path() . '/uploads/flags';
      //removing space 
      $fileInput         = Input::file('flag')->getClientOriginalName();
      $originalNameWSpac = preg_replace('/\s+/', '', $fileInput);
      $originalName      = preg_replace('~[\\\\/:*?"<>|]~', '-', $originalNameWSpac);
      $fileName          = uniqid() . '-' . $originalName;
      $fileNameDir       = $directory . '/' . $fileName;
      $image             = Image::make(Input::file('flag'));
      $image->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $image->save($fileNameDir, 100);
      $inputs['flag'] = $fileName;
    }

    $insertedLang = $this->lang->add($inputs);
    
      if ($insertedLang)
    {
      if (null !== ( Input::get('default_lang') ))
      {
        $defLangInput['def_lang_id'] = $insertedLang->id;
        $this->defLang->updateData($defLangInput, 1);
      }
      $data['msgSuccess'] = "Saved successfully.";
      return redirect(PREFIX . '/multicms/pages/languages')->withErrors($data);
    }
    else
    {
      $data['msgError'] = "Could not Save.";
      return redirect(PREFIX . '/multicms/pages/languages')->withErrors($data);
    }

    

  }


  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function show($id)
  {
    //
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function edit($id)
  {

    $data['id']           = Input::get('id');
    $lang                 = $this->lang->getDataById($data['id']);
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['def_lang']     = $this->defLang->getDefaultLang();

    return view('cms.modules.multicms.language_edit', compact('lang'), $data);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  Request $request
   * @param  int     $id
   *
   * @return Response
   */
  public function update()
  {
    $inputs    = Input::all();
    $id        = Input::get('id');
    $validator = $this->lang->validateUpdate($inputs, $id);
    if ($validator->fails()) {
      return redirect(PREFIX . '/multicms/pages/languages/edit?id=' . $id)->withErrors($validator)->withInput();
    }

    if (Input::hasFile('flag')) {

      $imageName = $this->lang->getDataById($id)->flag;

      $directory = base_path() . '/uploads/flags';

      //if image exists,delete previous image
      if ($this->lang->getDataById($id)->flag !== "") {
        File::delete($directory . '/' . $imageName);
      }

      $originalName = InputHelpers::filterSpchar(Input::file("flag")->getClientOriginalName());
      $fileName     = uniqid() . $originalName;
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('flag'));
      $image->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      });

      $image->save($fileNameDir, 100);
      $inputs['flag'] = $fileName;
    }
    if ($this->lang->updateData($inputs, $id)) {

      //if set as default language
      if (null !== ( Input::get('default_lang') )) {
        $defLangInput['def_lang_id'] = $id;
        $this->lang->updateData(['status' => 'active'],$id);
        $this->defLang->updateData($defLangInput, 1);
      }
      $data['msgSuccess'] = "Saved updated.";
      return redirect(PREFIX . '/multicms/pages/languages')->withErrors($data);
    } else {
      $data['msgError'] = "could not update";
      return redirect(PREFIX . '/multicms/pages/languages')->withErrors($data);
    }

  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function destroy()
  {
    $id = Input::get('id');

    if ($this->defLang->getDefaultLang() == $id) {
      $data['msgError'] = "This is Default Language,please make some other lamguage default and then try to delete this language !!";
      return redirect(PREFIX . '/multicms/pages/languages')->withErrors($data);
    }

    if ($this->lang->getDataById($id)->slug == 'en') {
        $data['msgError'] = "You cannot delete English language !!";
        return redirect(PREFIX . '/multicms/pages/languages')->withErrors($data);
    }

    if ( ! empty( $this->lang->getDataById($id)->flag )) {

      $flag = $this->lang->getDataById($id)->flag;

      $menuIconDirectory = base_path() . '/uploads/flags';

      File::delete($menuIconDirectory . '/' . $flag);

    }

    
    

    if ($this->lang->deleteDataPerm($id)) {
      $data['msgSuccess'] = "Successfully deleted language";
      return redirect(PREFIX . '/multicms/pages/languages')->withErrors($data);
    } else {
      $data['msgError']   = "Error! deleting language";
      return redirect(PREFIX . '/multicms/pages/languages')->withErrors($data);
    }
  }
}
