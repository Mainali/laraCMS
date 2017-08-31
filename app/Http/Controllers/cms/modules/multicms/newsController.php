<?php

namespace App\Http\Controllers\cms\modules\multicms;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\News;
use App\Services\NewsService;
use App\Services\NewsCategoryService;
use App\Services\NewsCategoryLgService;
use App\Services\NewsLgService;
use App\Services\PhotoGalleryService;
use App\Services\LanguageService;
use App\Services\DefaultLanguageService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\customHelper\InputHelpers;
use Input;
use Validator;
use Config;
use File;
use Image;
use DB;
use URL;

class newsController extends Controller
{

  public $thisPageId = 'news';

  public $thisModuleId = "multicms";

  public function __construct(
    NewsService $news,
    NewsLgService $newsLg,
    LanguageService $language,
    NewsCategoryService $newsCategory,
    PhotoGalleryService $photoGallery,
    DefaultLanguageService $defaultLanguage,
    NewsCategoryLgService $newsCategoryLg
  ) {
    $this->news            = $news;
    $this->newsLg          = $newsLg;
    $this->language        = $language;
    $this->newsCategory    = $newsCategory;
    $this->photoGallery    = $photoGallery;
    $this->defaultLanguage = $defaultLanguage;
    $this->newsCategoryLg  = $newsCategoryLg;
  }


  


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  { 
    $filterPinned = Input::get('filter');
    $filterDept = Input::get('filterDept');
    if (isset($filterDept)) {
      $data['filterDept'] = $filterDept ;
    }else{
      $data['filterDept'] = null ;
    }

    if (isset($filterPinned)) {
      if ($filterPinned == 'yes') {
        $data['filterPinned'] = $filterPinned;
        $newsList = $this->news->getAllPinnedAs('yes');
      }elseif ($filterPinned == 'no') {
        $data['filterPinned'] = $filterPinned;
        $newsList = $this->news->getAllPinnedAs('no');
      }else{
        $data['filterPinned'] = null ;
        $newsList = $this->news->getAllOrderBy();
      }

    }else{
      $data['filterPinned'] = null ;
      $newsList             = $this->news->getAllOrderBy();
    }
    $data['toggleUrl'] = URL::to(PREFIX.'/multicms/pages/news/toggleStatus');
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    //$newsList             = $this->news->getAllOrderBy();
    $data['pageData']     = $this->news->categoryList($newsList,$filterDept);
    $data['pinnedList']       = ['' => 'Select Pinned Status','yes'=>'Yes','no'=>'No'];
    $data['newsCategoryList']       = ['' => 'Select Category'] + $this->newsCategory->newsCategoryList();

    return view('cms.modules.multicms.news_listall', $data);
  }

   /**
   *for toggling status.
   *
   * @return Response
   */
  public function toggleStatus()
  {
    $id = Input::get('id');
    $status = $this->news->getDataById($id)->status;
    if($status == 'active')
    {
      $data['status'] = 'inactive';
      if($this->news->updateData($data,$id)){
        echo ucfirst($this->news->getDataById($id)->status);
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
      
    }
    elseif($status == "inactive")
    {
      $data['status'] = 'active';
      if($this->news->updateData($data,$id)){
        echo ucfirst($this->news->getDataById($id)->status);
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
   *for toggling pinned.
   *
   * @return Response
   */
  public function togglePinned()
  {
    $id = Input::get('id');
    $pinned = $this->news->getDataById($id)->pinned;
    if($pinned == 'yes')
    {
      $data['pinned'] = 'no';
      if($this->news->updateData($data,$id)){
        echo ucfirst($this->news->getDataById($id)->pinned);
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
      
    }
    elseif($pinned == "no")
    {
      $data['pinned'] = 'yes';
      if($this->news->updateData($data,$id)){
        echo ucfirst($this->news->getDataById($id)->pinned);
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
   * @return \Illuminate\Http\Response
   */
  public function create()
  { 

    $data['thisPageId']       = $this->thisPageId;
    $data['thisModuleId']     = $this->thisModuleId;
    $data['newsCategoryList'] = $this->newsCategory->newsCategoryList();
    $data['galleryList']      = [ "" => "Please select Gallery" ] + $this->photoGallery->listNormalDropdown();
    $data['page_template'] = Config::get("zcmsconfig.page_template");
    //from newsLg
    $flags = $this->language->getAllDataNoPagination();

    return view('cms.modules.multicms.news_addnew', compact('flags'), $data);


  }


  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
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

    $delThumb = $this->news->getDataById($id);

    $thumb = 'uploads/news/thumbnail';
    File::delete($thumb . '/' . $delThumb->thumbnail);

    $delThumb->thumbnail = '';
    $delThumb->save();

    $data['msgSuccess'] = 'Successfully deleted Thumbnail for this news !';
    return redirect(PREFIX . '/multicms/pages/news/manageNews?id='.$id)->withErrors($data);
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function imageDelete($id)
  {    
    $id = Input::get('id');

    $delImage = $this->news->getDataById($id);

    $image = 'uploads/news/image';
    File::delete($image . '/' . $delImage->image);


    $delImage->image = '';
    $delImage->save();

    $data['msgSuccess'] = 'Successfully deleted Image for this news !';
    return redirect(PREFIX . '/multicms/pages/news/manageNews?id='.$id)->withErrors($data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function manageNews()
  {
    $flags = $this->language->getAllDataNoPagination();
    $id    = Input::get('id');
    //$newsLg=$this->newsLg->getAllDataNoPagination();
    $news         = $this->news->getDataById($id);
    $data['cats'] = $this->news->categoryListbBynews($news);

    $data['thisPageId']       = $this->thisPageId;
    $data['thisModuleId']     = $this->thisModuleId;
    $data['newsCategoryList'] = $this->newsCategory->newsCategoryList();
    $data['galleryList']      = $this->photoGallery->listNormalDropdown();
    $data['page_template'] = Config::get("zcmsconfig.page_template");
    return view('cms.modules.multicms.news_manage', compact('news', 'flags'), $data);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int                      $id
   *
   * @return \Illuminate\Http\Response
   */
  public function allUpdate()
  {
    $langId          = $this->language->getAllDataNoPagination()->pluck('id');
    $defLang         = $this->defaultLanguage->getDefaultLang();
    $validationArray = [ "categories" => Input::get('form.news.categories') ] + [ "slug" => Input::get('form.news.slug') ];
    $validator       = $this->news->validateUpdate($validationArray, Input::get('form.news.id'));
    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/multicms/pages/news/create')->withErrors($validator)->withInput();
    }

    $newsInputs                = Input::get('form.news');
    $category_ids              = $newsInputs['categories'];
    $category                  = implode(",", $category_ids);
    $newsInputs['category_id'] = $category;
    unset( $newsInputs['categories'] );

    if (Input::hasFile('form.news.image')) {
      if (( ( Input::file('form.news.image')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.news.image')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.news.image')->getClientMimeType() ) != "image/png" )) {
        $data['msgError'] = 'The Image is not valid !,only jpeg,jpg,bmp & png image type are supported';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/news/manageNews?id='.Input::get('form.news.id'))->withErrors($data)->withInput();
      }

      if (( Input::file('form.news.image')->getClientSize() ) > 3200000) {
        $data['msgError'] = 'The news image size is very large !,The size must me less than 3MB.';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/news/manageNews?id=' . Input::get('form.' . $lang_id . '.news_id'))->withErrors($data)->withInput();
      }

      $directory = base_path() . '/uploads/news/image';
      $id        = Input::get('form.news.id');

      //if image exists,delete previous image
      if ($this->news->getDataById($id)->image !== "") {

        $imageName = $this->news->getDataById($id)->image;
        File::delete($directory . '/' . $imageName); 

      }

      $originalName = InputHelpers::cleanURL(Input::file('form.news.image')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('form.news.image')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('form.news.image'));
      $image->fit(870, 390);
      $image->save($fileNameDir, 100);
      $newsInputs['image'] = $fileName;

    }

    if (Input::hasFile('form.news.thumbnail')) {
      if (( ( Input::file('form.news.thumbnail')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.news.thumbnail')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.news.thumbnail')->getClientMimeType() ) != "image/png" )) {
        $data['msgError'] = 'The Image is not valid !,only jpeg,jpg,bmp & png image type are supported';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/news/manageNews?id='.Input::get('form.news.id'))->withErrors($data)->withInput();
      }

      if (( Input::file('form.news.thumbnail')->getClientSize() ) > 3200000) {
        $data['msgError'] = 'The news image size is very large !,The size must me less than 3MB.';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/news/manageNews?id=' . Input::get('form.' . $lang_id . '.news_id'))->withErrors($data)->withInput();
      }

      $directory = base_path() . '/uploads/news/thumbnail';
      $id        = Input::get('form.news.id');

      //if image exists,delete previous image
      if ($this->news->getDataById($id)->thumbnail !== "") {

        $imageName = $this->news->getDataById($id)->thumbnail;
        File::delete($directory . '/' . $imageName); 

      }

      $originalName = InputHelpers::cleanURL(Input::file('form.news.thumbnail')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('form.news.thumbnail')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('form.news.thumbnail'));
      // $image->resize(370,150);
      $image->fit(345,205);
      $image->save($fileNameDir, 100);
      $newsInputs['thumbnail'] = $fileName;

      //for front image of news
      $fileNameDir  = 'uploads/news/front/' . $fileName;
      $frontImage   = Image::make(Input::file('form.news.thumbnail'));
      $frontImage->fit(142,141);
      $frontImage->save($fileNameDir, 100);

    }

    //update news
    if ( ! ( $this->news->updateData($newsInputs, Input::get('form.news.id')) )) {
      $data['msgError'] = 'Error Updating News !!';

      return redirect(PREFIX . '/multicms/pages/news')->withErrors($data);
    }

    //for PagesLG Manipulation

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $lang_id) {

      if ( ! empty( Input::get('form.' . $lang_id . '.id') )) {
        //update the existing row on tbl_page_lg table with reference to id.

        $inputs = Input::get('form.' . $lang_id);
        $id     = Input::get('form.' . $lang_id . '.id');

        $validator = $this->newsLg->validateUpdate(Input::get('form.' . $lang_id), $id);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

          return redirect(PREFIX . '/multicms/pages/news/manageNews?id=' . Input::get('form.' . $lang_id . '.news_id'))->withErrors($validator)->withInput();
        }

        
        
        //save changes
        if ($this->newsLg->updateData($inputs, $id)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/multicms/pages/news')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/news')->withErrors($data);
        }


      } else {

        //create new record in tbl_page_lg
        $inputs = Input::get('form.' . $lang_id);

        $validator = $this->newsLg->validate($inputs);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $lang_id . 'language_id'));

          return redirect(PREFIX . '/multicms/pages/news/manageNews?id=' . Input::get('form.' . $lang_id . 'news_id'))->withErrors($validator)->withInput();
        }

        // Store the pages details

       
        
        //save changes
        if ($this->newsLg->add($inputs)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/multicms/pages/news')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/news')->withErrors($data);
        }
      }

      $i++;
    }

  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int                      $id
   *
   * @return \Illuminate\Http\Response
   */
  public function newsLgCreate()
  {
    $langId = $this->language->getAllDataNoPagination()->pluck('id');

    //the validation should be done for title and images so,pages module contains
    //validations for fields other than of its own field as well
    // a separate validation for checking if title of default language is set or not.

    $defLang = $this->defaultLanguage->getDefaultLang();

    $validationArray =[ "slug" => Input::get('form.news.slug') ] + [ "categories" => Input::get('form.news.categories') ];
    $validator = $this->news->validate($validationArray);
    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/multicms/pages/news/create')->withErrors($validator)->withInput();
    }


    $newsInputs                = Input::get('form.news');
    $category_ids              = $newsInputs['categories'];
    $category                  = implode(",", $category_ids);
    $newsInputs['category_id'] = $category;
    unset( $newsInputs['categories'] );

     if (Input::hasFile('form.news.image')) {
      if (( ( Input::file('form.news.image')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.news.image')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.news.image')->getClientMimeType() ) != "image/png" )) {
        $data['msgError'] = 'The Image is not valid !,only jpeg,jpg,bmp & png image type are supported';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/news/manageNews?id='.Input::get('form.news.id'))->withErrors($data)->withInput();
      }

      if (( Input::file('form.news.image')->getClientSize() ) > 3200000) {
        $data['msgError'] = 'The news image size is very large !,The size must me less than 3MB.';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/news/manageNews?id=' . Input::get('form.' . $lang_id . '.news_id'))->withErrors($data)->withInput();
      }

      $directory = base_path() . '/uploads/news/image';
      $id        = Input::get('form.news.id');

     
      

      $originalName = InputHelpers::cleanURL(Input::file('form.news.image')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('form.news.image')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('form.news.image'));
      $image->fit(870, 390);
      $image->save($fileNameDir, 100);
      $newsInputs['image'] = $fileName;

    }

    if (Input::hasFile('form.news.thumbnail')) {
      if (( ( Input::file('form.news.thumbnail')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.news.thumbnail')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.news.thumbnail')->getClientMimeType() ) != "image/png" )) {
        $data['msgError'] = 'The Image is not valid !,only jpeg,jpg,bmp & png image type are supported';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/news/manageNews?id='.Input::get('form.news.id'))->withErrors($data)->withInput();
      }

      if (( Input::file('form.news.thumbnail')->getClientSize() ) > 3200000) {
        $data['msgError'] = 'The news image size is very large !,The size must me less than 3MB.';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/news/manageNews?id=' . Input::get('form.' . $lang_id . '.news_id'))->withErrors($data)->withInput();
      }

      $directory = base_path() . '/uploads/news/thumbnail';
      $id        = Input::get('form.news.id');

     

      $originalName = InputHelpers::cleanURL(Input::file('form.news.thumbnail')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('form.news.thumbnail')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('form.news.thumbnail'));
      // $image->resize(370,150);
      $image->fit(345,205);
      $image->save($fileNameDir, 100);
      $newsInputs['thumbnail'] = $fileName;

      //for front image of news
      $fileNameDir  = 'uploads/news/front/' . $fileName;
      $frontImage   = Image::make(Input::file('form.news.thumbnail'));
      $frontImage->fit(142,141);
      $frontImage->save($fileNameDir, 100);
      

    }

    //save page data for tbl_page only
    $forRecentNewsId = $this->news->add($newsInputs);

    if ($forRecentNewsId) {
      //now retrieve recently inserted id of row on tbl_page table.
      $news_id = $forRecentNewsId->id;
    } else {
      $data['msgError'] = 'Error Adding News !!';

      return redirect(PREFIX . '/multicms/pages/news')->withErrors($data);
    }

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $lang_id) {

      //create new record in tbl_page_lg
      $inputs = Input::get('form.' . $lang_id);

      $validator = $this->newsLg->validate($inputs);
      if ($validator->fails()) {
        Session::put('flag', Input::get('form.' . $lang_id . 'language_id'));

        return redirect(PREFIX . '/multicms/pages/news/create')->withErrors($validator)->withInput();
      }

      // Store the pages details

     

     
      //save changes
      $inputs['news_id'] = $news_id;
      if ($this->newsLg->add($inputs)) {

        $inputs = "";
        if ($i == $len - 1) {
          // last iteration of foreach loop
          $data['msgSuccess'] = 'Successfully saved !!';

          return redirect(PREFIX . '/multicms/pages/news')->withErrors($data);
        }

      } else {
        $inputs           = "";
        $data['msgError'] = 'Changes could not be saved !!';

        return redirect(PREFIX . '/multicms/pages/news')->withErrors($data);
      }
      $i++;
    }

  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int                      $id
   *
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy()
  {
    $id = Input::get('id');

    return Redirect::to(PREFIX . '/multicms/pages/news')->withErrors($this->news->delete($id));

  }

  /***********************newsCategory Methods******************************/

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function categoryIndex()
  {
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['pageData']     = $this->newsCategory->getAllDataNoPagination();
    $data['toggleUrl'] = URL::to(PREFIX.'/multicms/pages/news/categoryToggleStatus');
    return view('cms.modules.multicms.news_category_listall', $data);
  }

   /**
   *for toggling status.
   *
   * @return Response
   */
  public function categoryToggleStatus()
  {
    $id = Input::get('id');
    $status = $this->newsCategory->getDataById($id)->status;
    if($status == 'active')
    {
      $data['status'] = 'inactive';
      if($this->newsCategory->updateData($data,$id)){
        echo ucfirst($this->newsCategory->getDataById($id)->status);
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
      
    }
    elseif($status == "inactive")
    {
      $data['status'] = 'active';
      if($this->newsCategory->updateData($data,$id)){
        echo ucfirst($this->newsCategory->getDataById($id)->status);
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
   * @return \Illuminate\Http\Response
   */
  public function categoryCreate()
  { 
    
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $flags                = $this->language->getAllDataNoPagination();

    return view('cms.modules.multicms.news_category_addnew', compact('flags'), $data);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int                      $id
   *
   * @return \Illuminate\Http\Response
   */
  public function newsCategoryLgCreate()
  {
    $langId = $this->language->getAllDataNoPagination()->pluck('id');

    //the validation should be done for title and images so,pages module contains
    //validations for fields other than of its own field as well

    // a separate validation for checking if title of default language is set or not.

    $defLang = $this->defaultLanguage->getDefaultLang();

    $validationArray = Input::get('form.newsCategory');
    $validator       = $this->newsCategory->validate($validationArray);
    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/multicms/pages/news/categoryCreate')->withErrors($validator)->withInput();
    }

    $newsInputs = Input::get('form.newsCategory');

    //save page data for tbl_page only
    //dd($newsInputs);
    $forRecentNewsId = $this->newsCategory->add($newsInputs);

    if ($forRecentNewsId) {
      //now retrieve recently inserted id of row on tbl_page table.
      $newsCategory_id = $forRecentNewsId->id;
    } else {
      $data['msgError'] = 'Error Adding News Category !!';

      return redirect(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($data);
    }

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $Lid) {

      //create new record in tbl_page_lg
      $inputs = Input::get('form.' . $Lid);

      $validator = $this->newsCategoryLg->validate($inputs);
      if ($validator->fails()) {
        Session::put('flag', Input::get('form.' . $Lid . 'language_id'));

        return redirect(PREFIX . '/multicms/pages/news/manageNewsCategory?id=' . Input::get('form.' . $Lid . 'page_id'))->withErrors($validator)->withInput();
      }

      // Store the pages details

      //save changes
      $inputs['news_category_id'] = $newsCategory_id;
      if ($this->newsCategoryLg->add($inputs)) {

        $inputs = "";
        if ($i == $len - 1) {
          // last iteration of foreach loop
          $data['msgSuccess'] = 'Successfully saved !!';

          return redirect(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($data);
        }

      } else {
        $inputs           = "";
        $data['msgError'] = 'Changes could not be saved !!';

        return redirect(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($data);
      }

      $i++;
    }

  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  public function categoryStore()
  {
    if ($this->newsCategory->store(Input::all())) {
      $data['msgSuccess'] = 'Successfully! Added News Category.';

      return redirect(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($data);
    } else {
      $data['msgError'] = 'Could not create News Category.';

      return redirect(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($data);
    }


  }


  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function categoryShow($id)
  {
    //
  }


  public function manageNewsCategory()
  {
    $flags = $this->language->getAllDataNoPagination();
    $id    = Input::get('id');
    //$newsLg=$this->newsLg->getAllDataNoPagination();
    $newsCategory = $this->newsCategory->getDataById($id);

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view('cms.modules.multicms.news_category_manage', compact('newsCategory', 'flags'), $data);

  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function categoryEdit()
  {
    $id      = Input::get('id');
    $newsCat = $this->newsCategory->getDataById($id);

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view('cms.modules.multicms.news_category_edit', compact('newsCat'), $data);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int                      $id
   *
   * @return \Illuminate\Http\Response
   */
  public function categoryAllUpdate()
  {

    $langId = $this->language->getAllDataNoPagination()->pluck('id');

    //the validation should be done for title and images so,pages module contains
    //validations for fields other than of its own field as well

    // a separate validation for checking if title of default language is set or not.

    $defLang = $this->defaultLanguage->getDefaultLang();

    $validationArray = Input::get('form.newsCategory');

    $validator = $this->newsCategory->validate($validationArray);
    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/multicms/pages/news/manageNewsCategory?id=' . Input::get('form.' . $defLang . '.news_category_id'))->withErrors($validator)->withInput();
    }

    $newsInputs = Input::get('form.newsCategory');

    //save page data for tbl_page only
    //dd($newsInputs);

    if ( ! ( $this->newsCategory->updateData($newsInputs, Input::get('form.newsCategory.id')) )) {
      $data['msgError'] = 'Error Updating News Category !!';

      return redirect(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($data);
    }

    //for PagesLG Manipulation

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $Lid) {

      if ( ! empty( Input::get('form.' . $Lid . '.id') )) {
        //update the existing row on tbl_page_lg table with reference to id.

        $inputs = Input::get('form.' . $Lid);
        $id     = Input::get('form.' . $Lid . '.id');

        $validator = $this->newsCategoryLg->validateUpdate(Input::get('form.' . $Lid), $id);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $Lid . '.language_id'));

          return redirect(PREFIX . '/multicms/pages/news/manageNewsCategory?id=' . Input::get('form.' . $Lid . '.news_category_id'))->withErrors($validator)->withInput();
        }

        //save changes
        if ($this->newsCategoryLg->updateData($inputs, $id)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($data);
        }


      } else {

        //create new record in tbl_page_lg
        $inputs = Input::get('form.' . $Lid);

        $validator = $this->newsCategoryLg->validate($inputs);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $Lid . 'language_id'));

          return redirect(PREFIX . '/multicms/pages/news/manageNewsCategory?id=' . Input::get('form.' . $Lid . 'page_id'))->withErrors($validator)->withInput();
        }

        // Store the pages details
        //save changes
        if ($this->newsCategoryLg->add($inputs)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($data);
        }

      }

      $i++;
    }

  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function categoryDestroy($id)
  {
    $id = Input::get('id');

    return Redirect::to(PREFIX . '/multicms/pages/news/categoryIndex')->withErrors($this->newsCategory->delete($id));
  }

}
