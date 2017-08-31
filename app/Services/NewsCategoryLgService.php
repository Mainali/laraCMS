<?php

namespace App\Services;

use App\Services\EloquentService;
use App\NewsCategoryLg;
use Image;
use File;
use DB;

class NewsCategoryLgService extends EloquentService
{

  public function __construct(NewsCategoryLg $NewsCategoryLg)
  {
    parent::__construct($NewsCategoryLg);
    $this->model = $NewsCategoryLg;
  }


  //////logic related methods/////

}