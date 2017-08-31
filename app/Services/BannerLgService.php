<?php
namespace App\Services;

use App\Services\EloquentService;
use App\BannerLg;

class BannerLgService extends EloquentService
{

  public function __construct(Bannerlg $BannerLg)
  {
    parent::__construct($BannerLg);
    $this->model = $BannerLg;
  }


  public function belongsToField()
  {
    return $this->model->belongsToField();
  }

  public function getAllBanners($language){
  	return $this->model->getAllBanners($language);
  }


}