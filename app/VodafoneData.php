<?php
/**
 * Created by PhpStorm.
 * User: ekbana
 * Date: 5/19/16
 * Time: 4:19 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class VodafoneData extends Model
{
    protected $table = 'tbl_vodafone_datas';

    protected $fillable = ['vd_id', 'transaction_type', 'vf_number', 'status','sim_serial','sim_status', 'issuance', 'reason_fail', 'comment_partner', 'insert_date','insert_user','outlet_id','outlet','distributor_code','region','distributor','type','comment_vodafone','month','vodafone_no_list','inserted_at','updated_at'];

    public $timestamps = false;

    public function getAllData()
    {
        return VodafoneData::all();
    }

}