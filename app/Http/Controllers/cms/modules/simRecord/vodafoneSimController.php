<?php
namespace App\Http\Controllers\cms\modules\simRecord;
/**
 * Created by PhpStorm.
 * User: ekbana
 * Date: 5/19/16
 * Time: 3:48 PM
 */

use App\Http\Controllers\Controller;
use App\Services\SimRecordService;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Session;
use Redirect;

class vodafoneSimController extends Controller
{
    public $thisPageId = 'Vodafone Sim Data';

    public $thisModuleId = "simRecord";

    public function __construct() {
        $this->moduleService = new SimRecordService;
    }


    public function index() {

        $data = $this->moduleService->vodafoneSimlist();
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;



        $urlData = $this->moduleService->getVodafoneUrlForView();


        return view(MODULEFOLDER . ".modules.simRecord.vodafone-list", $data,$urlData);
    }

    public function postData(Request $request)
    {
        try {
            $this->moduleService->saveVodafoneExcel($request);
            $data['msgSuccess']="Vodafone Records Added successfully";
            return Redirect::back()->with('success',$data['msgSuccess']);
        }
        catch(Exception $e) {
            abort(404);
        }
    }

    public function details(Request $request)
    {
       return $this->moduleService->detailsVodafone($request);
    }

    public function check(Request $request)
    {
        return $this->moduleService->checkHighland($request);
    }

    public function downloadSample()
    {
        return $this->moduleService->vodafoneSample();
    }

}