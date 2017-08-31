<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsCategoryLg extends Model
{

  //for soft deleting
  use SoftDeletes;

  protected $table = "tbl_news_category_lg";

  protected $fillable = [
    'news_category_id',
    'language_id',
    'title',
    'status',
    'meta_title',
    'meta_description',
    'keyword',
    'created_at',
    'updated_at'
  ];

  //@Validation rules
  private $rules = [
    //
  ];


  public function newsCategory()
  {
    return $this->belongsTo('App\NewsCategory', 'news_category_id', 'id');
  }


  public function add($data)
  {
    return NewsCategoryLg::create($data);
  }


  public function updateData($data, $id)
  {
    $user = NewsCategoryLg::find($id);
    $user->update($data);

    return true;
  }


  public function deleteData($id)
  {
    $user = NewsCategoryLg::find($id);
    $user->delete();

    return true;
  }


  public function getAllData()
  {
    $datas = NewsCategoryLg::paginate(10);

    return $datas;
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules);
  }


  public function validateUpdate($data, $id)
  {

    $rulesUpdate = [
      //
    ];

    return Validator::make($data, $rulesUpdate);
  }


  public function getDataById($id)
  {
    $data = NewsCategoryLg::find($id);

    if (empty( $data )) {
      return $data = '';

    } else {

      return $data;

    }

  }

}
