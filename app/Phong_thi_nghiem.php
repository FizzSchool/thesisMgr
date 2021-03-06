<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phong_thi_nghiem extends Model
{
    //
    protected $fillable = [
    	'ten_phong_thi_nghiem',
    	'khoa_id',
    	'mo_ta'
    ];
    public $timestamps = false;
    public function khoa()
    {
    	# code...
    	return $this->belongsTo('App\Khoa');
    }
}
