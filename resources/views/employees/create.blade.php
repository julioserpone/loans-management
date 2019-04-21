@extends('app')

@section('htmlheader_title')
    {{ (isset($profile)) ? trans('globals.section_title.profile') : (($edit) ? trans('globals.section_title.employees_edit') : trans('globals.section_title.employees_add')) }}
@endsection

@section('contentheader_title')
    {{ (isset($profile)) ? trans('globals.section_title.profile') : (($edit) ? trans('globals.section_title.employees_edit') : trans('globals.section_title.employees_add')) }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ (isset($profile)) ? trans('globals.section_title.profile') : (($edit) ? trans('globals.section_title.employees_edit') : trans('globals.section_title.employees_add')) }}</li>
@endsection


@section('main-content')
	<div class="row">
		@if(!$edit)
			{!! Form::model(Request::all(),['route'=>['employees.store'], 'method'=>'POST', 'name'=>'employeeFrm', 'id'=> 'employeeFrm', 'role'=>'form', 'files' => true]) !!}
        @else
        	@if(isset($profile))
        		{!! Form::model($user, ['route'=>['profile.update',$user->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'employeeFrm', 'id' => 'employeeFrm', 'files' => true]) !!}
        		{!! Form::hidden('isprofile', true, ['id' => 'isprofile','class' => 'form-control']) !!}
        	@else
            	{!! Form::model($user, ['route'=>['employees.update',$user->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'employeeFrm', 'id' => 'employeeFrm', 'files' => true]) !!}
        	@endif
        @endif
        {!! Form::hidden('key', isset($user) && $user->password ? $user->password : '') !!}
		<div class="col-sm-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<i class="fa fa-user"></i>&nbsp;{{ trans('globals.section_title.employees_add_descrip_01') }}
				</div>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('first_name', trans('users.first_name')) !!}
							{!! Form::text('first_name',  isset($user) && $user->first_name ? $user->first_name : old('first_name'), ['class' => 'form-control', isset($profile) ? 'readonly' : '']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('last_name', trans('users.last_name')) !!}
							{!! Form::text('last_name', isset($user) && $user->last_name ? $user->last_name : old('last_name'), ['class' => 'form-control', isset($profile) ? 'readonly' : '']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('identification', trans('users.identification')) !!}
							<div class="input-group input-group-md">
								<div class="input-group-btn">
									<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="ident" {{ isset($profile) ? 'disabled' : '' }}>
										@if (isset($user) && $user->identification_type)
											{{ strtoupper($user->identification_type) }}
										@elseif (old('identification_type'))
											{{ strtoupper(old('identification_type')) }}
										@else
											{{ trans('globals.type') }}
										@endif
										<span class="fa fa-caret-down"></span>
									</button>
									<ul class="dropdown-menu">
										@foreach (array_keys(trans('globals.identification_type')) as $key => $iden)
											<li>
												<a href = "javascript:void(0);" onclick = "$('#identification_type').val('{{ $iden }}'); $('#ident').text('{{ strtoupper($iden) }}');">{{ strtoupper($iden) }}</a>
											</li>
										@endforeach
									</ul>
								</div>
								{!! Form::text('identification', isset($user) && $user->identification ? $user->identification : old('identification'), ['class' => 'form-control', isset($profile) ? 'readonly' : '']) !!}
								{!! Form::hidden('identification_type', isset($user) && $user->identification_type ? $user->identification_type : old('identification_type'), ['id' => 'identification_type','class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('gender', trans('users.gender')) !!} <br>
							{!! Form::radio('gender', 'male', isset($user->gender) && $user->gender == 'male' ? true : false, ['class' => 'radio-inline', isset($profile) ? 'readonly' : '']) !!} {{ trans('globals.gender.male') }}
							{!! Form::radio('gender', 'female', isset($user->gender) && $user->gender == 'female' ? true : false, ['class' => 'radio-inline', isset($profile) ? 'readonly' : '']) !!} {{ trans('globals.gender.female') }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('birth_date', trans('users.birth_date')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								{!! Form::text('birth_date', isset($user) && $user->birth_date ? $user->birth_date : old('birth_date'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('cellphone_number', trans('users.cellphone_number')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								{!! Form::text('cellphone_number', isset($user) && $user->cellphone_number ? $user->cellphone_number : old('cellphone_number'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('homephone_number', trans('users.homephone_number')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								{!! Form::text('homephone_number', isset($user) && $user->homephone_number ? $user->homephone_number : old('homephone_number'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">

						<div class="form-group col-sm-12">
							{!! Form::label('photo', trans('globals.photo')) !!}
							{!! Form::file('photo', ['class' => 'form-control']) !!}
						</div>
						@if ($edit)
							<div class="form-group col-sm-12">
								<img src = "{{ asset($user->pic_url) }}" class = "img-profile" alt = "{{ $user->first_name }}" />
							</div>
						@endif
					</div>
				</div> {{-- box-body --}}
				<div class="box-footer">
					<button type="button" class="btn btn-success" onclick="$('#employeeFrm').submit();">
						<i class="fa fa-paper-plane-o"></i>&nbsp;
						{{ trans('globals.submit') }}
					</button>
				</div> {{-- box-footer --}}
			</div> {{-- box box-info --}}
		</div> {{-- col-sm-6 --}}

		<div class="col-sm-6">
			<div class="box box-success">
				<div class="box-header with-border">
					<i class="fa fa-lock"></i>&nbsp;{{ trans('globals.section_title.employees_add_descrip_02') }}
				</div>
				<div class="box-body">
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('username', trans('users.username')) !!}
							{!! Form::text('username',  isset($user) && $user->username ? $user->username : old('username'), ['class' => 'form-control']) !!}
						</div>
						<div class="form-group col-sm-12">
							{!! Form::label('email', trans('users.email')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-envelope-o"></i>
								</div>
								{!! Form::email('email', isset($user) && $user->email ? $user->email : old('email'), ['class' => 'form-control']) !!}
							</div>
						</div>
						<div class="form-group col-sm-12">
							{!! Form::label('password', trans('users.password')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-lock"></i>
								</div>
								{{-- SI EL PASSWORD EXISTE, LO DEJO EN BLANCO. SI QUIERE ACTUALIZARLO, INGRESA NUEVA PASS Y AL ENVIAR EL CONTROLLER LO PROCESA. SI LO DEJA EN BLANCO, NO HACE EL UPDATE DEL PASS --}}
								<input id='password' class='form-control' type='password' data-toggle='password' value = "{{ isset($customers->card_key) ? '' : old('password') }}">
							</div>
						</div>
						@if (!isset($profile))
							<div class="form-group col-sm-12">
								{!! Form::label('role', trans('users.role')) !!}
								{!! Form::select('role', $roles, isset($user->role) ? $user->role : old('role'), ['id' => 'role', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
							</div>
							<div class="form-group col-sm-12">
								{!! Form::label('status', trans('globals.status')) !!}
								{!! Form::select('status', $status, isset($user) && $user->status ? $user->status : old('status'), ['class' => 'form-control']); !!}
							</div>
						@endif
					</div>
				</div> {{-- box-body --}}
				<div class="box-footer">
					<button type="button" class="btn btn-success" onclick="$('#employeeFrm').submit();">
						<i class="fa fa-paper-plane-o"></i>&nbsp;
						{{ trans('globals.submit') }}
					</button>
				</div> {{-- box-footer --}}
			</div> {{-- box box-info --}}
		</div> {{-- col-sm-6 --}}
		{!! Form::token() !!}
		{!! Form::close() !!}
	</div> {{-- row --}}

	{{-- Loans Grid --}}
	<div class="row">
		<div class="col-sm-12">
			@if (isset($loans) && $edit)
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h4>
									<i class="fa fa-th"></i>&nbsp;{{ trans('globals.section_title.loans_list') }}
								</h4>
							</div>
							<div class="box-body">
								<table id="loans_grid" class="table table-bordered table-hover dataTable" role="grid" cellspacing="0" width="100%">
							        <thead>
							            <tr>
							                <th class="text-center">{{ trans('globals.customer') }}</th>
							                <th class="text-right">{{ trans('loans.amount') }}</th>
							                <th class="text-right">{{ trans('globals.pending_amount') }}</th>
							                <th class="text-center">{{ trans('loans.interest_rate') }}</th>
							                <th class="text-center">{{ trans('globals.frequency') }}</th>
							                <th class="text-center">{{ trans('loans.first_payment') }}</th>
							                <th class="text-center">{{ trans('globals.next_payment') }}</th>
							                <th class="text-center">{{ trans('loans.status') }}</th>
							                <th class="text-center">{{ trans('globals.actions') }}</th>
							            </tr>
							        </thead>
							        <tfoot>
							            <tr>
							                <th class="text-center">{{ trans('globals.customer') }}</th>
							                <th class="text-right">{{ trans('loans.amount') }}</th>
							                <th class="text-right">{{ trans('globals.pending_amount') }}</th>
							                <th class="text-center">{{ trans('loans.interest_rate') }}</th>
							                <th class="text-center">{{ trans('globals.frequency') }}</th>
							                <th class="text-center">{{ trans('loans.first_payment') }}</th>
							                <th class="text-center">{{ trans('globals.next_payment') }}</th>
							                <th class="text-center">{{ trans('loans.status') }}</th>
							                <th class="text-center">{{ trans('globals.actions') }}</th>
							            </tr>
							        </tfoot>
							        <tbody>
							        	@foreach ($loans as $loan)
								            <tr>
								                <td class="text-center"><a href="{{ ($loan['role'] == 'customer') ? route('customers.edit', [$loan['user_id']]) : route('employees.edit', $loan['user_id']) }}">{{ ucfirst($loan['user']) }}</a></td>
								                <td class="text-right">{{ Utility::numberFormat($loan['amount'], false) }}</td>
								                <td class="text-right">{{ Utility::numberFormat($loan['balance'], false) }}</td>
								                <td class="text-center">{{ Utility::numberFormat($loan['interest_rate'], false) }}&nbsp;%</td>
								                <td class="text-center">{{ ucfirst($loan['frequency']) }}</td>
								                <td class="text-center">{{ Carbon\Carbon::parse($loan['first_payment'])->format('F j, Y') }}</td>
								                <td class="text-center">{{ Carbon\Carbon::parse($loan['next_payment'])->format('F j, Y') }}</td>
								                <td class="text-center"><label class = "{{ trans('globals.loans_payment_status_class.'.$loan['status']) }}">{{ ucfirst($loan['status']) }}</label></td>
								                <td>
													<div class="dropdown">
														<button class="btn btn-default dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
															&nbsp;&nbsp;&nbsp;{{ trans('globals.options') }}&nbsp;&nbsp;&nbsp;
															<span class="caret"></span>
														</button>
														<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">

															<li @if (!$loan['canEdit']) class="disabled" @endif><a href="{{ route('loans.edit', $loan['id']) }}"><i class="glyphicon glyphicon-edit"></i>&nbsp;{{ trans('globals.edit_label') }}</a></li>

															@hasrole('admin,supervisor')
																@if ($loan['status'] != 'process')
																	<li @if (!$loan['canEdit']) class="disabled" @endif><a href="{{ route('loans.status', [$loan['id'], 'process']) }}"><i class="glyphicon glyphicon-ok"></i>&nbsp;{{ trans('globals.approve_label') }}</a></li>
																@endif
																@if ($loan['status'] != 'rejected')
																	<li @if (!$loan['canEdit']) class="disabled" @endif><a href="{{ route('loans.status', [$loan['id'], 'rejected']) }}"><i class="glyphicon glyphicon-trash"></i>&nbsp;{{ trans('globals.reject_label') }}</a></li>
																@endif
															@endhasrole

															@if (($loan['balance'] > 0) && ($loan['status'] == 'process'))
																<li role="separator" class="divider"></li>
																<li><a href="{{ route('payments.add', ['id' => $loan['id']]) }}"><i class="fa fa-credit-card"></i>&nbsp;{{ trans('globals.add_payment') }}</a></li>
																<li><a data-toggle="modal" data-target="#surchargesModal" href="{{ route('surcharges.create', ['loan_id' => $loan['id']]) }}"><i class="glyphicon glyphicon-leaf"></i>&nbsp;{{ trans('globals.add_surcharge') }}</a></li>
															@endif
														</ul>
													</div>
								                </td>
								            </tr>
							            @endforeach
							        </tbody>
							    </table>

							</div> {{-- box-body --}}
						</div> {{-- box box-info --}}
					</div>
				</div>
			@endif
		</div> {{-- col-sm-12 --}}
	</div> {{-- row --}}

	@include('partials.modal', ['id' => 'surchargesModal', 'size' => 'modal-sm'])

@endsection

@include('partials.message')

@section ('jQueryScripts')
<script>
    $(function ()
    {
	    $('#loans_grid').DataTable({
	      "paging": true,
	      "lengthChange": true,
	      "searching": true,
	      "ordering": true,
	      "info": true
	    });

    	$("#birth_date").inputmask("{{ trans('globals.inputmask.date') }}", {"placeholder": "{{ trans('globals.inputmask.date') }}"});

    	$("#homephone_number").inputmask("{{ trans('globals.inputmask.phone_home_mask') }}", {"placeholder": "{{ trans('globals.inputmask.phone_home_placeholder') }}"});

    	$("#cellphone_number").inputmask("{{ trans('globals.inputmask.phone_mask') }}", {"placeholder": "{{ trans('globals.inputmask.phone_placeholder') }}"});

    	$("#role").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			data: {!! json_encode($roles) !!}
		});

    	$("#employeeFrm" ).submit(function( event )
    	{
    		//
		});

    });
</script>
@endsection


