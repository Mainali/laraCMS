<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageData extends Model
{
    protected $table = 'tbl_image';
	public $timestamps = false;
 protected $fillable = ['image'];


  	public function add($data){
  		ImageData::create($data);
  	}
  
}