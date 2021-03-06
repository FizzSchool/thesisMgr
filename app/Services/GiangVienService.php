<?php 
namespace App\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use App\Services\SendEmailService;
use App\User;
use App\Giang_vien;
use Carbon\Carbon;
use Hash;
use Illuminate\Database\QueryException;
/**
* 
*/
class GiangVienService 
{
	
	function __construct()
	{
		# code...
	}
	public function handleFileExcel($pathFile){
		$return = "";
		$done = 0 ;
		$fail = 0 ;
		$result = Excel::load($pathFile,function($reader){})->get();

		//$result = $result->toJson();
		for($i = 0 ; $i < $result->get(0)->count() ; $i++){
			try{
				$password = substr(hash('sha512',rand()),0,6);
				$user = new User;
				$user->name = $result->get(0)->get($i)->ten;
				$user->email = $result->get(0)->get($i)->email;
				$user->role = "giang_vien";
				$user->password = Hash::make($password);
				$user->created_at = Carbon::now();
				$user->updated_at = Carbon::now();
			    $user->save();
				$id =  $user->id;

				$giang_vien = new Giang_vien();
				$giang_vien->ma_giang_vien = $result->get(0)->get($i)->ma;
				$giang_vien->user_id = $id;
				$giang_vien->bo_mon_id = $result->get(0)->get($i)->donvi;
				$giang_vien->save();

				$email = new SendEmailService();
				$email->basic_email("hieunm.hk@gmail.com",$password);

				$done++;
			}
			catch(\Exception $e){
				//echo "exception: ".$i ;
				$fail++;
				continue;
				
			}
		}
		return '{"done":'.$done.',"fail":'.$fail.'}';
	} 
	public function addOneGV($ma_giang_vien, $ten_giang_vien , $email, $bo_mon_id){
		try{
				$password = substr(hash('sha512',rand()),0,6);
				$user = new User;
				$user->name = $ten_giang_vien;
				$user->email = $email;
				$user->role = "giang_vien";
				$user->password = Hash::make($password);
				$user->created_at = Carbon::now();
				$user->updated_at = Carbon::now();
			    $user->save();
				$id =  $user->id;

				$giang_vien = new Giang_vien();
				$giang_vien->ma_giang_vien = $ma_giang_vien;
				$giang_vien->user_id = $id;
				$giang_vien->bo_mon_id = $bo_mon_id;
				$giang_vien->save();

				$email = new SendEmailService();
				$email->basic_email("hieunm.hk@gmail.com",$password);
				return true;
		}
		catch(\Exception $e){
				//echo "exception: ".$i ;
				return false;
		}
		
	}
}


