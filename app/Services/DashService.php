<?php
namespace App\Services;

use App\Services\EloquentService;
use App\ActivationDatas;
use URL;

class DashService extends EloquentService
{
    public function __construct() {
        $this->activationModal = new ActivationDatas;
    }


    public function getTotalRequestCount()
    {
    	return $this->activationModal->getAllData()->count();
    }


    public function getPendingRequestCount()
    {
    	return $this->activationModal->getAllData()->where('status','Pending')->count();
    }


    public function getActiveRequestCount()
    {
    	return $this->activationModal->getAllData()->where('status','Activated')->count();
    }


    public function linegraphData()
    {
        $data = $this->activationModal->getCountRequestByDate()->toJson();
        return $data;
    }



}