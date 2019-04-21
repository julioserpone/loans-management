{{-- Content Header (Page header) --}}
<section class="content-header">
    <h1>
        @yield('contentheader_title', trans('globals.contentheader_title'))
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class = "breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i>&nbsp;{{ trans('globals.section_title.home') }}</a></li>
        @section('breadcrumb_li')

        @show
    </ol>
</section>