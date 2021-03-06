<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class De_tai extends Model
{
    protected $fillable = [
    	'ten_de_tai',
    	'ma_giang_vien',
    	'ma_sinh_vien',
    	'trang_thai_gv',
    	'trung',
    	'duoc_phep_sua_doi',
    	'ho_so',
    	'hop_thuc',
    	'hoan_tat',
    	'rut',
    	'bao_ve',
        'duoc_bao_ve',
        'sau_bao_ve'
    ];

    public $timestamps = false;
    //$sinhvien =  $detai->sinh_vien
    //$sinhvien->user->name  
    public function sinh_vien(){
    	return $this->belongsTo('App\Sinh_vien');
    }

    public function danh_gia(){
    	return $this->hasMany('App\Danh_gia');
    }
    public function giang_vien(){
        return $this->belongsTo('App\Giang_vien','ma_giang_vien','ma_giang_vien');      
    }
}
