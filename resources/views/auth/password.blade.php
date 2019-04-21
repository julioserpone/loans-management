@extends('auth.auth')

@include('partials.message')

@section('htmlheader_title')
    {{ trans('passwords.title') }}
@endsection

@section('content')

<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/home') }}"><b>{{ trans('passwords.title') }}</b></a>
        </div><!-- /.login-logo -->

        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('passwords.reset_password') }}</p>
            <form action="{{ url('/password/email') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-2">
                    </div><!-- /.col -->
                    <div class="col-xs-8">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('passwords.reset_link') }}</button>
                    </div><!-- /.col -->
                    <div class="col-xs-2">
                    </div><!-- /.col -->
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </form>

            <hr>
            <a href="{{ url('/auth/login') }}">{{ trans('auth.log_in') }}</a><br>

        </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->

    @include('auth.scripts')

</body>

@endsection
