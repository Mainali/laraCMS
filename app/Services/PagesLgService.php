<?php
namespace App\Services;

use App\Services\EloquentService;
use App\PagesLg;
use Redirect;

class PagesLgService extends EloquentService
{
    
    public function __construct(PagesLg $PagesLg) {
        parent::__construct($PagesLg);
        $this->model = $PagesLg;
    }
    
    public function belongsToField() {
        return $this->model->belongsToField();
    }
    
    public function PageLgList() {
        return $this->model->PageLgList();
    }
}
