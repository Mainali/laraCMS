<?php
namespace App\Services;

use App\Services\EloquentService;
use App\News;
use App\Services\NewsCategoryService;
use App\Services\NewsLgService;
use Input;
use Validator;

use Image;
use File;
use DB;
use Redirect;

class NewsService extends EloquentService
{
    
    public function __construct(News $News, NewsCategoryService $newsCategory, NewsLgService $newsLg) {
        parent::__construct($News);
        $this->model = $News;
        $this->newsCategory = $newsCategory;
        $this->newsLg = $newsLg;
    }

    public function getAllPinnedAs($firstParam) {
        
        return $this->model->getAllPinnedAs($firstParam);
    }
    
    //////logic related methods/////
    
    public function store($inputs) {
        
        $category_ids = $inputs['options'];
        $category = implode(",", $category_ids);
        $inputs['category_id'] = $category;
        unset($inputs['options']);
        
        $validator = $this->validate($inputs);
        if ($validator->fails()) {
            return Redirect::to(PREFIX . '/news/pages/newsCategory/create')->withErrors($validator)->withInput();
        }
        
        return $this->add($inputs);
    }
    
    public function categoryList($newsList,$filterDept) {
        
        //$newsList is an object returned by getAllDataNoPagination
        
        //declare empty collection
        $collection = collect([]);
        
        //declare empty array
        $newsCatArray = [];
        foreach ($newsList as $List) {
            $news_category = explode(",", $List->category_id);

            //if  filter is set
              if (!empty( $filterDept )) {
                //if department as filter not found on department list of doctor
                //don't push it into list collection
                if (!in_array($filterDept, $news_category)) {
                  continue;
                }
                
              }

            foreach ($news_category as $category) {
                $catDefaultTitle = $this->newsCategory->getDatabyId($category);
                
                //if any of newsCategory in comma separated list of particular news is deleted then skip pushing to array.
                
                if (empty($catDefaultTitle)) {
                    continue;
                }
                $catDefaultTitle->default_title;
                
                array_push($newsCatArray, $catDefaultTitle->default_title);
            }
            $newsCatImplode = implode(",", $newsCatArray);
            $newsCatImplode;
            $List->category_id = $newsCatImplode;
            $collection->push($List);
            
            //Reinitialize $newsCatArray
            $newsCatArray = [];
        }
        
        return $collection;
    }
    
    public function categoryListbBynews($newsObjectById) {
        
        $arrayCheck = explode(",", $newsObjectById->category_id);
        
        // foreach ($arrayCheck as $ac) {
        
        //   $newsCat = $this->newsCategory->getDatabyId($ac);
        //   $arrayCheck += [$newsCat->id => $newsCat->title];
        
        // }
        
        return $arrayCheck;
    }
    
    public function delete($id) {
        
        $delNews = $this->getDataById($id);
        
        
        
        $delnewsLg = $delNews->newsLg;
        
        // Start transaction!
        DB::beginTransaction();
        
        if (count($delnewsLg) > 0) {
            
            foreach ($delnewsLg as $news_lang) {

                if (!empty($news_lang->image)) {
                    $menu_icon = $news_lang->image;
                    
                    $menuIconDirectory = public_path() . '/uploads/news/image';
                    
                    
                        File::delete($menuIconDirectory . '/' . $menu_icon);
                    
                }
                
                //if delete of any news languages fails,rollback all database changes
                //and redirect to news list with error
                try {
                    $this->newsLg->deleteData($news_lang->id);
                }
                catch(Exception $e) {
                    DB::rollback();
                    $data['msgError'] = 'Error! Deleting languages associated with this news!';
                    
                    return $data;
                }
            }
        }
        
        try {
            $this->deleteData($id);
            
            //Commit transaction
            DB::commit();
            $data['msgSuccess'] = 'Successfully deleted News !!';
            
            return $data;
        }
        catch(Exception $e) {
            DB::rollBack();
            $data['msgError'] = 'Error! Deleting News!';
            
            return $data;
        }
    }
}
