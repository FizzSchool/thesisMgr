<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giang_vien extends Model
{
    //
    protected $fillable = [
    	'ma_giang_vien',
    	'user_id',
    	'bo_mon_id'
    ];

    protected $table = 'giang_viens';

    protected $primaryKey = 'ma_giang_vien';

    public $incrementing = false;

    public $timestamps = false;

    protected $hidden = [
        'password', 'remember_token', 
    ];

    public function user()
    {
    	# code...
    	return $this->belongsTo('App\User');
    }

    public function bo_mon()
    {
    	# code...
    	return $this->belongsTo('App\Bo_mon');
    }

    public function huong_nghien_cuu()
    {
    	# code...
        #
        //$this->primaryKey = 'ma_giang_vien'; 
    	return $this->hasMany('App\Huong_nghien_cuu', 'ma_giang_vien', 'ma_giang_vien');
    }
    public function de_tai(){
        return $this->hasMany('App\De_tai','ma_giang_vien','ma_giang_vien');
    }
    public function danh_gia(){
        return $this->hasMany('App\Danh_gia','ma_giang_vien','ma_giang_vien');
    }
}
