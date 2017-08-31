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

class highlandSimController extends Controller
{
    public $thisPageId = 'Highland Sim Data';

    public $thisModuleId = "simRecord";

    public function __construct() {
        $this->moduleService = new SimRecordService;
    }


    public function index() {

        $data = $this->moduleService->highlandSimlist();
        $data['thisPageId'] = $this->thisPageId;
        $data['thisModuleId'] = $this->thisModuleId;


        $urlData = $this->moduleService->getHighlandUrlForView();


        return view(MODULEFOLDER . ".modules.simRecord.highland-list", $data,$urlData);
    }

    public function postData(Request $request)
    {
        try {
            $this->moduleService->saveHighlandExcel($request);
            $data['msgSuccess']="Highland Records Added successfully";
            return Redirect::back()->with('success',$data['msgSuccess']);
        }
        catch(Exception $e) {
            abort(404);
        }
    }

    public function details(Request $request)
    {
        return $this->moduleService->detailsHighland($request);
    }

    public function check(Request $request)
    {
        return $this->moduleService->checkVodafone($request);
    }

    public function downloadSample()
    {
        return $this->moduleService->highlandSample();
    }

}