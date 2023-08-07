@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 mb-2"> <!-- style="border-right: solid 1px #E7EAED" -->
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                        {{ csrf_field() }}
                        @if(Auth::user()->changed == 0 && Auth::user()->email == null)
                        <div class="form-group">
                            <div class="">
                                <input id="email" type="email" class="form-control"
                                placeholder ="Email" name="email" required>
                                @if ($errors->has('email'))
                                    <small class="help-block text-danger">
                                        {{ $errors->first('email') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                            <div class="">
                                <input id="current-password" type="password" class="form-control" name="current-password"
                                placeholder = "Mật khẩu hiện tại" required>

                                @if ($errors->has('current-password'))
                                    <small class="help-block text-danger">
                                       {{ $errors->first('current-password') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                            <div class="">
                                <input id="new-password" type="password" class="form-control" name="new-password"
                                placeholder = "Mật khẩu mới" required>

                                @if ($errors->has('new-password'))
                                    <small class="help-block text-danger">
                                        {{ $errors->first('new-password') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <input id="new-password-confirm" type="password" class="form-control"
                                placeholder ="Nhập lại mật khẩu mới" name="new-password_confirmation" required>
                            </div>
                        </div>
                        <input class="form-control d-none" id="" name = 'url' value = "{{ URL::previous() }}" />
                        <div class="form-group d-flex justify-content-center">
                            <div class="col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Thay đổi mật khẩu
                                </button>
                            </div>
                        </div>
                    </form>
                    @if(session()->has('message'))
                        <div class="alert alert-info">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9" style = "font-size: 0.95em"> <!-- style="border-right: solid 1px #E7EAED" -->
            <div class="card">
                <div class="card-body">
                    @if(Auth::user()->changed == 0)
                        <div class = "alert alert-info">
                            <span class="">Trước khi sử dụng hệ thống, quý Thầy Cô phải thay đổi mật khẩu và nhập email (nếu chưa có).</span>
                        </div>
                    @endif
                    <div class = "alert alert-warning">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        <span class="text-danger">Lưu ý: Mật khẩu phải có độ dài tối thiểu 6 kí tự; có ít nhất 1 kí tự viết hoa và 1 số; có thể có kí hiệu đặc biệt (ví dụ @)</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@stop
@section('scripts')
<script src="{{ asset('js/jquery.min.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {
    });

</script>
@stop
