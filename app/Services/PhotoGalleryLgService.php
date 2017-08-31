<?php
namespace App\Services;

use App\Services\EloquentService;
use App\PhotoGalleryLg;

class PhotoGalleryLgService extends EloquentService
{

  public function __construct(PhotoGallerylg $PhotogalLg)
  {
    parent::__construct($PhotogalLg);
    $this->model = $PhotogalLg;
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