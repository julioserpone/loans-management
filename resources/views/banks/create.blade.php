@extends('app')

@section('htmlheader_title')
    {{ ($edit) ? trans('globals.section_title.banks_edit') : trans('globals.section_title.banks_add') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ ($edit) ? trans('globals.section_title.banks_edit') : trans('globals.section_title.banks_add') }}</li>
@endsection

@include('partials.message')

@section('main-content')
	<div class="row">
		@if(!$edit)
			{!! Form::model(Request::all(),['route'=>['banks.store'], 'method'=>'POST', 'name'=>'bankFrm', 'id'=> 'bankFrm', 'role'=>'form']) !!}
        @else
            {!! Form::model($bank, ['route'=>['banks.update',$bank->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'bankFrm', 'id' => 'bankFrm']) !!}
        @endif
		<div class="col-sm-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h4>
						@if ($edit)
							<i class="fa fa-pencil-square-o"></i>&nbsp;{{ trans('globals.section_title.banks_edit') }}
						@else
							<i class="fa fa-plus-square"></i>&nbsp;{{ trans('globals.section_title.banks_add') }}
						@endif
					</h4>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-sm-6">
							{!! Form::label('name', trans('globals.bank_name')) !!}:
							{!! Form::text('name',  isset($bank) && $bank->name ? $bank->name : old('name'), ['class' => 'form-control']) !!}
						</div>
					</div>

				</div> {{-- box-body --}}
				<div class="box-footer">
					<button type="button" class="btn btn-success" onclick="$('#bankFrm').submit();">
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



