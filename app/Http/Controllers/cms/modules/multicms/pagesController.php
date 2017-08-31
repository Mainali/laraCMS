<?php

namespace App\Http\Controllers\cms\modules\multicms;

use Illuminate\Http\Request;
use App\Page;
use App\Services\PageService;
use App\Services\PagesLgService;
use App\Services\LanguageService;
use App\Services\DefaultLanguageService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\customHelper\InputHelpers;
use Input;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Image;
use DB;
use Config;
use URL;
class pagesController extends Controller
{

  public $thisPageId = 'pages';

  public $thisModuleId = "multicms";

  public function __construct(
    PageService $page,
    PagesLgService $pageLg,
    LanguageService $language,
    DefaultLanguageService $defaultLanguage
  ) {

    $this->pageLg          = $pageLg;
    $this->page            = $page;
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
    $rootParentTitleList = $this->page->rootParentListForTitle();
    //dd($rootParentTitleList);
    $rootParent = $this->page->rootParentList();
    $dash       = "";
    $recurArray = [ ];
    $recurTitleList  = $this->page->recur($rootParent, $dash, $recurArray);
   // dd($recurTitleList);
    $collection      = collect([ ]);
    $recurCollection = $this->page->recurList($recurTitleList, $collection);

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['pageData']     = $recurCollection;
    $data['toggleUrl']    = URL::to(PREFIX.'/multicms/pages/pages/toggleStatus');
    return view('cms.modules.multicms.pages_listall', $data);


  }

   /**
   *for toggling status.
   *
   * @return Response
   */
  public function toggleStatus()
  {
    $id = Input::get('id');
    $status = $this->page->getDataById($id)->status;
    if($status == 'active')
    {
      $data['status'] = 'inactive';
      if($this->page->updateData($data,$id)){
        echo ucfirst($this->page->getDataById($id)->status);
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
      
    }
    elseif($status == "inactive")
    {
      $data['status'] = 'active';
      if($this->page->updateData($data,$id)){
        echo ucfirst($this->page->getDataById($id)->status);
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
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function menuIconDelete($id)
  {    
    $id = Input::get('id');

    $delImage = $this->page->getDataById($id);

    $image = 'uploads/pages/menu_icon';
    File::delete($image . '/' . $delImage->menu_icon);


    $delImage->menu_icon = '';
    $delImage->save();

    $data['msgSuccess'] = 'Successfully deleted Menu Icon for this Page !';
    return redirect(PREFIX . '/multicms/pages/pages/managePage?id='.$id)->withErrors($data);
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function thumbDelete($id)
  {    
    $id = Input::get('id');
    $pages_lg_id = Input::get('pages_lg_id');

    $delImage = $this->pageLg->getDataById($pages_lg_id);

    $image = 'uploads/pages/thumbnails';
    File::delete($image . '/' . $delImage->thumbnails);


    $delImage->thumbnails = '';
    $delImage->save();

    $data['msgSuccess'] = 'Successfully deleted Thumbnail for this Page !';
    return redirect(PREFIX . '/multicms/pages/pages/managePage?id='.$id)->withErrors($data);
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function bannerDelete($id)
  {    
    $id = Input::get('id');
    $pages_lg_id = Input::get('pages_lg_id');

    $delImage = $this->pageLg->getDataById($pages_lg_id);

    $image = 'uploads/pages/banner';
    File::delete($image . '/' . $delImage->banner);


    $delImage->banner = '';
    $delImage->save();

    $data['msgSuccess'] = 'Successfully deleted Banner for this Page !';
    return redirect(PREFIX . '/multicms/pages/pages/managePage?id='.$id)->withErrors($data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $rootParent = $this->page->rootParentList();
    $dash       = "";
    $dropdown   = [ ];

    if (empty( $rootParent )) {
      $pageList = [ "" => 'Select Page' ];
    } else {
      $pageList = [ "" => 'Select Page' ] + $this->page->recur($rootParent, $dash, $dropdown);
    }

    //from PagesLg Manage
    $flags  = $this->language->getAllDataNoPagination();
    $id     = Input::get('id');
    $pageLg = $this->pageLg->getAllDataNoPagination();
    $page   = $this->page->getDataById($id);

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['page_template'] = Config::get("zcmsconfig.page_template");
    
    return view('cms.modules.multicms.pages_addnew', compact('page', 'flags', 'pageLg', 'pageList'), $data);

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

    $delPage      = $this->page->getDataById($id);
    $delPageCount = count($delPage->child);

    //if page to be deleted contains child page throw error
    if ($delPageCount > 0) {
      $data['msgError'] = 'The Page contains child Pages,delete all its child Pages before deleting this Page   !!';

      return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
    }

    if ( ! empty( $this->page->getDataById($id)->menu_icon )) {
      $menu_icon = $this->page->getDataById($id)->menu_icon;

      $menuIconDirectory = base_path() . '/uploads/pages/menu_icon';

      File::delete($menuIconDirectory . '/' . $menu_icon);

    }

    $delpagesLg = $delPage->pagesLg;
    // Start transaction!
    DB::beginTransaction();

    if (count($delpagesLg) > 0) {

      foreach ($delpagesLg as $page_lang) {

        if ( ! empty( $page_lang->banner )) {
          $banner = $page_lang->banner;

          $menuIconDirectory = base_path() . '/uploads/pages/banner';

          File::delete($menuIconDirectory . '/' . $banner);

        }

        if ( ! empty( $page_lang->thumbnails )) {
          $thumbnails = $page_lang->thumbnails;

          $menuIconDirectory = base_path() . '/uploads/pages/thumbnails';

          File::delete($menuIconDirectory . '/' . $thumbnails);

        }
        //if delete of any news languages fails,rollback all database changes
        //and redirect to news list with error
        try {
          $this->pageLg->deleteData($page_lang->id);

        } catch (Exception $e) {
          DB::rollback();
          $data['msgError'] = 'Error! Deleting languages associated with this news!';

          return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
        }
      }
    }

    if ($this->page->deleteData($id)) {
      DB::commit();
      $data['msgSuccess'] = 'Successfully deleted Page !!';

      return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
    } else {
      DB::rollback();
      $data['msgError'] = 'Error! Adding Page!';

      return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
    }


  }


  public function pagesLgCreate()
  {

    $langId = $this->language->getAllDataNoPagination()->pluck('id');

    //the validation should be done for title and images so,pages module contains
    //validations for fields other than of its own field as well
    // a separate validation for checking if title of default language is set or not.

    $langId = $this->language->getAllDataNoPagination()->pluck('id');

    $defLang = $this->defaultLanguage->getDefaultLang();

    $validationArray = [ "title" => Input::get('form.' . $defLang . '.title') ] + [ "slug" => Input::get('form.page.slug') ] + [ "position" => Input::get('form.page.position') ];

    $validator = $this->page->validate($validationArray);
    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/multicms/pages/pages/create')->withErrors($validator)->withInput();
    }

    $up_inputs = Input::get('form.page');

    if (Input::hasFile('form.page.menu_icon')) {
      if (( ( Input::file('form.page.menu_icon')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.page.menu_icon')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.page.menu_icon')->getClientMimeType() ) != "image/png" )) {
        $data['msgError'] = 'The Icon Image is not valid !,only jpeg,jpg,bmp & png image type are supported';

        return redirect(PREFIX . '/multicms/pages/pages/create')->withErrors($data)->withInput();
      }

      if (( Input::file('form.page.menu_icon')->getClientSize() ) > 3200000) {
        $data['msgError'] = 'The menu icon image size is very large !,The size must me less than 3MB.';

        return redirect(PREFIX . '/multicms/pages/pages/create')->withErrors($data)->withInput();
      }

      $directory    = base_path() . '/uploads/pages/menu_icon';
      $originalName = InputHelpers::cleanURL(Input::file('form.page.menu_icon')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('form.page.menu_icon')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('form.page.menu_icon'));
      $image->resize(500, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $image->save($fileNameDir, 100);
      $up_inputs['menu_icon'] = $fileName;


    }

    //save page data for tbl_page only

    $forRecentPageId = $this->page->add($up_inputs);

    if ($forRecentPageId) {
      //now retrieve recently inserted id of row on tbl_page table.
      $page_id = $forRecentPageId->id;
    } else {
      $data['msgError'] = 'Error Adding Page !!';

      return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
    }

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $lang_id) {

      //create new record in tbl_page_lg
      $inputs = Input::get('form.' . $lang_id);

      $validator = $this->pageLg->validate($inputs);
      if ($validator->fails()) {
        Session::put('flag', Input::get('form.' . $lang_id . 'language_id'));

        return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . 'page_id'))->withErrors($validator)->withInput();
      }

      if (Input::file('form.' . $lang_id . '.thumbnails')) {

        if (( ( Input::file('form.' . $lang_id . '.thumbnails')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.' . $lang_id . '.thumbnails')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.' . $lang_id . '.thumbnails')->getClientMimeType() ) != "image/png" )) {
          $data['msgError'] = 'The image is not valid !,only jpeg,jpg,bmp & png image type are supported';
          Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

          return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
        }

        if (( Input::file('form.' . $lang_id . '.thumbnails')->getClientSize() ) > 3200000) {
          $data['msgError'] = 'The image size is very large !,The size must me less than 3MB.';
          Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

          return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
        }

        $directory    = base_path() . '/uploads/pages/thumbnails';
        $originalName = InputHelpers::cleanURL(Input::file('form.' . $lang_id . '.thumbnails')->getClientOriginalName());
        $fileName     = uniqid() .'.'.Input::file('form.' . $lang_id . '.thumbnails')->getClientOriginalExtension();
        $fileNameDir  = $directory . '/' . $fileName;
        $image        = Image::make(Input::file('form.' . $lang_id . '.thumbnails'));
        $image->resize(500, null, function ($constraint) {
          $constraint->aspectRatio();
        });
        $image->save($fileNameDir, 100);
        $inputs['thumbnails'] = $fileName;
      }

      if (Input::hasFile('form.' . $lang_id . '.banner')) {

        if (( ( Input::file('form.' . $lang_id . '.banner')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.' . $lang_id . '.banner')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.' . $lang_id . '.banner')->getClientMimeType() ) != "image/png" )) {
          $data['msgError'] = 'The image is not valid !,only jpeg,jpg,bmp & png image type are supported';
          Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

          return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
        }

        if (( Input::file('form.' . $lang_id . '.banner')->getClientSize() ) > 3200000) {
          $data['msgError'] = 'The image size is very large !,The size must me less than 3MB.';
          Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

          return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
        }

        $directory    = base_path() . '/uploads/pages/banner';
        $originalName = InputHelpers::cleanURL(Input::file('form.' . $lang_id . '.banner')->getClientOriginalName());
        $fileName     = uniqid() .'.'.Input::file('form.' . $lang_id . '.banner')->getClientOriginalExtension();
        $fileNameDir  = $directory . '/' . $fileName;
        $image        = Image::make(Input::file('form.' . $lang_id . '.banner'));
        // $image->resize(500, null, function ($constraint) {
        //   $constraint->aspectRatio();
        // });
        $image->save($fileNameDir, 100);
        $inputs['banner'] = $fileName;
      }

      //save changes
      $inputs['page_id'] = $page_id;
      if ($this->pageLg->add($inputs)) {

        $inputs = "";
        if ($i == $len - 1) {
          // last iteration of foreach loop
          $data['msgSuccess'] = 'Successfully saved !!';

          return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
        }

      } else {
        $inputs           = "";
        $data['msgError'] = 'Changes could not be saved !!';

        return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
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

    $validationArray = [ "title" => Input::get('form.' . $defLang . '.title') ] + [ "slug" => Input::get('form.page.slug') ] + [ "position" => Input::get('form.page.position') ];

    $validator = $this->page->validateUpdate($validationArray, Input::get('form.page.id'));
    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/multicms/pages/pages/managePage?id='.Input::get('form.page.id'))->withErrors($validator)->withInput();
    }

    $up_inputs = Input::get('form.page');

    if (Input::hasFile('form.page.menu_icon')) {
      if (( ( Input::file('form.page.menu_icon')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.page.menu_icon')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.page.menu_icon')->getClientMimeType() ) != "image/png" )) {
        $data['msgError'] = 'The Icon Image is not valid !,only jpeg,jpg,bmp & png image type are supported';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/pages/managePage?id='.Input::get('form.page.id'))->withErrors($data)->withInput();
      }

      if (( Input::file('form.page.menu_icon')->getClientSize() ) > 3200000) {
        $data['msgError'] = 'The menu icon image size is very large !,The size must me less than 3MB.';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
      }

      $directory = base_path() . '/uploads/pages/menu_icon';
      $id        = Input::get('form.page.id');

      //if image exists,delete previous image
      if ($this->page->getDataById($id)->menu_icon !== "") {

        $imageName = $this->page->getDataById($id)->menu_icon;
        File::delete($directory . '/' . $imageName); 

      }

      $originalName = InputHelpers::cleanURL(Input::file('form.page.menu_icon')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('form.page.menu_icon')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('form.page.menu_icon'));
      $image->resize(500, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $image->save($fileNameDir, 100);
      $up_inputs['menu_icon'] = $fileName;

    }

    //Update page data for tbl_page only,if errors occur redirect to pages list with error
    if ( ! ( $this->page->updateData($up_inputs, Input::get('form.page.id')) )) {
      $data['msgError'] = 'Error Adding Page !!';

      return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
    }

    //for PagesLG Manipulation

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $lang_id) {

      if ( ! empty( Input::get('form.' . $lang_id . '.id') )) {
        //update the existing row on tbl_page_lg table with reference to id.

        $inputs = Input::get('form.' . $lang_id);
        $id     = Input::get('form.' . $lang_id . '.id');

        $validator = $this->pageLg->validateUpdate(Input::get('form.' . $lang_id), $id);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

          return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($validator)->withInput();
        }

        if (Input::hasFile('form.' . $lang_id . '.thumbnails')) {

          if (( ( Input::file('form.' . $lang_id . '.thumbnails')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.' . $lang_id . '.thumbnails')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.' . $lang_id . '.thumbnails')->getClientMimeType() ) != "image/png" )) {
            $data['msgError'] = 'The image is not valid !,only jpeg,jpg,bmp & png image type are supported';
            Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

            return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
          }

          if (( Input::file('form.' . $lang_id . '.thumbnails')->getClientSize() ) > 3200000) {
            $data['msgError'] = 'The image size is very large !,The size must me less than 3MB.';
            Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

            return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
          }

          $directory = base_path() . '/uploads/pages/thumbnails';

          //if image exists,delete previous image
          if ($this->pageLg->getDataById($id)->thumbnails !== "") {
            $imageName = $this->pageLg->getDataById($id)->thumbnails;
            File::delete($directory . '/' . $imageName);

          }

          $originalName = InputHelpers::cleanURL(Input::file('form.' . $lang_id . '.thumbnails')->getClientOriginalName());
          $fileName     = uniqid() .'.'.Input::file('form.' . $lang_id . '.thumbnails')->getClientOriginalExtension();
          $fileNameDir  = $directory . '/' . $fileName;
          $image        = Image::make(Input::file('form.' . $lang_id . '.thumbnails'));
          $image->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
          });

          $image->save($fileNameDir, 100);
          $inputs['thumbnails'] = $fileName;
        }

        if (Input::hasFile('form.' . $lang_id . '.banner')) {

          if (( ( Input::file('form.' . $lang_id . '.banner')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.' . $lang_id . '.banner')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.' . $lang_id . '.banner')->getClientMimeType() ) != "image/png" )) {
            $data['msgError'] = 'The image is not valid !,only jpeg,jpg,bmp & png image type are supported';
            Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

            return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
          }

          if (( Input::file('form.' . $lang_id . '.banner')->getClientSize() ) > 3200000) {
            $data['msgError'] = 'The image size is very large !,The size must me less than 3MB.';
            Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

            return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
          }

          $imageName = $this->pageLg->getDataById($id)->banner;

          $directory = base_path() . '/uploads/pages/banner';

          //if image exists,delete previous image
          if ($this->pageLg->getDataById($id)->banner !== "") {

            File::delete($directory . '/' . $imageName);

          }

          $originalName = InputHelpers::cleanURL(Input::file('form.' . $lang_id . '.banner')->getClientOriginalName());
          $fileName     = uniqid() .'.'.Input::file('form.' . $lang_id . '.banner')->getClientOriginalExtension();
          $fileNameDir  = $directory . '/' . $fileName;
          $image        = Image::make(Input::file('form.' . $lang_id . '.banner'));
          // $image->resize(500, null, function ($constraint) {
          //   $constraint->aspectRatio();
          // });

          $image->save($fileNameDir, 100);
          $inputs['banner'] = $fileName;

        }

        //save changes
        if ($this->pageLg->updateData($inputs, $id)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
        }


      } else {

        //create new record in tbl_page_lg
        $inputs = Input::get('form.' . $lang_id);

        $validator = $this->pageLg->validate($inputs);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $lang_id . 'language_id'));

          return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . 'page_id'))->withErrors($validator)->withInput();
        }

        // Store the pages details

        if (Input::hasFile('form.' . $lang_id . '.thumbnails')) {

          if (( ( Input::file('form.' . $lang_id . '.thumbnails')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.' . $lang_id . '.thumbnails')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.' . $lang_id . '.thumbnails')->getClientMimeType() ) != "image/png" )) {
            $data['msgError'] = 'The image is not valid !,only jpeg,jpg,bmp & png image type are supported';
            Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

            return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
          }

          if (( Input::file('form.' . $lang_id . '.thumbnails')->getClientSize() ) > 3200000) {
            $data['msgError'] = 'The image size is very large !,The size must me less than 3MB.';
            Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

            return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
          }

          $directory = base_path() . '/uploads/pages/thumbnails';

          $originalName = InputHelpers::cleanURL(Input::file('form.' . $lang_id . '.thumbnails')->getClientOriginalName());
          $fileName     = uniqid() .'.'.Input::file('form.' . $lang_id . '.thumbnails')->getClientOriginalExtension();
          $fileNameDir  = $directory . '/' . $fileName;
          $image        = Image::make(Input::file('form.' . $lang_id . '.thumbnails'));
          $image->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
          });
          $image->save($fileNameDir, 100);
          $inputs['thumbnails'] = $fileName;
        }

        if (Input::hasFile('form.' . $lang_id . '.banner')) {

          if (( ( Input::file('form.' . $lang_id . '.banner')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.' . $lang_id . '.banner')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.' . $lang_id . '.banner')->getClientMimeType() ) != "image/png" )) {
            $data['msgError'] = 'The image is not valid !,only jpeg,jpg,bmp & png image type are supported';
            Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

            return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
          }

          if (( Input::file('form.' . $lang_id . '.banner')->getClientSize() ) > 3200000) {
            $data['msgError'] = 'The image size is very large !,The size must me less than 3MB.';
            Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

            return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($data)->withInput();
          }

          $directory    = base_path() . '/uploads/pages/banner';
          $originalName = InputHelpers::cleanURL(Input::file('form.' . $lang_id . '.banner')->getClientOriginalName());
          $fileName     = uniqid() .'.'.Input::file('form.' . $lang_id . '.banner')->getClientOriginalExtension();
          $fileNameDir  = $directory . '/' . $fileName;
          $image        = Image::make(Input::file('form.' . $lang_id . '.banner'));
          // $image->resize(500, null, function ($constraint) {
          //   $constraint->aspectRatio();
          // });
          $image->save($fileNameDir, 100);
          $inputs['banner'] = $fileName;
        }

        //save changes
        if ($this->pageLg->add($inputs)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/pages')->withErrors($data);
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
  public function managePage()
  {

    //from pages edit

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    $rootParent = $this->page->rootParentList();
    $dash       = "";
    $dropdown   = [ ];
    $pageList   = [ "" => 'Select Page' ] + $this->page->recur($rootParent, $dash, $dropdown);

    //for PagesLg Manage
    $flags                = $this->language->getAllDataNoPagination();
    $id                   = Input::get('id');
    $pageLg               = $this->pageLg->getAllDataNoPagination();
    $page                 = $this->page->getDataById($id);
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['page_template'] = Config::get("zcmsconfig.page_template");

    return view('cms.modules.multicms.pages_manage', compact('page', 'flags', 'pageLg', 'pageList'), $data);
  }

  /**
   * Display create form for managing Page and inserting tbl_pages_lg.
   *
   * @return Response
   */

}
