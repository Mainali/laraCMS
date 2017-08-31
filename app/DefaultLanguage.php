<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultLanguage extends Model
{

  protected $table = "tbl_default_language";

  protected $fillable = [ 'def_lang_id', 'created_by' ];

  //@Validation rules
  private $rules = [
    'def_lang_id' => 'required|numeric',
    'created_by'  => 'required',

  ];

private $messages = [
        'def_lang_id.required' => 'you need to provide Default Language! ',
        'def_lang_id.numeric' => 'Default Language input must be numeric! ',
        'created_by.required' => 'User that is making Default Language changes should be provided! '                
  ];

  public function getDefaultLang()
  {
    $defaultLang = DefaultLanguage::first();

    return $defaultLang->def_lang_id;

  }


  public function updateData($data, $id)
  {
    $defaultLang = DefaultLanguage::first();
    $defaultLang->update($data);

    return true;
  }


  public function validate($data)
  {
    return Validator::make($data, $this->rules,$this->messages);
  }

}
