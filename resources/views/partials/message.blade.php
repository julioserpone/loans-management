<?php
    $class = Session::get('messageClass') ? Session::get('messageClass') : 'success';

    $icon = Session::get('messageIcon') ? Session::get('messageIcon') : '';

    $title = Session::get('messageTitle') ? Session::get('messageTitle') : '';

    $m = Session::get('message');

    $m = $m ? (is_array($m) ? Html::ul($m) : '<p>'.$m.'</p>' ) : '';

    $e = (isset($errors)) ? Html::ul($errors->all()) : '';

    Session::forget(['message', 'messageClass', 'messageIcon', 'messageTitle']);

    Session::save();
?>

@if($m!='' || $e!='')
  @section('jsMessages')

    <script type="text/javascript">
    $(function()
    {
      @if($m!='')
        console.log('message');
        new PNotify({
            title: '{{ $title != "" ? $title : trans("globals.success_alert_title") }}',
            text: '{!! $m !!}',
            type: '{{ $class }}',
            delay: 5000,
            mouse_reset: true,
            styling: 'bootstrap3',
            icon : @if ($icon!='') '{{ $icon }}' @else true @endif
        });
      @endif
      @if($e!='')
        console.log('error');
        new PNotify({
            title: '{{ trans("globals.error_alert_title") }}',
            text: '{!! $e !!}',
            type: 'error',
            delay: 5000,
            mouse_reset: true,
            styling: 'bootstrap3'
        });
      @endif
    });
    </script>
  @stop

@endif