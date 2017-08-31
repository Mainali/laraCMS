<?php
namespace App\Services;

use App\Services\EloquentService;
use App\Page;
use Redirect;

class PageService extends EloquentService
{
    
    public function __construct(Page $Page) {
        parent::__construct($Page);
        $this->model = $Page;
    }
    
    public function belongsToField() {
        return $this->model->belongsToField();
    }
    
    public function forPageMenu() {
        return $this->model->forPageMenu();
    }
    
    public function pageList() {
        return $this->model->pageList();
    }
    
    public function rootParentList() {
        return $this->model->rootParentList();
    }

    public function rootParentListForTitle() {
        return $this->model->rootParentListForTitle();
    }
    
    public function rootParentCollection() {
        return $this->model->rootParentCollection();
    }
    
    //////logic related methods/////
    
    
    
    /**
     * Generate Array that is used to render dropdown item recursively in parent-child structure for form
     * Author:Sumit KC
     * @return Array
     */
    //Input Array $rootParent = [id => title],
    //where 'title' corresponds to 'id'  of same table,say 'tbl_page', it will add dashes recursively 
    //on title for every child of parents with reference to id of that table.
    public function recur($rootParent, $dash, $dropdown) {
        foreach ($rootParent as $key => $value) {
            $dropdown+= [$key => $dash . $value];
            $pages = $this->getDataById($key);
            
            if (count($pages->child) > 0) {
                $dash.= DASH;
                $roots = $this->customParentList($pages->id);
                foreach ($roots as $key => $value) {
                    
                    $dropdown+= $this->recur([$key => $value], $dash, $dropdown);
                }
            }
            $dash = "";
        }
        
        return $dropdown;
    }
    
    /**
     * Takes array which is recursive with parents and child below it,
     * E.g:[
     *      1 => "Food"
     *      4 => "- Beverage"
     *     ]
     *
     * Gives Collection with remaining fields as recursive list for list.blade.php view
     *
     * @return Response
     */
    public function recurList($recurTitleList, $collection) {
        
        foreach ($recurTitleList as $key => $value) {
            $page = $this->getDataById($key);
            $page["slug"] = $value;
            $collection->push($page);
        }
        
        return $collection;
    }
}
