@extends('app')

@section('css_module')
	@parent
	<link href = "{{ asset('/gocanto-bower/fullcalendar/dist/fullcalendar.min.css') }}" rel = "stylesheet" type="text/css" />
@endsection

@section('htmlheader_title')
    {{ trans('globals.section_title.full_calendar') }}
@endsection

@section('contentheader_title')
    {{ $ref.' '.trans('globals.section_title.full_calendar') }}
@endsection

@section('contentheader_description')
	{{ trans('globals.section_title.full_calendar_des') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ $ref.' '.trans('globals.section_title.full_calendar') }}</li>
@endsection

@section('main-content')

	<div class="row">
		<div class="col-sm-6">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h4>
						<i class="fa fa-calendar"></i>&nbsp;{{ trans('holyday.calendar_title') }}
					</h4>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-sm-12">
							<div id="calendar"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<h4>
						<i class="fa fa-sun-o"></i>&nbsp;{{ trans('holyday.holydays_title_list') }}
					</h4>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-sm-12">
							@if ($is_holyday)
								@include('holydays.grid', $holydays)
							@else
								hey!
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@include('partials.message')

@section('js_module')
	@parent
	<script src = "{{ asset('/gocanto-bower/moment/moment.js') }}" type = "text/javascript"></script>
	<script src = "{{ asset('/gocanto-bower/fullcalendar/dist/fullcalendar.min.js') }}" type = "text/javascript"></script>
@endsection

@section ('jQueryScripts')
	<script>
        $(function () {
            $(document).ready(function() {

            	@if (count($holydays) == 0)
            		$('#holydays_datagrid').hide();
            		$('#there_is_not_holidays').show();
            	@endif

				$('#calendar').fullCalendar({
					header: {
						left: 'prevYear, nextYear',
						center: 'title'
					},
					weekends: false,
					dayClick: function(date, jsEvent, view) {

						$(this).css('background-color', '#FAFAFA');

						@if ($is_holyday)

							delete_url = "{!! route('holydays.delete', '*') !!}";

							$.ajax({
							  method: "POST",
							  dataType: "JSON",
							  url: "{{ route('calendar.holydays.store') }}",
							  data: { date: date.format(), _token: "{{ csrf_token() }}" }
							})
							.done(function(data) {

            					$('#there_is_not_holidays').fadeOut(function(){
            						$('#holydays_datagrid').fadeIn();
            					});

								$("#holydays_datagrid_body").append(
									"<tr>" +
									"<td>"+data['date']+"</td>" +
									"<td>"+data['responsable']+"</td>" +
									"<td class='text-center'>"+data['updated_at']+"</td>" +
									"<td class='text-center'><a href = '"+delete_url.replace('*', data['holyday_id'])+"' class='btn btn-danger btn-xs'><i class='glyphicon glyphicon-trash'></i></a></td>" +
									"</tr>"
								);
							});
						@endif

				    }
				});

			});
        });
    </script>
@endsection


