<?php

namespace App\Http\Controllers\cms\modules\home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\DashService;
use Auth;

class homeController extends Controller
{
    public $thisPageId = 'default';
    public $thisModuleId = "home";

    
    public function __construct()
	  {
	    $this->dashService = new DashService;
	  }

    public function index()
    {
    	$id = Auth::user()->id;
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;
        $data['pendingCount'] = $this->dashService->getPendingRequestCount();
        $data['totalCount'] = $this->dashService->getTotalRequestCount();
        $data['activeCount'] = $this->dashService->getActiveRequestCount();
        $data['linegraphData'] = $this->dashService->linegraphData();
        return view(MODULEFOLDER."/modules.home.dashboard",$data);
    }
}
