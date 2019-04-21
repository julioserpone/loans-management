@extends('auth.auth')

@include('partials.message')

@section('htmlheader_title')
    {{ trans('auth.log_in') }}
@endsection

@section('content')
<body class="login-page">
    <div class="login-box">

        <div class="login-logo">
            <a href="{{ url('/home') }}"><b>{{ trans('auth.log_in') }}</b></a>
        </div><!-- /.login-logo -->

        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('auth.start_your_session') }}</p>
            <form action="{{ url('/auth/login') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Username" name="username"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember"> {{ trans('auth.remember_me') }}
                            </label>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('auth.sign_in') }}</button>
                    </div><!-- /.col -->
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </form>

            <hr>

            <a href="{{ url('/password/email') }}">{{ trans('auth.forgot_pass') }}</a><br>

        </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->

    @include('auth.scripts')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
