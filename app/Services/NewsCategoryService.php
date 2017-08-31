<?php

namespace App\Services;

use App\Services\EloquentService;
use App\Services\NewsCategoryLgService;
use App\NewsCategory;
use Image;
use File;
use DB;

class NewsCategoryService extends EloquentService
{

  public function __construct(NewsCategory $NewsCategory, NewsCategoryLgService $newsCategoryLg)
  {
    parent::__construct($NewsCategory);
    $this->model          = $NewsCategory;
    $this->newsCategoryLg = $newsCategoryLg;
  }


  public function newsCategoryList()
  {
    return $this->model->newsCategoryList();
  }


  //////logic related methods/////

  public function store($inputs)
  {

    $validator = $this->validate($inputs);
    if ($validator->fails()) {
      return redirect(PREFIX . '/news/pages/newsCategory/create')->withErrors($validator)->withInput();
    }

    // Store the newsCategory details
    $this->add($inputs);

    return true;
  }


  public function update($inputs)
  {

    $id        = $inputs['id'];
    $validator = $this->validateUpdate($inputs, $id);
    if ($validator->fails()) {
      return redirect(PREFIX . '/news/pages/newsCategory/edit')->withErrors($validator)->withInput();
    }

    // Update the newsCategory details
    $this->updateData($inputs, $id);

    return true;
  }


  public function delete($id)
  {

    $delNewsCategory = $this->getDataById($id);

    $delnewsCategoryLg = $delNewsCategory->newsCategoryLg;
    // Start transaction!
    DB::beginTransaction();

    if (count($delnewsCategoryLg) > 0) {

      foreach ($delnewsCategoryLg as $NL) {
        //if delete of any news languages fails,rollback all database changes
        //and redirect to news list with error
        try {
          $this->newsCategoryLg->deleteData($NL->id);

        } catch (Exception $e) {
          DB::rollback();
          $data['msgError'] = 'Error! Deleting languages associated with this News category!';

          return $data;
        }


      }
    }

    try {
      $this->deleteData($id);
      //Commit transaction
      DB::commit();
      $data['msgSuccess'] = 'Successfully deleted News Category !!';

      return $data;
    } catch (Exception $e) {
      DB::rollBack();
      $data['msgError'] = 'Error! Deleting News Category!';

      return $data;
    }


  }

  public function getNewsCategoryByCategory($language){
    return $this->model->getNewsCategoryByCategory($language);
  }

}
