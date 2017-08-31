<?php
/**
 * Created by PhpStorm.
 * User: ekbana
 * Date: 5/19/16
 * Time: 4:17 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class HighlandData extends Model
{
    protected $table = 'tbl_highland_datas';

    protected $fillable = ['highland_id', 'customer_name', 'sim_serial_number', 'sim_service_number','document_number','submitted_date', 'remarks', 'created_at'];

    public $timestamps = false;

    public function getAllData()
    {
        return HighlandData::all();
    }

}