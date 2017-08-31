<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
//use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class NewsCategory extends Model
{

  //for soft deleting
  //use SoftDeletes;

  protected $table = "tbl_news_category";

  protected $fillable = [ 'slug', 'default_title','position','hits', 'status', 'created_at', 'updated_at' ];

  //@Validation rules
  private $rules = [
    'default_title' => 'required|unique:tbl_news_category,slug,NULL,id',
    'slug'          => 'required|unique:tbl_news_category,slug,NULL,id',
    'status'        => 'required',
  ];

   private $messages = [
        'default_title.required' => 'you need to provide Default Title! '              
  ];

  public function newsCategoryList()
  {
    $categories = NewsCategory::lists('default_title', 'id')->toArray();

    if (empty( $categories )) {
      return $categories = [ ];

    } else {

      return $categories;

    }


  }


  public function add($data)
  {
    return NewsCategory::create($data);
  }


  public function updateData($data, $id)
  {
    $user = NewsCategory::find($id);
    $user->update($data);

    return true;
  }


  public function deleteData($id)
  {
    $user = NewsCategory::find($id);
    $user->delete();

    return true;
  }


  public function getAllData()
  {
    $datas = NewsCategory::paginate(10);

    return $datas;
  }


  public function getAllDataNoPagination()
  {
    $datas = NewsCategory::orderBy('position')->get();

    return $datas;
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules,$this->messages);
  }


  public function validateUpdate($data, $id)
  {

    $rulesUpdate = [
      'default_title' => 'required|unique:tbl_news_category,default_title,' . $id. ',id',
      'slug'          => 'required|unique:tbl_news_category,slug,' . $id. ',id',
      'status'        => 'required',
    ];

    return Validator::make($data, $rulesUpdate,$this->messages);
  }


  public function getDataById($id)
  {
    $data = NewsCategory::find($id);

    if (empty( $data )) {
      return $data = '';

    } else {

      return $data;

    }

  }


  public function NewsCategoryLg()
  {
    return $this->hasMany('App\NewsCategoryLg', 'news_category_id', 'id');
  }

  public function getNewsCategoryByCategory($language){
    return DB::table('tbl_news_category')
                              ->join('tbl_news_category_lg','tbl_news_category.id','=','tbl_news_category_lg.news_category_id')
                              ->where('tbl_news_category.status','=','active')
                              ->where('tbl_news_category_lg.status','=','active')
                              ->whereNull('tbl_news_category.deleted_at')
                              ->whereNull('tbl_news_category_lg.deleted_at')
                              ->where('tbl_news_category_lg.language_id','=',$language)
                              ->orderBy('tbl_news_category.position','asc')
                              ->select('tbl_news_category_lg.*','tbl_news_category.slug')
                              ->get(); 
  }

}
