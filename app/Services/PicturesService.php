<?php

namespace App\Services;

use App\Services\EloquentService;
use App\Pictures;

class PicturesService extends EloquentService
{

  public function __construct(Pictures $pic)
  {
    parent::__construct($pic);
    $this->model = $pic;
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


  public function listByGallery($id)
  {
    return $this->model->listByGallery($id);
  }

}