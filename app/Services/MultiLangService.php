<?php

namespace App\Services;

use App\Services\EloquentService;
use App\MultiLang;

class MultiLangService extends EloquentService
{

  public function __construct(MultiLang $multiLang)
  {
    parent::__construct($multiLang);
    $this->model = $multiLang;
  }


  public function belongsToField()
  {
    return $this->model->belongsToField();
  }


  public function getDropDownList()
  {
    return $this->model->getDropDownList();

  }


  public function multiLangList()
  {
    return $this->model->multiLangList();
  }


}
