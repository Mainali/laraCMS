<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagesLg extends Model
{

  //for soft deleting
  use SoftDeletes;

  protected $table = "tbl_pages_lg";

  protected $fillable = [
    'page_id',
    'language_id',
    'title',
    'description',
    'thumbnails',
    'banner',
    'status',
    'meta_title',
    'meta_description',
    'keyword'
  ];

  //@Validation rules
  private $rules = [
    // 'page_id' => 'required|unique:tbl_pages_lg,page_id',
    // 'language_id' => 'required|unique:tbl_pages_lg,language_id',
    'title'  => 'min:3',
    // 'thumbnails' => 'mimes:jpeg,bmp,png,jpg|max:1000',
    // 'banner' => 'mimes:jpeg,bmp,png,jpg|max:1000',
    'status' => 'required'
    // 'description' => 'required',
    // 'meta_title' => 'required',
    // 'meta_description' => 'required',
    // 'meta_description' => 'required'
  ];

  // private $rulesUpdate = array(
  //   'first_name'  => 'required|min:3',
  //   'last_name'  => 'required',
  //   'modules_permission' => 'required',
  //   'profile_pic' => 'mimes:jpeg,bmp,png,jpg|max:1000',
  //   'username' => 'required|min:3|unique:tbl_admin_login,username,\$this->get("id")'
  // );

  public function add($data)
  {
    PagesLg::create($data);

    return true;
  }


  public function edit($data, $id)
  {
    $user = PagesLg::find($id);
    $user->update($data);
  }


  public function updateData($data, $id)
  {
    $user = PagesLg::find($id);
    $user->update($data);

    return true;
  }


  public function deleteData($id)
  {
    $user = PagesLg::find($id);

    return $user->delete();
  }


  public function getAllData()
  {
    $datas = PagesLg::paginate(10);

    return $datas;
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules);
  }


  public function validateUpdate($data, $id)
  {

    $rulesUpdate = [
      // 'page_id' => 'unique:tbl_pages_lg,page_id,'.$id,
      // 'language_id' => 'unique:tbl_pages_lg,language_id,'.$id,
      'title'  => 'min:3',
      // 'thumbnails' => 'mimes:jpeg,bmp,png,jpg|max:1000',
      // 'banner' => 'mimes:jpeg,bmp,png,jpg|max:1000',
      'status' => 'required'
      // 'description' => 'required',
      // 'meta_title' => 'required',
      // 'meta_description' => 'required',
      // 'meta_description' => 'required'
    ];

    return Validator::make($data, $rulesUpdate);
  }


  public function getDataById($id)
  {
    $data = PagesLg::find($id);
    if (empty( $data )) {
      return $data = '';
    } else {
      return $data;
    }
  }


  public function languages()
  {
    return $this->belongsTo('App\Language', 'language_id', 'id');
  }


  public function pages()
  {
    return $this->belongsTo('App\Page', 'page_id', 'id');
  }


  public function getAllDataNoPagination()
  {
    $datas = PagesLg::all();

    return $datas;
  }


  public function whereClauseAnd($fparam, $sparam, $thirdParam, $fourthParam, $isObject = false)
  {
    if ($isObject === true) {
      $datas = PagesLg::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->first();
    } else {
      $datas = PagesLg::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->orderBy('position','asc')->get();
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
      $datas = PagesLg::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->where($fiftheParam, '=',
        $sixthParam)->first();
    } else {
      $datas = PagesLg::where($fparam, '=', $sparam)->where($thirdParam, '=', $fourthParam)->where($fiftheParam, '=',
        $sixthParam)->orderBy('position','asc')->get();
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
      $datas = PagesLg::where($fparam, '=', $sparam)
                    ->where($thirdParam, '=', $fourthParam)
                    ->where($fiftheParam, '=',$sixthParam)
                    ->where($seventhParam, '=', $eigthParam)->first();
                                
    } else {  

      $datas = PagesLg::where($fparam, '=', $sparam)
                    ->where($thirdParam, '=', $fourthParam)
                    ->where($fiftheParam, '=',$sixthParam)
                    ->where($seventhParam, '=', $eigthParam)->first();

    }

    return $datas;
  }

  public function getFirstAboutForFront(){
    return DB::table('tbl_pages')
                              ->join('tbl_pages_lg','tbl_pages.id','=','tbl_pages_lg.services_id')
                              ->where('tbl_services_lg.status','=',$status)
                              ->where('tbl_services_lg.language_id','=',$language)
                              ->where('tbl_services.slug','=',$slug)
                              ->select('tbl_services_lg.*','tbl_services.slug')
                              ->first(); 
  }

}
