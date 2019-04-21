@extends('app')

@section('htmlheader_title')
    {{ ($edit) ? trans('globals.section_title.cities_edit') : trans('globals.section_title.cities_add') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ ($edit) ? trans('globals.section_title.cities_edit') : trans('globals.section_title.cities_add') }}</li>
@endsection

@include('partials.message')

@section('main-content')
	<div class="row">
		@if(!$edit)
			{!! Form::model(Request::all(),['route'=>['cities.store'], 'method'=>'POST', 'name'=>'cityFrm', 'id'=> 'cityFrm', 'role'=>'form']) !!}
        @else
            {!! Form::model($city, ['route'=>['cities.update',$city->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'cityFrm', 'id' => 'cityFrm']) !!}
        @endif
		<div class="col-sm-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h4>
						@if ($edit)
							<i class="fa fa-pencil-square-o"></i>&nbsp;{{ trans('globals.section_title.cities_edit') }}
						@else
							<i class="fa fa-plus-square"></i>&nbsp;{{ trans('globals.section_title.cities_add') }}
						@endif
					</h4>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-sm-6">
							{!! Form::label('name', trans('globals.city_name')) !!}:
							{!! Form::text('name',  isset($city) && $city->name ? $city->name : old('name'), ['class' => 'form-control']) !!}
						</div>
					</div>

				</div> {{-- box-body --}}
				<div class="box-footer">
					<button type="button" class="btn btn-success" onclick="$('#cityFrm').submit();">
						<i class="fa fa-paper-plane-o"></i>&nbsp;
						{{ trans('globals.submit') }}
					</button>
				</div> {{-- box-footer --}}
			</div> {{-- box box-info --}}
		</div> {{-- col-sm-12 --}}

		{!! Form::token() !!}
		{!! Form::close() !!}
	</div> {{-- row --}}

@endsection



