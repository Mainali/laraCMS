<?php
namespace App\Services;

use App\Services\EloquentService;
use App\Banner;

class BannerService extends EloquentService
{

  public function __construct(Banner $Banner)
  {
    parent::__construct($Banner);
    $this->model = $Banner;
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