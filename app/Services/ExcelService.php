<?php 
namespace App\Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;

use App\Sinh_vien;
use App\De_tai;
use App\Giang_vien;
use App\User;
use App\Services\Helper\DetaiInfo;
use App\Services\Helper\DanhgiaInfo; 
use App\Services\Helper\SinhvienInfo2;

/**
* 
*/
class ExcelService 
{
	
	function __construct()
	{
		# code...
	}
	public function exportListSvDt($filename, $khoa_id){
		$listSv = Sinh_vien::whereRaw('khoa_id = ? and dang_ky=1', [$khoa_id])->get();

		// Phần lấy ra danh sách các đề tài được phép đăng ký bảo vệ
		$result = array();
		for($i = 0 ; $i < $listSv->count(); $i++){
			$temp = new SinhvienInfo2();
			$temp->ma_sinh_vien = $listSv[$i]->ma_sinh_vien;
			$temp->ten_sinh_vien = $listSv[$i]->user->name;

			$de_tai = De_tai::where('ma_sinh_vien','=',$listSv[$i]->ma_sinh_vien)->first();
			if(isset($de_tai)){
				if($de_tai->trang_thai_gv != 'dong_y' || $de_tai->trung == 1 || $de_tai->yeu_cau_sua == 1 || $de_tai->rut == 1 || $de_tai->ten_de_tai == null ||$de_tai->bao_ve == 1){
					continue;
				}
				else{
					$temp->ten_de_tai = $de_tai->ten_de_tai;
					$temp->ten_gv = Giang_vien::find($de_tai->ma_giang_vien)->user->name;
					$de_tai->bao_ve = 1;
					$de_tai->save();


					$sinhvien = $listSv[$i];
					$sinhvien->dang_ky=0;
					$sinhvien->save();
				}
			}
			else{
				continue;
			}
			array_push($result, $temp);
		} 

		// Phần tạo file excel 
		Excel::create($filename, function($excel) use($result) {

		    $excel->sheet('Sheet1', function($sheet) use($result) {
		    	$sheet->appendRow(array(
				    'DANH SÁCH SINH VIÊN ĐƯỢC PHÉP NỘP HỒ SƠ VÀ ĐĂNG KÝ BẢO VỆ'
				));
		    	$sheet->appendRow(array(
				    'Mã sinh viên', 'Tên sinh viên','Giảng viên hướng dẫn','Tên đề tài'
				));
				for($i = 0 ; $i < count($result); $i++){
					$sheet->appendRow(array(
				    $result[$i]->ma_sinh_vien, $result[$i]->ten_sinh_vien,$result[$i]->ten_gv,
				    $result[$i]->ten_de_tai
				));
				}
			});

		})->store('xlsx', storage_path('../public/download/excel'));
	}

	public function exportListBv($filename , $khoa_id){
		$listSv = Sinh_vien::whereRaw('khoa_id = ?', [$khoa_id])->get();

		// Phần lấy ra danh sách các đề tài được phép đăng ký bảo vệ
		$result = array();
		for($i = 0 ; $i < $listSv->count(); $i++){
			$temp = new SinhvienInfo2();
			$temp->ma_sinh_vien = $listSv[$i]->ma_sinh_vien;
			$temp->ten_sinh_vien = $listSv[$i]->user->name;

			$de_tai = $listSv[$i]->de_tai;
			if(isset($de_tai)){
				if($de_tai->bao_ve != 1 || $de_tai->ho_so!=1 || $de_tai->hop_thuc != 1 || $de_tai->duoc_bao_ve == 1 || $de_tai->sau_bao_ve == 1 ){
					continue;
				}
				else{
					$temp->ten_de_tai = $de_tai->ten_de_tai;
					$temp->ten_gv = Giang_vien::find($de_tai->ma_giang_vien)->user->name;
					$de_tai->duoc_bao_ve = 1;
					$de_tai->save();
				}
			}
			else{
				continue;
			}
			array_push($result, $temp);
		} 

		// Phần tạo file excel 
		Excel::create($filename, function($excel) use($result) {

		    $excel->sheet('Sheet1', function($sheet) use($result) {
		    	$sheet->appendRow(array(
				    'DANH SÁCH SINH VIÊN ĐƯỢC BẢO VỆ'
				));
		    	$sheet->appendRow(array(
				    'Mã sinh viên', 'Tên sinh viên','Giảng viên hướng dẫn','Tên đề tài'
				));
				for($i = 0 ; $i < count($result); $i++){
					$sheet->appendRow(array(
				    $result[$i]->ma_sinh_vien, $result[$i]->ten_sinh_vien,$result[$i]->ten_gv,
				    $result[$i]->ten_de_tai
				));
				}
			});

		})->store('xlsx', storage_path('../public/download/excel'));
	}


	// Hàm tạo file excel chứa danh sách phân công và hội đồng phản biện
	public function exportListPc($filename , $listPb){
		Excel::create($filename, function($excel) use($listPb) {

		    $excel->sheet('Sheet1', function($sheet) use($listPb) {
		    	$sheet->appendRow(array(
				    'DANH SÁCH HỘI ĐỒNG PHẢN BIỆN'
				));
		    	$sheet->appendRow(array(
				    'Mã sinh viên', 'Tên sinh viên','Tên đề tài','Giảng viên phản biện'
				));
				for($i = 0 ; $i < count($listPb); $i++){
					$de_tai = Sinh_vien::find($listPb[$i]->ma_sinh_vien)->de_tai;
					$de_tai->xuat_phan_cong = 1;
					$de_tai->save();
					for($j = 0 ; $j < count($listPb[$i]->listDanhgia) ; $j++){
						$sheet->appendRow(array(
						    $listPb[$i]->ma_sinh_vien,$listPb[$i]->ten_sinh_vien,$listPb[$i]->ten_de_tai,$listPb[$i]->listDanhgia[$j]->ten_gvdg
						));
					}
				}
			});

		})->store('xlsx', storage_path('../public/download/excel'));
	}

	// Hàm tạo file excel chứa danh sách điểm
	public function exportListDiem($filename , $listPb){
		Excel::create($filename, function($excel) use($listPb) {

		    $excel->sheet('Sheet1', function($sheet) use($listPb) {
		    	$sheet->appendRow(array(
				    'DANH SÁCH ĐIỂM BẢO VỆ ĐỀ TÀI'
				));
		    	$sheet->appendRow(array(
				    'Mã sinh viên', 'Tên sinh viên','Tên đề tài','Điểm trung bình'
				));
				for($i = 0 ; $i < count($listPb); $i++){
					$de_tai = Sinh_vien::find($listPb[$i]->ma_sinh_vien)->de_tai;
					$de_tai->sau_bao_ve = 1;
					$de_tai->save();
					$sum = 0;
					for($j = 0 ; $j < count($listPb[$i]->listDanhgia) ; $j++){
						$sum += $listPb[$i]->listDanhgia[$j]->diem;
					}
					$tb = $sum/count($listPb[$i]->listDanhgia);
					$sheet->appendRow(array(
						    $listPb[$i]->ma_sinh_vien,$listPb[$i]->ten_sinh_vien,$listPb[$i]->ten_de_tai,$tb
						));
				}
			});

		})->store('xlsx', storage_path('../public/download/excel'));
	}
}