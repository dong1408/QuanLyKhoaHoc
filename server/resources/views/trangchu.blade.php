@extends('layouts.app')

@section('content')
@guest
    <div class = "alert" style = "border: 1px solid #e8e5e5; color:#164266;">
        <div class="row pl-2">
            <h6 class = "text-danger font-weight-bold">HƯỚNG DẪN</h6><br/>
        </div>   
        <div class="row pl-2 pb-2">
            <div class = "">
                <span class =""><span class="fa-stack"><span class="fa fa-square-o fa-stack-2x"></span><strong class="fa-stack-1x"> 
                1</strong></span>  Hệ thống hỗ trợ nhập điểm, quản lý điểm trực tuyến. Giảng viên nhập mã viên chức và mật khẩu để đăng nhập.</span>
            </div>        
        </div>    
        <div class="row pl-2 pb-2">
            <div class = "">
                <span class =""><span class="fa-stack"><span class="fa fa-square-o fa-stack-2x"></span><strong class="fa-stack-1x"> 
                2</strong></span>  Lần đầu đăng nhập, Giảng viên bắt buộc thay đổi mật khẩu mặc định, nhập địa chỉ email thường sử dụng để phục hồi mật khẩu khi cần.</span>
            </div>        
        </div> 
        <div class="row pl-2 pb-2">
            <div class = "">
                <span class =""><span class="fa-stack"><span class="fa fa-square-o fa-stack-2x"></span><strong class="fa-stack-1x"> 
                3</strong></span>  Giảng viên xem hướng dẫn nhập ĐQT <a href = "{{asset('/files/HD_GV_HeThongNhapDiem.docx')}}" target ="_blank"> <b>TẠI ĐÂY</b> </a> (Xem hướng dẫn nhập điểm thi <a href = "{{asset('/files/HD_NhapDiemThi.docx')}}" target ="_blank"> <b>TẠI ĐÂY</b> </a>)</span>
            </div>        
        </div>     
        <div class="row pl-2">
            <div>
                <span class =""><span class="fa-stack"><span class="fa fa-square-o fa-stack-2x"></span><strong class="fa-stack-1x"> 
                4</strong></span> Mọi thắc mắc cần giải đáp, vui lòng liên hệ <b>Phòng Đào tạo: </b>
                <br> &nbsp&nbsp&nbsp&nbsp&nbsp + Phòng C009, 273 An Dương Vương, phường 3, quận 5, TP HCM. 
                <br> &nbsp&nbsp&nbsp&nbsp&nbsp + Số điện thoại/Zalo: <a class = "text-decoration-none" href="tel:0985445808">0985445808</a> (Chí Thanh) - <a class = "text-decoration-none" href="tel:0982947046">0982.947.046 </a>(Đăng Thuấn).
                <br> &nbsp&nbsp&nbsp&nbsp&nbsp + Website: <a href="http://daotao.sgu.edu.vn/" target="_blank"> http://daotao.sgu.edu.vn/ </a></span>
            </div>        
        </div>             
    </div>
@endguest
@if (Auth::user())
<div class = "alert" style = "border: 1px solid #e8e5e5; color:#164266;">
    <div class="row pl-2">
        <h6 class = "text-danger font-weight-bold">HƯỚNG DẪN</h6><br/>
    </div>  
    <div class="row pl-2 pb-2">
        <div class = "">
            <span class =""><span class="fa-stack"><span class="fa fa-square-o fa-stack-2x"></span><strong class="fa-stack-1x"> 
            1</strong></span>  Hệ thống hỗ trợ nhập điểm, quản lý điểm trực tuyến. Giảng viên nhấn <a href = "/home" class = "btn btn-sm btn-info">vào đây</a> để vào hệ thống</span>
        </div>        
    </div>    
    <div class="row pl-2 pb-2">
        <div class = "">
            <span class =""><span class="fa-stack"><span class="fa fa-square-o fa-stack-2x"></span><strong class="fa-stack-1x"> 
            3</strong></span>  Giảng viên xem hướng dẫn nhập ĐQT <a href = "{{asset('/files/HD_GV_HeThongNhapDiem.docx')}}" target ="_blank"> <b>TẠI ĐÂY</b> </a> (Xem hướng dẫn nhập điểm thi <a href = "{{asset('/files/HD_NhapDiemThi.docx')}}" target ="_blank"> <b>TẠI ĐÂY</b> </a>)</span>
        </div>        
    </div>     
    <div class="row pl-2">
        <div>
            <span class =""><span class="fa-stack"><span class="fa fa-square-o fa-stack-2x"></span><strong class="fa-stack-1x"> 
            3</strong></span> Mọi thắc mắc cần giải đáp, vui lòng liên hệ <b>Phòng Đào tạo: </b>
            <br> &nbsp&nbsp&nbsp&nbsp&nbsp + Phòng C009, 273 An Dương Vương, phường 3, quận 5, TP HCM. 
            <br> &nbsp&nbsp&nbsp&nbsp&nbsp + Số điện thoại/Zalo: <a class = "text-decoration-none" href="tel:0985445808">0985445808</a> (Chí Thanh) - <a class = "text-decoration-none" href="tel:0982947046">0982.947.046 </a>(Đăng Thuấn).
            <br> &nbsp&nbsp&nbsp&nbsp&nbsp + Website: <a href="http://daotao.sgu.edu.vn/" target="_blank"> http://daotao.sgu.edu.vn/ </a></span>
        </div>        
    </div>              
</div>
@endif
@endsection
