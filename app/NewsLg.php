<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class NewsLg extends Model
{
    
    //for soft deleting
    use SoftDeletes;
    
    protected $table = "tbl_news_lg";
    
    protected $fillable = ['news_id', 'language_id', 'title', 'description','intro','gallery_id', 'status', 'published_at','meta_title', 'meta_description', 'keyword', 'created_at', 'updated_at'];
    
    //@Validation rules
    private $rules = [
    
    //
    ];
    
    public function news() {
        return $this->belongsTo('App\News', 'news_id', 'id');
    }
    
    public function add($data) {
        return NewsLg::create($data);
    }
    
    public function updateData($data, $id) {
        $user = NewsLg::find($id);
        $user->update($data);
        
        return true;
    }
    
    public function deleteData($id) {
        $user = NewsLg::find($id);
        $user->delete();
        
        return true;
    }
    
    public function getAllData() {
        $datas = NewsLg::paginate(10);
        
        return $datas;
    }
    
    public function validate($data) {
        return Validator::make($data, $this->rules);
    }
    
    public function validateUpdate($data, $id) {
        
        $rulesUpdate = [
        
        //
        ];
        
        return Validator::make($data, $rulesUpdate);
    }
    
    public function getDataById($id) {
        $data = NewsLg::find($id);
        
        if (empty($data)) {
            return $data = '';
        } 
        else {
            
            return $data;
        }
    }
    public function getNewsForFrontWhereClause($fparam, $sparam, $limit = '', $isObject = false) {
        if ($isObject === true) {
            $datas = NewsLg::where($fparam, '=', $sparam)->first();
        } 
        else {
            $datas = NewsLg::where($fparam, '=', $sparam)->orderBy('tbl_news.pinned_position','<>','0')->orderBy('pinned_position','asc')->orderBy('updated_at', 'desc')->where('status','=','active')->get();
        }
        if (!empty($limit)) {
            $datas = $datas->take($limit);
        }
        return $datas;
    }
    public function getPinnedNewsForFrontwhereClauseAnd($language,$limit){
      return DB::table('tbl_news')
                              ->join('tbl_news_lg','tbl_news.id','=','tbl_news_lg.news_id')
                              ->where('tbl_news.status','=','active')
                              ->where('tbl_news_lg.status','=','active')
                              ->whereNull('tbl_news.deleted_at')
                              ->whereNull('tbl_news_lg.deleted_at')
                              ->where('tbl_news_lg.language_id','=',$language)
                              ->where('tbl_news.pinned','=','yes')
                              ->orderBy('tbl_news.pinned_position','asc')
                              ->select('tbl_news_lg.*','tbl_news.slug','tbl_news.thumbnail','tbl_news.image','tbl_news.published_at')
                              ->take($limit)
                              ->get();
    }
    public function getNewsForFrontwhereClauseAnd($language,$limit) {
          return DB::table('tbl_news')
                              ->join('tbl_news_lg','tbl_news.id','=','tbl_news_lg.news_id')
                              ->where('tbl_news.status','=','active')
                              ->where('tbl_news_lg.status','=','active')
                              ->whereNull('tbl_news.deleted_at')
                              ->whereNull('tbl_news_lg.deleted_at')
                              ->where('tbl_news_lg.language_id','=',$language)
                              ->where('tbl_news.pinned','=','no')
                              ->orderBy('tbl_news.published_at','desc')
                              ->select('tbl_news_lg.*','tbl_news.slug','tbl_news.thumbnail','tbl_news.image','tbl_news.published_at')
                              ->take($limit)
                              ->get();                   
        
    }
    public function getNewsImageByNewsId($newsId){
        return DB::table('tbl_news')
                   ->where('id',$newsId)
                   ->pluck('image'); 
    }

    public function whereClause($fparam, $sparam, $isObject = false) {
        if ($isObject === true) {
            $datas = NewsLg::where($fparam, '=', $sparam)->first();
        } 
        else {
            $datas = NewsLg::where($fparam, '=', $sparam)->where('status','=','active')->get();
        }
        return $datas;
    }
    
    public function whereClauseAnd($fparam, $sparam, $thirdParam, $fourthParam, $isObject = false) {
        if ($isObject === true) {
            $datas = NewsLg::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->first();
        } 
        else {
            $datas = NewsLg::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->where('status','=','active')->paginate(25);
        }
        return $datas;
    }
    
    public function getGetSlugByNewsId() {
        return DB::table('tbl_news')->where('id', $this->news_id)->pluck('slug');
    }
    
    public function whereClauseThreeChecks($fparam, $sparam, $thirdParam, $fourthParam, $fiftheParam, $sixthParam, $isObject = false) {
        if ($isObject === true) {
            $datas = NewsLg::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->where($fiftheParam, '=', $sixthParam)->first();
        } 
        else {
            $datas = NewsLg::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->where($fiftheParam, '=', $sixthParam)->where('status','=','active')->paginate(25);
        }
        
        return $datas;
    }
    public function getAllNews($language){
        return DB::table('tbl_news')
                              ->join('tbl_news_lg','tbl_news.id','=','tbl_news_lg.news_id')
                              ->where('tbl_news.status','=','active')
                              ->where('tbl_news_lg.status','=','active')
                              ->whereNull('tbl_news.deleted_at')
                              ->whereNull('tbl_news_lg.deleted_at')
                              ->where('tbl_news_lg.language_id','=',$language)
                              ->where('tbl_news.pinned','=','no')
                              ->orderBy('tbl_news.published_at','desc')
                              ->select('tbl_news_lg.*','tbl_news.slug','tbl_news.thumbnail','tbl_news.image','tbl_news.published_at')
                              ->paginate(2);
    }
    public function getPinnedNews($language){
      return DB::table('tbl_news')
                              ->join('tbl_news_lg','tbl_news.id','=','tbl_news_lg.news_id')
                              ->where('tbl_news.status','=','active')
                              ->where('tbl_news_lg.status','=','active')
                              ->whereNull('tbl_news.deleted_at')
                              ->whereNull('tbl_news_lg.deleted_at')
                              ->where('tbl_news_lg.language_id','=',$language)
                              ->where('tbl_news.pinned','=','yes')
                              ->orderBy('tbl_news.pinned_position','asc')
                              ->select('tbl_news_lg.*','tbl_news.slug','tbl_news.thumbnail','tbl_news.image','tbl_news.published_at','tbl_news.pinned','tbl_news.pinned_position')
                              ->get();
    }

    public function getNewsByCategory($category,$language){
      $categoryId = DB::table('tbl_news_category')->where('slug',$category)->pluck('id');  
      return DB::table('tbl_news_category')
                              ->join('tbl_news','tbl_news.category_id','=','tbl_news_category.id')
                              ->join('tbl_news_lg','tbl_news.id','=','tbl_news_lg.news_id')
                              ->where('tbl_news.category_id','=',$categoryId)
                              ->where('tbl_news.status','=','active')
                              ->where('tbl_news_lg.status','=','active')
                              ->whereNull('tbl_news.deleted_at')
                              ->whereNull('tbl_news_lg.deleted_at')
                              ->where('tbl_news_lg.language_id','=',$language)
                              ->where('tbl_news.pinned','=','no')
                              ->orderBy('tbl_news.published_at','desc')
                              ->select('tbl_news_lg.*','tbl_news.slug','tbl_news.thumbnail','tbl_news.image','tbl_news.published_at')
                              ->paginate(25);
    }

    public function getPinnedNewsByCategory($category,$language){
      $categoryId = DB::table('tbl_news_category')->where('slug',$category)->pluck('id');  
      return DB::table('tbl_news_category')
                              ->join('tbl_news','tbl_news.category_id','=','tbl_news_category.id')
                              ->join('tbl_news_lg','tbl_news.id','=','tbl_news_lg.news_id')
                              ->where('tbl_news.category_id','=',$categoryId)
                              ->where('tbl_news.status','=','active')
                              ->where('tbl_news_lg.status','=','active')
                              ->whereNull('tbl_news.deleted_at')
                              ->whereNull('tbl_news_lg.deleted_at')
                              ->where('tbl_news_lg.language_id','=',$language)
                              ->where('tbl_news.pinned','=','yes')
                              ->orderBy('tbl_news.pinned_position','asc')
                              ->select('tbl_news_lg.*','tbl_news.slug','tbl_news.thumbnail','tbl_news.image','tbl_news.published_at')
                              ->paginate(25);
    }
}
