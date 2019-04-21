<head>
    <meta charset="UTF-8">
    <title>{{ trans('globals.app_title') }} @yield('htmlheader_title', 'Your title here') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href = "{{ asset('/css/bootstrap.css') }}" rel = "stylesheet" type = "text/css" />
    <link href = "https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel = "stylesheet" type = "text/css" />
    <link href = "https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel = "stylesheet" type = "text/css" />
    <link href = "{{ asset('/css/AdminLTE.css') }}" rel = "stylesheet" type = "text/css" />
    <link href = "{{ asset('/css/skins/skin-blue.css') }}" rel = "stylesheet" type = "text/css" />
    <link href = "{{ asset('/css/app.css') }}" rel = "stylesheet" type = "text/css" />
    <link href = "{{ asset('/plugins/iCheck/square/blue.css') }}" rel = "stylesheet" type = "text/css" />
    <link href = "{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel = "stylesheet" >
    <link href = "{{ asset('/plugins/select2/select2.min.css') }}" rel = "stylesheet" >
    <link href = "{{ asset('/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel = "stylesheet" >
    <link href = "https://cdn.datatables.net/responsive/2.0.0/css/responsive.dataTables.min.css" rel = "stylesheet" type = "text/css" />
    <link href = "{{ asset('/gocanto-bower/pnotify/pnotify.core.css') }}" rel = "stylesheet" type = "text/css" />
    <link href = "{{ asset('/gocanto-bower/pnotify/pnotify.buttons.css') }}" rel = "stylesheet" type="text/css" />
    @section('css_module')

    @show
</head>