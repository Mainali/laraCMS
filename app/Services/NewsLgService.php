<?php
namespace App\Services;

use App\Services\EloquentService;
use App\NewsLg;

class NewsLgService extends EloquentService
{
    
    public function __construct(NewsLg $NewsLg) {
        parent::__construct($NewsLg);
        $this->model = $NewsLg;
    }
    
    public function getNewsForFrontWhereClause($fparam, $sparam, $limit, $isObject) {
        return $this->model->getNewsForFrontWhereClause($fparam, $sparam, $limit, $isObject);
    }
    
    public function getNewsForFrontwhereClauseAnd($language,$limit) {
        return $this->model->getNewsForFrontwhereClauseAnd($language,$limit);
    }
    public function getAllNews($language){
        return $this->model->getAllNews($language);
    }
    public function getNewsImageByNewsId($newsId){
        return $this->model->getNewsImageByNewsId($newsId);
    }
    public function getPinnedNews($language){
        return $this->model->getPinnedNews($language);
    }
    public function getPinnedNewsForFrontwhereClauseAnd($language,$limit){
        return $this->model->getPinnedNewsForFrontwhereClauseAnd($language,$limit);
    }

    public function getNewsByCategory($categorySlug,$language){
        return $this->model->getNewsByCategory($categorySlug,$language);
    }

    public function getPinnedNewsByCategory($categorySlug,$language){
        return $this->model->getPinnedNewsByCategory($categorySlug,$language);
    }
}
