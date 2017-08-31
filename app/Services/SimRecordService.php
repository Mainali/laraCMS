<?php
/**
 * Created by PhpStorm.
 * User: pukar_ekbana
 * Date: 5/19/16
 * Time: 4:07 PM
 */

namespace App\Services;


use App\HighlandData;
use App\VodafoneData;
//use Illuminate\Support\Facades\Redirect;
use Mockery\CountValidator\Exception;
use URL;
use Illuminate\Http\Request;
use Excel;
use Validator;
use Redirect;
use Session;
use Response;

class SimRecordService
{
    public function __construct()
    {
        $this->HighlandModal = new HighlandData();
        $this->VodafoneModal = new VodafoneData();
    }
    public function saveHighlandSim($data)
    {


    }

    public function highlandSimlist($filterCat=null)
    {

        if(null!==$filterCat && $filterCat !=="live")
        {
            if($filterCat == "all")
            {
                $data['highlandSimDatas'] = $this->HighlandModal->getAllDataWithTrashed();
            }
            elseif ($filterCat == "trashed") {
                $data['highlandSimDatas'] = $this->HighlandModal->getOnlyTrashedData();
            }
            else
            {
                $data['highlandSimDatas'] = $this->HighlandModal->filterByStatus($filterCat);
            }

            $data['filterCat'] = $filterCat;
        }
        else
        {
            $data['highlandSimDatas'] = $this->HighlandModal->getAllData();
            $data['filterCat'] = 'live';
        }


        return $data;
    }

    public function vodafoneSimlist($filterCat=null)
    {

        if(null!==$filterCat && $filterCat !=="live")
        {
            if($filterCat == "all")
            {
                $data['vodafoneSimDatas'] = $this->VodafoneModal->getAllDataWithTrashed();
            }
            elseif ($filterCat == "trashed") {
                $data['vodafoneSimDatas'] = $this->VodafoneModal->getOnlyTrashedData();
            }
            else
            {
                $data['vodafoneSimDatas'] = $this->VodafoneModal->filterByStatus($filterCat);
            }

            $data['filterCat'] = $filterCat;
        }
        else
        {
            $data['vodafoneSimDatas'] = $this->VodafoneModal->getAllData();
            $data['filterCat'] = 'live';
        }


        return $data;
    }



    public function getHighlandUrlForView()
    {
        $data['editUrl']= URL::to(PREFIX.'/simRecord/pages/highlandSim/editload');
        $data['addUrl'] = URL::to(PREFIX.'/simRecord/pages/highlandSim/addnew');
        $data['detailsUrl'] = URL::to(PREFIX.'/simRecord/pages/highlandSim/details');
        $data['deleteUrl'] = URL::to(PREFIX.'/simRecord/pages/highlandSim/delete');
        $data['checkUrl'] = URL::to(PREFIX.'/simRecord/pages/highlandSim/check');
        return $data;
    }

    public function getVodafoneUrlForView()
    {
        $data['editUrl']= URL::to(PREFIX.'/simRecord/pages/vodafoneSim/editload');
        $data['addUrl'] = URL::to(PREFIX.'/simRecord/pages/vodafoneSim/addnew');
        $data['detailsUrl'] = URL::to(PREFIX.'/simRecord/pages/vodafoneSim/details');
        $data['deleteUrl'] = URL::to(PREFIX.'/simRecord/pages/vodafoneSim/delete');
        $data['checkUrl'] = URL::to(PREFIX.'/simRecord/pages/vodafoneSim/check');
        return $data;
    }

    public function saveHighlandExcel(Request $request)
    {
        $rules = array('highland_xcel' => 'required|mimes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',);
       // $validator = Validator::make($request->all(), $rules);

//        if($validator->fails())
//        {
//            dump($request->file('highland_xcel')->getClientMimeType());
//            dd($validator);
//            return redirect(PREFIX.'/simRecord/pages/highlandSim')->with('msgError','valid excel file is required');
//        }

        //dd($request->file('highland_xcel')->getClientMimeType());
        try{

            Excel::load($request->file('highland_xcel'),function($reader){
                $results = $reader->get();
                foreach ($reader->toArray() as $row) {
                    // dump($row);
                    if(is_null($row['sno']))$row['sno'] ='';
                    if(is_null($row['customer_name']))$row['customer_name'] ='';
                    if(is_null($row['sim_serial_number']))$row['sim_serial_number'] ='';
                    if(is_null($row['sim_service_number']))$row['sim_service_number'] ='';
                    if(is_null($row['document_number']))$row['document_number'] ='';
                    if(is_null($row['submitted_date']))$row['submitted_date'] ='';
                    if(is_null($row['remarks']))$row['remarks'] ='';
                    $datatoinsert=[
                        "highland_id" => $row['sno'],
                        "customer_name" => $row['customer_name'],
                        "sim_serial_number" => $row['sim_serial_number'],
                        "sim_service_number" =>$row['sim_service_number'],
                        "document_number"=>$row['document_number'],
                        "submitted_date"=>$row['submitted_date'],
                        "remarks"=>$row['remarks'],
                        "created_at" =>date('Y-m-d H:i:s')
                    ];

                    if($row['sim_serial_number']!=='')
                    {
                        $datavodafone = HighlandData::firstOrCreate(['sim_serial_number'=>$row['sim_serial_number']]);
                        $datavodafone->update($datatoinsert);
                    }

                }
            });

            return true;

        }catch(\Exception $e)
        {
            abort('400');
        }



    }

    public function saveVodafoneExcel(Request $request)
    {
//        $rules = array('vodafone_xcel' => 'required|mimes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/x-xls,application/xls,application/x-excel,application/vnd.ms-excel',);
//        $validator = Validator::make($request->all(), $rules);
//
//        if($validator->fails())
//        {
//            return redirect(PREFIX.'/simRecord/pages/vodafoneSim')->with('msgError','valid excel file is required');
//        }

        try{

            Excel::load($request->file('vodafone_xcel'),function($reader){
                $results = $reader->get();
                dump($results);
                foreach ($reader->toArray() as $row) {
                    //dump($row);
                    if(is_null($row['id']))$row['id'] ='';
                    if(is_null($row['transaction_type']))$row['transaction_type'] ='';
                    if(is_null($row['vf_number']))$row['vf_number'] ='';
                    if(is_null($row['sim_service_number']))$row['sim_service_number'] ='';
                    if(is_null($row['issuance']))$row['issuance'] ='';
                    if(is_null($row['reason_fail']))$row['reason_fail'] ='';
                    if(is_null($row['comment_partner']))$row['comment_partner'] ='';
                    if(is_null($row['insert_date']))$row['insert_date'] ='';
                    if(is_null($row['insert_user']))$row['insert_user'] ='';
                    if(is_null($row['outlet_id']))$row['outlet_id'] ='';
                    if(is_null($row['outlet']))$row['outlet'] ='';
                    if(is_null($row['distributor_code']))$row['distributor_code'] ='';
                    if(is_null($row['region']))$row['region'] ='';
                    if(is_null($row['distributor']))$row['distributor'] ='';
                    if(is_null($row['type']))$row['type'] ='';
                    if(is_null($row['comment_vodafone']))$row['comment_vodafone'] ='';
                    if(is_null($row['november']))$row['month '] ='';
                    $datatoinsert=[
                        "vd_id" => $row['id'],
                        "transaction_type" => $row['transaction_type'],
                        "vf_number" => $row['vf_number'],
                        "sim_serial" => $row['sim_serial_number'],
                        "issuance" =>$row['issuance'],
                        "reason_fail"=>$row['reason_fail'],
                        "comment_partner"=>$row['comment_partner'],
                        "insert_date"=>$row['insert_date'],
                        "insert_user"=>$row['insert_user'],
                        "outlet_id" =>$row['outlet_id'],
                        "outlet" =>$row['outlet'],
                        "distributor_code" =>$row['distributor_code'],
                        "region" =>$row['region'],
                        "distributor" =>$row['distributor'],
                        "type" =>$row['type'],
                        "comment_vodafone" =>$row['comment_vodafone'],
                        "month" =>$row['month'],
                        //"vodafone_no_list" =>$row['sim_serial_number'],
                        "inserted_at" =>date('Y-m-d H:i:s')
                    ];

                    if($row['sim_serial_number']!=='') {
                        $datavodafone = VodafoneData::firstOrCreate(['sim_serial' => $row['sim_serial_number']]);
                        $datavodafone->update($datatoinsert);
                    }
                }
            });


            return true;

        }catch(\Exception $e)
        {
            abort('400');
        }





    }

    public function checkHighland(Request $request)
    {
        $vodafonedata = VodafoneData::find($request->id);

        $data['datas'] = HighlandData::where('sim_serial_number',$vodafonedata->sim_serial)->first();

        if(!is_null($data['datas']))
        {
            $data['title'] = "Highland Data for sim Serial no:".$data['datas']->sim_serial_number;
            return view(MODULEFOLDER . ".modules.simRecord.check-list-highland",$data)->render();
        }

        $data['title'] = 'Not found.';
        return view(MODULEFOLDER . ".modules.simRecord.check-list-highland",$data)->render();
    }



    public function checkVodafone(Request $request)
    {
        $highlanddata = HighlandData::find($request->id);

        $data['datas'] = VodafoneData::where('sim_serial',$highlanddata->sim_serial_number)->first();

        if(!is_null($data['datas']))
        {
            $data['title'] = "Vodafone Data for sim Serial no:".$data['datas']->sim_serial;
            return view(MODULEFOLDER . ".modules.simRecord.check-list-vodafone",$data)->render();
        }

        $data['title'] = 'Not found.';
        return view(MODULEFOLDER . ".modules.simRecord.check-list-vodafone",$data)->render();
    }



    public function detailsHighland(Request $request)
    {
        $data['datas'] =HighlandData::find($request->id);
        $data['title'] = "Highland Data Details:";
        return view(MODULEFOLDER . ".modules.simRecord.check-list-highland",$data)->render();

    }

    public function detailsVodafone(Request $request)
    {
        $data['datas'] =VodafoneData::find($request->id);
        $data['title'] = "Vodafone Data Details:";
        return view(MODULEFOLDER . ".modules.simRecord.check-list-vodafone",$data)->render();

    }

    public function highlandSample()
    {
        $pathToFile = base_path('userUploads/sample/highland.xlsx');
        return response()->download($pathToFile);
    }

    public function vodafoneSample()
    {
        $pathToFile = base_path('userUploads/sample/vodafone.xlsx');
        return response()->download($pathToFile);
    }








}