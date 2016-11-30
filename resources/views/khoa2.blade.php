@extends('layouts.temp')

@section('dieuhuong')
	<li class=" treeview">
          <a href="#">
            <i class="fa fa-address-card"></i> <span>Quản lí tài khoản giảng viên</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a id="open-ds-gv" href="#">Danh sách giảng viên</a></li>
            <li><a id="open-upload-gv" href="#">Khởi tạo bằng excel</a></li>
            <li><a id="open-add-gv" href="#">Thêm thủ công</a></li>

          </ul>
        </li>
        <li class=" treeview">
          <a href="#">
            <i class="fa fa-user-o"></i> <span>Quản lí tài khoản sinh viên</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li><a id="open-ds-sv" href="#">Danh sách sinh viên</a></li>
            <li><a id="open-upload-sv" href="#">Khởi tạo bằng excel</a></li>
            <li><a id="open-add-sv" href="#">Thêm sinh viên thủ công</a></li>
          </ul>
        </li>

        <li class=" treeview">
          <a href="#">
            <i class="fa fa-bars"></i> <span>Khóa học và đào tạo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li><a id="" href="#">Khóa học</a></li>
            <li><a id="" href="#">Chương trình đào tạo</a></li>
          </ul>
        </li>
  </li>
@endsection
@section('main-content')

	 <h1 style="margin-top: 0px;" id="hhh" >Đây là trang admin của khoa {{$ten_khoa}} </h1>
   <div id="wait" class="alert alert-success" style="position:fixed;bottom:10px;right:10px;">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                  <i class="fa fa-refresh fa-spin"></i>
                  <strong>Đang xử lý...</strong>
                </div>
@endsection
@section('nguoi-dang-nhap')
	Khoa {{$ten_khoa}}
@endsection


