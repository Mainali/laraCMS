<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentService 
{

  public function __construct($model)
  {
    $this->model = $model;
  }


  public function getAllData()
  {

    return $this->model->getAllData();
  }


  public function getAllOrderBy()
  {

    return $this->model->getAllOrderBy();
  }


  public function add($data)
  {
    return $this->model->add($data);
  }


  public function show($id)
  {
    return $this->model->show($id);
  }


  public function listNormalDropdown()
  {
    return $this->model->listNormalDropdown();
  }


  public function updateData($id, $data)
  {
    return $this->model->updateData($id, $data);
  }


  public function deleteData($id)
  {
    return $this->model->deleteData($id);
  }


  public function deleteDataPerm($id)
  {
    return $this->model->deleteData($id);
  }


  public function getTrashed()
  {
    return $this->model->getTrashed($id);
  }


  public function restore($id)
  {

    return $this->model->restore($id);
  }


  public function validate($data)
  {
    return $this->model->validate($data);
  }


  public function validateUpdate($data, $id)
  {
    return $this->model->validateUpdate($data, $id);
  }


  public function customParentList($id)
  {
    return $this->model->customParentList($id);
  }


  public function getDataById($id)
  {
    return $this->model->getDataById($id);
  }


  public function getAllDataNoPagination()
  {
    return $this->model->getAllDataNoPagination();
  }


  public function whereClause($fparam, $sparam, $isObject)
  {
    return $this->model->whereClause($fparam, $sparam, $isObject);
  }


  public function whereClauseAnd($fparam, $sparam, $thirdParam, $fourthParam, $isObject)
  {
    return $this->model->whereClauseAnd($fparam, $sparam, $thirdParam, $fourthParam, $isObject);
  }


  public function whereClauseThreeChecks(
    $fparam,
    $sparam,
    $thirdParam,
    $fourthParam,
    $fiftheParam,
    $sixthParam,
    $isObject
  ) {
    return $this->model->whereClauseThreeChecks($fparam, $sparam, $thirdParam, $fourthParam, $fiftheParam, $sixthParam,
      $isObject);
  }

  public function whereClauseFourChecks(
    $fparam,
    $sparam,
    $thirdParam,
    $fourthParam,
    $fiftheParam,
    $sixthParam,
    $seventhParam,
    $eigthParam,
    $isObject
  ) {
    return $this->model->whereClauseThreeChecks($fparam, $sparam, $thirdParam, $fourthParam, $fiftheParam, $sixthParam,$seventhParam,$eigthParam,
      $isObject);
  }

}