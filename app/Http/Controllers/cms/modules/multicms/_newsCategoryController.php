<?php

namespace App\Http\Controllers\cms\modules\news;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\NewsCategory;
use App\Services\NewsService;
use App\Services\NewsCategoryService;
use App\Services\NewsCategoryLgService;
use App\Services\NewsLgService;
use App\Services\LanguageService;
use App\Services\DefaultLanguageService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Input;
use Validator;
use Config;
use File;
use Image;
use DB;

class newsCategoryController extends Controller
{

  public function __construct(
    NewsService $news,
    NewsLgService $newsLg,
    LanguageService $language,
    NewsCategoryService $newsCategory,
    DefaultLanguageService $defaultLanguage,
    NewsCategoryLgService $newsCategoryLg
  ) {

    $this->news            = $news;
    $this->newsLg          = $newsLg;
    $this->language        = $language;
    $this->newsCategory    = $newsCategory;
    $this->defaultLanguage = $defaultLanguage;
    $this->newsCategoryLg  = $newsCategoryLg;

  }


  public $thisPageId = 'News Category';

  public $thisModuleId = "news";


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['pageData']     = $this->newsCategory->getAllDataNoPagination();

    return view('cms.modules.news_category.listall', $data);
  }

   /**
   *for toggling status.
   *
   * @return Response
   */
  public function toggleStatus()
  {
    $id = Input::get('id');
    $status = $this->newsCategory->getDataById($id)->status;
    if($status == 'active')
    {
      $data['status'] = 'inactive';
      if($this->newsCategory->updateData($data,$id)){
        echo '<p style="color:red;">&nbsp;'.ucfirst($this->newsCategory->getDataById($id)->status).'</p>';
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
      
    }
    elseif($status == "inactive")
    {
      $data['status'] = 'active';
      if($this->newsCategory->updateData($data,$id)){
        echo '<p style="color:green;">&nbsp;'.ucfirst($this->newsCategory->getDataById($id)->status).'</p>';
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
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $flags                = $this->language->getAllDataNoPagination();

    return view('cms.modules.news_category.addnew', compact('flags'), $data);
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

      return redirect(PREFIX . '/news/pages/newsCategory/create')->withErrors($validator)->withInput();
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

      return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
    }

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $Lid) {

      //create new record in tbl_page_lg
      $inputs = Input::get('form.' . $Lid);

      $validator = $this->newsCategoryLg->validate($inputs);
      if ($validator->fails()) {
        Session::put('flag', Input::get('form.' . $Lid . 'language_id'));

        return redirect(PREFIX . '/news/pages/newsCategory/manageNewsCategory?id=' . Input::get('form.' . $Lid . 'page_id'))->withErrors($validator)->withInput();
      }

      // Store the pages details

      //save changes
      $inputs['news_category_id'] = $newsCategory_id;
      if ($this->newsCategoryLg->add($inputs)) {

        $inputs = "";
        if ($i == $len - 1) {
          // last iteration of foreach loop
          $data['msgSuccess'] = 'Successfully saved !!';

          return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
        }

      } else {
        $inputs           = "";
        $data['msgError'] = 'Changes could not be saved !!';

        return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
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
  public function store()
  {
    if ($this->newsCategory->store(Input::all())) {
      $data['msgSuccess'] = 'Successfully! Added News Category.';

      return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
    } else {
      $data['msgError'] = 'Could not create News Category.';

      return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
    }


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


  public function manageNewsCategory()
  {
    $flags = $this->language->getAllDataNoPagination();
    $id    = Input::get('id');
    //$newsLg=$this->newsLg->getAllDataNoPagination();
    $newsCategory = $this->newsCategory->getDataById($id);

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view('cms.modules.news_category.manage', compact('newsCategory', 'flags'), $data);

    //from pages edit for test

    // $data['thisPageId'] = $this->thisPageId;
    // $data['thisModuleId'] = $this->thisModuleId;

    // $rootParent=$this->page->rootParentList();
    // $dash="";
    // $dropdown=[];
    // $pageList=[""=>'Select Page']+$this->page->recur($rootParent,$dash,$dropdown);

    //  //for PagesLg Manage
    //  $flags=$this->language->getAllDataNoPagination();
    //  $id=Input::get('id');
    //  $pageLg=$this->pageLg->getAllDataNoPagination();
    //  $page=$this->page->getDataById($id);
    //  $data['thisPageId'] = $this->thisPageId;
    //  $data['thisModuleId'] = $this->thisModuleId;

    //  return view('cms.modules.pages.pagesLg.manage',compact('page','flags','pageLg','pageList'),$data);

  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function edit()
  {
    $id      = Input::get('id');
    $newsCat = $this->newsCategory->getDataById($id);

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view('cms.modules.news_category.edit', compact('newsCat'), $data);
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

    $langId = $this->language->getAllDataNoPagination()->pluck('id');

    //the validation should be done for title and images so,pages module contains
    //validations for fields other than of its own field as well

    // a separate validation for checking if title of default language is set or not.

    $defLang = $this->defaultLanguage->getDefaultLang();

    $validationArray = Input::get('form.newsCategory');

    $validator = $this->newsCategory->validate($validationArray);
    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/news/pages/newsCategory/manageNewsCategory?id=' . Input::get('form.' . $defLang . '.news_category_id'))->withErrors($validator)->withInput();
    }

    $newsInputs = Input::get('form.newsCategory');

    //save page data for tbl_page only
    //dd($newsInputs);

    if ( ! ( $this->newsCategory->updateData($newsInputs, Input::get('form.newsCategory.id')) )) {
      $data['msgError'] = 'Error Updating News Category !!';

      return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
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

          return redirect(PREFIX . '/news/pages/manageNewsCategory?id=' . Input::get('form.' . $Lid . '.news_category_id'))->withErrors($validator)->withInput();
        }

        //save changes
        if ($this->newsCategoryLg->updateData($inputs, $id)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
        }


      } else {

        //create new record in tbl_page_lg
        $inputs = Input::get('form.' . $Lid);

        $validator = $this->newsCategoryLg->validate($inputs);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $Lid . 'language_id'));

          return redirect(PREFIX . '/news/pages/manageNewsCategory?id=' . Input::get('form.' . $Lid . 'page_id'))->withErrors($validator)->withInput();
        }

        // Store the pages details
        //save changes
        if ($this->newsCategoryLg->add($inputs)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
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
  public function update()
  {
    if ($this->newsCategory->update(Input::all())) {
      $data['msgSuccess'] = 'Successfully! Added News Category.';

      return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
    } else {
      $data['msgError'] = 'Could not update News Category.';

      return redirect(PREFIX . '/news/pages/newsCategory')->withErrors($data);
    }

  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $id = Input::get('id');

    return Redirect::to(PREFIX . '/news/pages/newsCategory')->withErrors($this->newsCategory->delete($id));
  }
}
