<?php

namespace App\Services;

use App\Services\EloquentService;
use App\PicturesLg;

class PicturesLgService extends EloquentService
{

  public function __construct(PicturesLg $PicturesLg)
  {
    parent::__construct($PicturesLg);
    $this->model = $PicturesLg;
  }


  public function belongsToField()
  {
    return $this->model->belongsToField();
  }


  public function PageLgList()
  {
    return $this->model->PageLgList();

  }


}
