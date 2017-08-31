<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\DefaultLanguage;
use App\Language;
class Page extends Model
{


  //for soft deleting
  use SoftDeletes;

  protected $table = "tbl_pages";

  protected $fillable = [
    'parent_id',
    'slug',
    'title',
    'page_template',
    'status',
    'page_template',
    'show_in_mainmenu',
    'menu_icon',
    'hits',
    'position',
    'created_at',
    'updated_at'
  ];

  //@Validation rules
  //The title check is for default language title,only validation rule is taken from here
  private $rules = [
    'slug'     => 'required|unique:tbl_pages,slug,NULL,id,deleted_at,NULL',
    'position' => 'numeric',
    'title'    => 'required|min:3'
    // 'status' => 'required',
    // 'show_in_mainmenu' => 'required',
    // 'menu_icon' => 'mimes:jpeg,bmp,png,jpg|max:1000'
  ];

    
  public function child()
  {
    return $this->hasMany('App\Page', 'parent_id', 'id')->where('status','active')->orderBy('position','asc');
  }


  public function parent()
  {
    return $this->belongsTo('App\Page', 'parent_id', 'id');
  }

  public function default_lang()
  { 
    $defautllang = New DefaultLanguage();
    $defLangId = $defautllang->getDefaultLang();
    $lang = New Language();
    $forTitle = $lang->getDataById($defLangId);
    return $forTitle->title;
  }

  public function listNormalDropdown()
  {
    $categories = Page::lists('slug', 'id')->toArray();

    return $categories;
  }


  public function updateData($data, $id)
  {
    $user = Page::find($id);
    $user->update($data);

    return true;
  }

  

  public function getAllData()
  {
    $datas = Page::paginate(10);

    return $datas;
  }





  


  public function validateUpdate($data, $id)
  {

    $rulesUpdate = [
      'slug'     => 'required|unique:tbl_pages,slug,' . $id. ',id,deleted_at,NULL',
      'position' => 'numeric',
      'title'    => 'required'
      // 'status' => 'required',
      // 'show_in_mainmenu' => 'required',
      // 'menu_icon' => 'mimes:jpeg,bmp,png,jpg|max:1000'
    ];

    $messages = [
        'title.required' => 'The default Language is '.$this->default_lang().' and title in that langauge is required',
        'slug.unique' => 'The slug already exists here or as backup,Please! select different slug. '              
    ];

    return Validator::make($data, $rulesUpdate,$messages);
  }


  public function getDataById($id)
  {
    $data = Page::find($id);

    if (empty( $data )) {
      return $data = '';

    } else {

      return $data;

    }

  }


  public function rootParentList()
  {
    $pageParentList = Page::where('parent_id', '=', 0)->orderBy('position')->lists('slug', 'id')->toArray();
    if (empty( $pageParentList )) {
      return [ ];
    } else {
      return $pageParentList;
    }
  }

  //Here Page title is from tbl_pages_lg as per language_id of default language. 
  public function rootParentListForTitle()
  { 
    $language_en = DB::table('tbl_languages')->where('slug','=','en')->pluck('id');
    $pageParentList = DB::table('tbl_pages')
            ->leftjoin('tbl_pages_lg', 'tbl_pages_lg.page_id', '=', 'tbl_pages.id')
            ->where('tbl_pages.status','=','active')
            ->where('tbl_pages_lg.status','=','active')
            ->where('tbl_pages_lg.language_id','=',$language_en)
            ->whereNull('tbl_pages_lg.deleted_at')
            ->select('tbl_pages.id', 'tbl_pages_lg.title')
            ->orderBy('position')
            ->get();

    $titleId = [];

    foreach ($pageParentList as $pageParent) {
      $titleId += [$pageParent->id => $pageParent->title];
    }
    
    
    if (empty( $pageParentList )) {
      return [ ];
    } else {
      return $titleId;
    }
  }



  
    public function add($data) {
        return Page::create($data);
    }
    
    
    
    public function deleteData($id) {
        $user = Page::find($id);
        $user->delete();
        
        return true;
    }
    
    
    public function getAllOrderBy() {
        
        return Page::orderBy('position')->get();
    }
    
    public function validate($data) {

       $messages = [
        'title.required' => 'The default Language is '.$this->default_lang().' and title in that langauge is required',
        'slug.unique' => 'The slug already exists here or as backup,Please! select different slug. '              
      ];

      return Validator::make($data, $this->rules,$messages);
    }
  
    public function forPageMenu()
  {
    $pageParentList = Page::where('parent_id', '=', 0)->where('status', '=', 'active')->where('show_in_mainmenu', '=', 'yes')->orderBy('position','asc')->get();
    if (empty( $pageParentList )) {
      return [ ];
    } else {
      return $pageParentList;

    }
  }  
    public function customParentList($id) {
        return Page::where('parent_id', '=', $id)->lists('slug', 'id')->toArray();
    }
    
    public function rootParentCollection() {
        return Page::where('parent_id', '=', 0)->get();
    }
    
    public function pagesLg() {
        return $this->hasMany('App\PagesLg', 'page_id', 'id');
    }


  public function whereClause($fparam, $sparam, $isObject = false)
  {
    if ($isObject === true) {
      $datas = Page::where($fparam, '=', $sparam)->where('status','=','active')->first();
    } else {
      $datas = Page::where($fparam, '=', $sparam)->get();
    }

    return $datas;
  }

  public function whereClauseAnd($fparam, $sparam, $thirdParam, $fourthParam, $isObject = false)
  {
    if ($isObject === true) {
      $datas = Page::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->first();
    } else {
      $datas = Page::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->orderBy('position','asc')->get();
    }

    return $datas;
  }

  public function whereClauseThreeChecks(
    $fparam,
    $sparam,
    $thirdParam,
    $fourthParam,
    $fiftheParam,
    $sixthParam,
    $isObject = false
  ) {
    if ($isObject === true) {
      $datas = Page::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->where($fiftheParam, '=',
        $sixthParam)->first();
    } else {
      $datas = Page::where($fparam, '=', $sparam)->get();
    }
    return $datas;
}


  public function whereClauseFourChecks(
    $fparam,
    $sparam,
    $thirdParam,
    $fourthParam,
    $fiftheParam,
    $sixthParam,
    $seventhParam,
    $eighthParam,
    $isObject = false
  ) {
    if ($isObject === true) {
      $datas = Page::where($fparam, '=', $sparam)
                    ->where($thirdParam, '=', $fourthParam)
                    ->where($fiftheParam, '=',$sixthParam)
                    ->where($seventhParam, '=', $eigthParam)->first();
                                
    } else {  

      $datas = Page::where($fparam, '=', $sparam)
                    ->where($thirdParam, '=', $fourthParam)
                    ->where($fiftheParam, '=',$sixthParam)
                    ->where($seventhParam, '=', $eigthParam)->get();

    }

    return $datas;
  }

  public function getParentItem($id){
    $pageData = Page::where('id',$id)->first();
    if($pageData->parent_id!=0){
      $pageData = $this->getParentItem($pageData->id);
    }
    else{
      return $pageData;
    }
  }

  public function getSubCategoryMenu($pageId){
    $pg = $this->getDataById($pageId);
    if(isset($pg->parent)){
      $parentData = $this->getSubCategoryMenu($pg->page_id);
    }
    else{
      $parentData = $pg->parent;
    }
    return $parentData;
  }

  public function getMenuByLanguageAndPage($parentId,$pageId,$language){
    return DB::table('tbl_pages_lg')
                              ->where('tbl_pages_lg.status','=','active')
                              ->where('tbl_pages_lg.page_id','=',$parentId)
                              ->where('tbl_pages_lg.language_id','=',$language)
                              ->select('tbl_pages_lg.*')
                              ->get(); 
  }

  public function getChildItems($status,$lang,$parentId){
    $pages = Page::where('parent_id',$parentId)->get();
    $pages->data = array();
    foreach($pages as $page){
      
      $page->data=DB::table('tbl_pages_lg')
                              ->where('status','=',$status)
                              ->where('language_id','=',$lang)
                              ->where('page_id','=',$page->id)
                              ->get(); 
                              
    }
    return $pages;
    
                              
  }

    public function getParentMenu($lang)
  {
    $pageParentList = Page::where('parent_id', '=', 0)->where('status', '=', 'active')->where('show_in_mainmenu', '=', 'yes')->orderBy('position','asc')->get();
    if (!empty( $pageParentList )) {
      foreach($pageParentList as $parent){
        $parent->child = $this->getChildItems($status='active',$lang,$parent->id);
      }
    $pageParent = $pageParentList;  
    }
    return $pageParent; 
  }
}
