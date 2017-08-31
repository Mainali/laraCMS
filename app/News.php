<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    
    //for soft deleting
    use SoftDeletes;
    
    protected $table = "tbl_news";
    
    protected $fillable = ['category_id', 'page_template','pinned_position','pinned','slug','image','thumbnail','hits', 'status', 'published_at', 'created_at', 'updated_at'];
    
    //@Validation rules
    //title is title validation of default language and not for tbl-news table itself
    private $rules = ['categories' => 'required', 'slug' => 'required|unique:tbl_news,slug,NULL,id,deleted_at,NULL'];

    private $messages = [
        'categories.required' => 'you need to select at least one Category! ',
        'slug.unique' => 'The slug already exists here or as backup,Please! select different slug. '              
    ];
    
    public function newsList() {
        $categories = News::lists('title', 'id')->toArray();
        
        return $categories;
    }
    
    public function getAllDataNoPagination() {
        $datas = News::all();
        
        return $datas;
    }
    
    public function getAllOrderBy() {
        
        return News::orderBy('published_at','desc')->get();
    }

    public function getAllPinnedAs($firstParam) {
        //dd($firstParam);
        return News::where('pinned','=',$firstParam)->orderBy('published_at','desc')->get();
    }

    public function add($data) {
        return News::create($data);
    }
    
    public function updateData($data, $id) {
        $user = News::find($id);
        $user->update($data);
        
        return true;
    }
    
    public function deleteData($id) {
        $user = News::find($id);
        $user->delete();
        
        return true;
    }
    
    public function getAllData() {
        $datas = News::paginate(10);
        
        return $datas;
    }
    
    public function validate($data) {
        return Validator::make($data, $this->rules,$this->messages);
    }
    
    public function validateUpdate($data, $id) {
        
        //title is title validation of default language and not for tbl-news table itself
        $rulesUpdate = ['categories' => 'required', 'slug' => 'required|unique:tbl_news,slug,' . $id. ',id,deleted_at,NULL'];
        
        return Validator::make($data, $rulesUpdate,$this->messages);
    }
    
    public function getDataById($id) {
        $data = News::find($id);
        
        if (empty($data)) {
            return $data = '';
        } 
        else {
            
            return $data;
        }
    }
    
    public function newsLg() {
        return $this->hasMany('App\NewsLg', 'news_id', 'id');
    }
    
    public function whereClauseAnd($fparam, $sparam, $thirdParam, $fourthParam, $isObject = false) {
        if ($isObject === true) {
            $datas = News::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->first();
        } 
        else {
            $datas = News::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->get();
        }
        return $datas;
    }
}
