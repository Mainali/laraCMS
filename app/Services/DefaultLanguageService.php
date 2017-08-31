<?php

namespace App\Services;

use App\Services\EloquentService;
use App\DefaultLanguage;
use App\Services\DefaultLanguageService;

class DefaultLanguageService extends EloquentService
{

  public function __construct(DefaultLanguage $DefaultLanguage)
  {
    parent::__construct($DefaultLanguage);
    $this->model = $DefaultLanguage;
  }


  public function getDefaultLang()
  {
    return $this->model->getDefaultLang();
  }


}
