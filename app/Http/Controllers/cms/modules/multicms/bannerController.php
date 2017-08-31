<?php

namespace App\Http\Controllers\cms\modules\multicms;

use Illuminate\Http\Request;
use App\Banner;
use App\Services\BannerService;
use App\Services\BannerLgService;
use App\Services\LanguageService;
use App\Services\DefaultLanguageService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Input;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\customHelper\InputHelpers;
use File;
use Image;
use DB;
use Config;
use URL;
class BannerController extends Controller
{


  public $thisPageId = 'banner';

  public $thisModuleId = "multicms";

  public function __construct(
    BannerService $banner,
    BannerLgService $bannerLg,
    LanguageService $language,
    DefaultLanguageService $defaultLanguage
  ) {

    $this->bannerLg          = $bannerLg;
    $this->banner            = $banner;
    $this->language        = $language;
    $this->defaultLanguage = $defaultLanguage;

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
    $data['pageData']     = $this->banner->getAllDataNoPagination();
    $data['toggleUrl']    = URL::to(PREFIX.'/multicms/pages/banner/toggleStatus');
    return view('cms.modules.multicms.banner_listall', $data);


  }

  /**
   *for toggling status.
   *
   * @return Response
   */
  public function toggleStatus()
  {
    $id = Input::get('id');
    $status = $this->banner->getDataById($id)->status;
    if($status == 'active')
    {
      $data['status'] = 'inactive';
      if($this->banner->updateData($data,$id)){
        echo ucfirst($this->banner->getDataById($id)->status);
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
      
    }
    elseif($status == "inactive")
    {
      $data['status'] = 'active';
      if($this->banner->updateData($data,$id)){
        echo ucfirst($this->banner->getDataById($id)->status);
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
    
    $flags  = $this->language->getAllDataNoPagination();
    $id     = Input::get('id');
    $bannerLg = $this->bannerLg->getAllDataNoPagination();
    $banner   = $this->banner->getDataById($id);

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
        
    return view('cms.modules.multicms.banner_addnew', compact('banner', 'flags', 'bannerLg', 'pageList'), $data);

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

    //

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
   * Update the specified resource in storage.
   *
   * @param  Request $request
   * @param  int     $id
   *
   * @return Response
   */
  public function update()

  {
    //

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

    $delbanner      = $this->banner->getDataById($id);
    

    if ( ! empty( $this->banner->getDataById($id)->image )) {
      $menu_icon = $this->banner->getDataById($id)->image;

      $menuIconDirectory = base_path() . '/uploads/banner/image';

      File::delete($menuIconDirectory . '/' . $menu_icon);

    }

    $delbannersLg = $delbanner->bannerLg;
    // Start transaction!
    DB::beginTransaction();

    if (count($delbannersLg) > 0) {

      foreach ($delbannersLg as $banner_lang) {

        
        //if delete of any news languages fails,rollback all database changes
        //and redirect to news list with error
        try {
          $this->bannerLg->deleteData($banner_lang->id);

        } catch (Exception $e) {
          DB::rollback();
          $data['msgError'] = 'Error! Deleting languages associated with this banner!';

          return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
        }
      }
    }

    if ($this->banner->deleteData($id)) {
      DB::commit();
      $data['msgSuccess'] = 'Successfully deleted Banner !!';

      return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
    } else {
      DB::rollback();
      $data['msgError'] = 'Error! Adding Banner!';

      return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
    }


  }


  public function bannerLgCreate()
  {

    $langId = $this->language->getAllDataNoPagination()->pluck('id');

    //the validation should be done for title and images so,pages module contains
    //validations for fields other than of its own field as well
    // a separate validation for checking if title of default language is set or not.

    $langId = $this->language->getAllDataNoPagination()->pluck('id');

    $defLang = $this->defaultLanguage->getDefaultLang();

    $validationArray = [ "title" => Input::get('form.' . $defLang . '.title') ];

    $validator = $this->banner->validate($validationArray);
    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/multicms/pages/banner/create')->withErrors($validator)->withInput();
    }

    $up_inputs = Input::get('form.banner');

    if (Input::hasFile('form.banner.image')) {
      if (( ( Input::file('form.banner.image')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.banner.image')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.banner.image')->getClientMimeType() ) != "image/png" )) {
        $data['msgError'] = 'The Image is not valid !,only jpeg,jpg,bmp & png image type are supported';

        return redirect(PREFIX . '/multicms/pages/banner/create')->withErrors($data)->withInput();
      }

      if (( Input::file('form.banner.image')->getClientSize() ) > 3200000) {
        $data['msgError'] = 'The image size is very large !,The size must me less than 3MB.';

        return redirect(PREFIX . '/multicms/pages/banner/create')->withErrors($data)->withInput();
      }

      $directory    = base_path() . '/uploads/banner/image';
      $originalName = InputHelpers::cleanURL(Input::file('form.banner.image')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('form.banner.image')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('form.banner.image'));
      $image->fit(1600, 543);
      $image->save($fileNameDir, 100);
      $up_inputs['image'] = $fileName;


    }else{
      $data['msgError'] = 'Image is required !!';
      return redirect(PREFIX . '/multicms/pages/banner/create')->withErrors($data)->withInput();
    }

    //save page data for tbl_page only

    $forRecentBannerId = $this->banner->add($up_inputs);

    if ($forRecentBannerId) {
      //now retrieve recently inserted id of row on tbl_page table.
      $banner_id = $forRecentBannerId->id;
    } else {
      $data['msgError'] = 'Error Adding Banner !!';

      return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
    }

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $lang_id) {

      //create new record in tbl_page_lg
      $inputs = Input::get('form.' . $lang_id);

      $validator = $this->bannerLg->validate($inputs);
      if ($validator->fails()) {
        Session::put('flag', Input::get('form.' . $lang_id . 'language_id'));

        return redirect(PREFIX . '/multicms/pages/banner/manageBanner?id=' . Input::get('form.' . $lang_id . 'banner_id'))->withErrors($validator)->withInput();
      }

      //save changes
      $inputs['banner_id'] = $banner_id;
      if ($this->bannerLg->add($inputs)) {

        $inputs = "";
        if ($i == $len - 1) {
          // last iteration of foreach loop
          $data['msgSuccess'] = 'Successfully saved !!';

          return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
        }

      } else {
        $inputs           = "";
        $data['msgError'] = 'Changes could not be saved !!';

        return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
      }

      $i++;
    }

  }


  public function allUpdate()
  {

    $langId = $this->language->getAllDataNoPagination()->pluck('id');

    //the validation should be done for title and images so,pages module contains
    //validations for fields other than of its own field as well
    // a separate validation for checking if title of default language is set or not.

    $defLang = $this->defaultLanguage->getDefaultLang();

    $validationArray = [ "title" => Input::get('form.' . $defLang . '.title') ];

    $validator = $this->banner->validateUpdate($validationArray, Input::get('form.banner.id'));
    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/multicms/pages/banner/manageBanner?id='.Input::get('form.banner.id'))->withErrors($validator)->withInput();
    }

    $up_inputs = Input::get('form.banner');

    if (Input::hasFile('form.banner.image')) {
      if (( ( Input::file('form.banner.image')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.banner.image')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.banner.image')->getClientMimeType() ) != "image/png" )) {
        $data['msgError'] = 'The Image is not valid !,only jpeg,jpg,bmp & png image type are supported';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/banner/manageBanner?id='.Input::get('form.banner.id'))->withErrors($data)->withInput();
      }

      if (( Input::file('form.banner.image')->getClientSize() ) > 3200000) {
        $data['msgError'] = 'The image size is very large !,The size must me less than 3MB.';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/banner/manageBanner?id=' . Input::get('form.' . $lang_id . '.banner_id'))->withErrors($data)->withInput();
      }

      $directory = base_path() . '/uploads/banner/image';
      $id        = Input::get('form.banner.id');

      //if image exists,delete previous image
      if ($this->banner->getDataById($id)->image !== "") {

        $imageName = $this->banner->getDataById($id)->image;
        File::delete($directory . '/' . $imageName); 

      }

      $originalName = InputHelpers::cleanURL(Input::file('form.banner.image')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('form.banner.image')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('form.banner.image'));
      $image->fit(1600, 543);
      $image->save($fileNameDir, 100);
      $up_inputs['image'] = $fileName;

    }

    //Update page data for tbl_page only,if errors occur redirect to pages list with error
    if ( ! ( $this->banner->updateData($up_inputs, Input::get('form.banner.id')) )) {
      $data['msgError'] = 'Error Adding Banner !!';

      return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
    }

    //for PagesLG Manipulation

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $lang_id) {

      if ( ! empty( Input::get('form.' . $lang_id . '.id') )) {
        //update the existing row on tbl_page_lg table with reference to id.

        $inputs = Input::get('form.' . $lang_id);
        $id     = Input::get('form.' . $lang_id . '.id');

        $validator = $this->bannerLg->validateUpdate(Input::get('form.' . $lang_id), $id);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

          return redirect(PREFIX . '/multicms/pages/banner/manageBanner?id=' . Input::get('form.' . $lang_id . '.banner_id'))->withErrors($validator)->withInput();
        }

        //save changes
        if ($this->bannerLg->updateData($inputs, $id)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
        }


      } else {

        //create new record in tbl_page_lg
        $inputs = Input::get('form.' . $lang_id);

        $validator = $this->bannerLg->validate($inputs);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $lang_id . 'language_id'));

          return redirect(PREFIX . '/multicms/pages/banner/manageBanner?id=' . Input::get('form.' . $lang_id . 'banner_id'))->withErrors($validator)->withInput();
        }

        // Store the pages details

       
        //save changes
        if ($this->bannerLg->add($inputs)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/banner')->withErrors($data);
        }

      }

      $i++;
    }

  }

  //methods for tbl_pages_lg

  /**
   * Display create form for managing Page and inserting tbl_pages_lg.
   *
   * @return Response
   */
  public function manageBanner()
  {

    //from pages edit
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    
    $flags                = $this->language->getAllDataNoPagination();
    $id                   = Input::get('id');
    $bannerLg             = $this->bannerLg->getAllDataNoPagination();
    $banner               = $this->banner->getDataById($id);
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    
    return view('cms.modules.multicms.banner_manage', compact('banner', 'flags', 'bannerLg', 'pageList'), $data);
  }

  /**
   * Display create form for managing Banner and inserting tbl_banner_lg.
   *
   * @return Response
   */

}
