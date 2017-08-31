<?php

namespace App\Services;

use App\Services\EloquentService;
use App\Language;

class LanguageService extends EloquentService
{

  public function __construct(Language $Language)
  {
    parent::__construct($Language);
    $this->model = $Language;
  }


  public function belongsToField()
  {
    return $this->model->belongsToField();
  }


  public function getDropDownList()
  {
    return $this->model->getDropDownList();

  }


  public function getAllDataNoPagination()
  {
    return $this->model->getAllDataNoPagination();
  }


  public function langSlugArray()
  {
    return $this->model->langSlugArray();
  }

}
