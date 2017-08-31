<?php
namespace App\Services;

use App\Services\EloquentService;
use App\PhotoGallery;

class PhotoGalleryService extends EloquentService
{

  public function __construct(PhotoGallery $Photogal)
  {
    parent::__construct($Photogal);
    $this->model = $Photogal;
  }


  public function belongsToField()
  {
    return $this->model->belongsToField();
  }


  public function PageLgList()
  {
    return $this->model->PageLgList();

  }


  public function rootParentList()
  {
    return $this->model->rootParentList();

  }


  public function rootParentCollection()
  {
    return $this->model->rootParentCollection();

  }


}