<?php
namespace App\Http\Controllers\cms\modules\adminConfig;

use Input;
use Illuminate\Http\Request;
use App\Services\CmsGeneralSettingsService;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\MultiLangService;
use Image;
use File;
use App\customHelper\InputHelper;
use App\Services\DefaultLanguageService;
use App\customHelper\InputHelpers;

class settingsController extends Controller
{
  
  public function __construct(CmsGeneralSettingsService $settings, DefaultLanguageService $defLang) {
    
    $this->generalSettings = $settings;
    $this->defLang = $defLang;
  }
  
  public $thisPageId = 'General Settings';
  
  public $thisModuleId = "adminConfig";
  
  public function index() {
    $generalSettings = $this->generalSettings->getGeneralSettings();
    $data['thisPageId'] = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    
    return view('cms.modules.adminConfig.CmsGeneralSettings.edit', compact('generalSettings'), $data);
  }
  
  public function update() {
    $inputs = Input::all();
    
    if($this->generalSettings->count() <= 0)
    {
      return $this->addnew();
    }
    else
    {
    $validator = $this->generalSettings->validate($inputs);
    if ($validator->fails()) {
      return redirect(PREFIX . '/adminConfig/pages/settings')->withErrors($validator)->withInput();
    }
    
    if (Input::hasFile('og_image')) {
      
      $imageName = $this->generalSettings->getGeneralSettings()->og_image;
      
      $directory = public_path() . '/uploads/settings/og_image';
      
      //if image exists,delete previous image
      if ($imageName !== "") {
        if (!File::delete($directory . '/' . $imageName)) {
          return redirect(PREFIX . '/adminConfig/pages/settings')->withErrors('Could not delete og image ');
        }
      }
      
      $originalName = InputHelpers::filterSpchar(Input::file("og_image")->getClientOriginalName());
      $fileName = uniqid() . $originalName;
      $fileNameDir = $directory . '/' . $fileName;
      $image = Image::make(Input::file('og_image'));
      
      $image->resize(500, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      
      $image->save($fileNameDir, 100);
      $inputs['og_image'] = $fileName;
    }
    
    if (Input::hasFile('homepage_popup_image')) {
      
      $imageName = $this->generalSettings->getGeneralSettings()->homepage_popup_image;
      
      $directory = public_path() . '/uploads/settings/homepage_popup_image';
      
      //if image exists,delete previous image
      if ($imageName !== "") {
        if (!File::delete($directory . '/' . $imageName)) {
          return redirect(PREFIX . '/adminConfig/pages/settings')->withErrors('Could not delete Home Page Popup image ');
        }
      }
      
      $originalName = InputHelpers::filterSpchar(Input::file("homepage_popup_image")->getClientOriginalName());
      $fileName = uniqid() . $originalName;
      $fileNameDir = $directory . '/' . $fileName;
      $image = Image::make(Input::file('homepage_popup_image'));
      
      $image->resize(500, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      
      $image->save($fileNameDir, 100);
      $inputs['homepage_popup_image'] = $fileName;
    }
    if ($this->generalSettings->updateData($inputs, 1)) {
      
      //if set as default language
      $data['msgSuccess'] = "Saved successfully.";
      
      return redirect(PREFIX . '/adminConfig/pages/settings')->withErrors($data);
    } 
    else {
      $data['msgError'] = "cannot Save.";
      
      return redirect(PREFIX . '/adminConfig/pages/settings')->withErrors($data);
    }
  }
}

  public function addnew()
  {

    $inputs = Input::all();
    $validator = $this->generalSettings->validate($inputs);
    if ($validator->fails()) {
      return redirect(PREFIX . '/adminConfig/pages/settings')->withErrors($validator)->withInput();
    }
    
    if (Input::hasFile('og_image')) {
      
      $directory = public_path() . '/uploads/settings/og_image';
      
      $originalName = InputHelpers::filterSpchar(Input::file("og_image")->getClientOriginalName());
      $fileName = uniqid() . $originalName;
      $fileNameDir = $directory . '/' . $fileName;
      $image = Image::make(Input::file('og_image'));
      
      $image->resize(500, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      
      $image->save($fileNameDir, 100);
      $inputs['og_image'] = $fileName;
    }
    
    if (Input::hasFile('homepage_popup_image')) {
      
      $directory = public_path() . '/uploads/settings/homepage_popup_image';
      
      $originalName = InputHelpers::filterSpchar(Input::file("homepage_popup_image")->getClientOriginalName());
      $fileName = uniqid() . $originalName;
      $fileNameDir = $directory . '/' . $fileName;
      $image = Image::make(Input::file('homepage_popup_image'));
      
      $image->resize(500, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      
      $image->save($fileNameDir, 100);
      $inputs['homepage_popup_image'] = $fileName;
    }
    if ($this->generalSettings->add($inputs)) {
      
      //if set as default language
      $data['msgSuccess'] = "Saved successfully.";
      
      return redirect(PREFIX . '/adminConfig/pages/settings')->withErrors($data);
    } 
    else {
      $data['msgError'] = "cannot Save.";
      
      return redirect(PREFIX . '/adminConfig/pages/settings')->withErrors($data);
    }

  }

}
