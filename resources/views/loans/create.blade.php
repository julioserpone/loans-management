@extends('app')

@section('css_module')
	@parent
	<link href = "{{ asset('/gocanto-bower/fullcalendar/dist/fullcalendar.min.css') }}" rel = "stylesheet" type="text/css" />
@endsection

@section('htmlheader_title')
    {{ trans('globals.section_title.request_loan') }}
@endsection

@section('contentheader_title')
    {{ trans('globals.section_title.request_loan') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ trans('globals.section_title.request_loan') }}</li>
@endsection

@include('partials.message')

@section('main-content')
	<div class="row">
		@if(!$edit)
			{!! Form::model(Request::all(),['route'=>['loans.store'], 'method'=>'POST', 'name'=>'loansFrm', 'id'=> 'loansFrm', 'role'=>'form']) !!}
        @else
            {!! Form::model($loan, ['route'=>['loans.update', $loan->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'loansFrm', 'id' => 'loansFrm']) !!}
        @endif

		<div class="col-sm-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h4>
						<i class="fa fa-cube"></i>&nbsp;{{ trans('globals.section_title.request_loan_descrip_01') }}

					</h4>
					@if (isset($loan) && $edit)
						<a href="javascript:void(0)" id="see_installments"><i class="glyphicon glyphicon-search"></i>&nbsp;{{ trans('globals.section_title.see_installments') }}</a>
						&nbsp;|&nbsp;
						<a href="{{ route('payments.add', ['id' => $loan->id]) }}"><i class="fa fa-credit-card"></i>&nbsp;{{ trans('globals.add_payment') }}</a>
						&nbsp;|&nbsp;
						<a data-toggle="modal" data-target="#surchargesModal" href="{{ route('surcharges.create', ['loan_id' => $loan->id]) }}"><i class="glyphicon glyphicon-leaf"></i>&nbsp;{{ trans('globals.add_surcharge') }}</a>
					@endif
				</div>

				<div class="box-body">

					<div class="col-sm-6">

						<div class="row">
							<div class="form-group col-sm-12">
								{!! Form::label('user', trans('globals.employee_customer')) !!}
								@if ($edit)
									{!! Form::text('user',  ucfirst($loan->user->first_name.' '.$loan->user->last_name), ['class' => 'form-control', 'readonly']) !!}
								@else
									{!! Form::select('user', [], null, ['id' => 'user', 'class' => 'form-control select2']); !!}
								@endif
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								{!! Form::label('amount', trans('loans.amount')) !!}
								<div class="input-group">
									<div class="input-group-addon">
										<i class="glyphicon glyphicon-usd"></i>
									</div>
									{!! Form::text('_amount', isset($loan) && $loan->amount ? Utility::numberFormat($loan->amount, false) : old('_amount'), ['id' => '_amount', 'class' => 'text-right form-control', (isset($loan) && ($loan->status == 'paid' || $loan->status == 'process')) ? 'readonly' : '']) !!}
									{!! Form::hidden('amount', isset($loan) && $loan->amount ? $loan->amount : old('_amount')) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								{!! Form::label('interest_rate', trans('loans.interest_rate')) !!}
								<div class="input-group">
									{!! Form::text('_interest_rate', isset($loan) && $loan->interest_rate ? Utility::numberFormat($loan->interest_rate, false) : old('_interest_rate'), ['id' => '_interest_rate', 'class' => 'text-right form-control', (isset($loan) && ($loan->status == 'paid' || $loan->status == 'process')) ? 'readonly' : '']) !!}
									<div class="input-group-addon">
										<strong>%</strong>
									</div>
								</div>
								{!! Form::hidden('interest_rate', isset($loan) && $loan->interest_rate ? Utility::numberFormat($loan->interest_rate, false) : old('_interest_rate') ) !!}
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								{!! Form::label('payment_freq', trans('loans.payment_freq')) !!}
								{!! Form::select('payment_freq', $paymentsFreq, isset($loan) && $loan->payment_freq_id ? $loan->payment_freq_id : old('payment_freq'), ['class' => 'form-control']); !!}
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								{!! Form::label('installments', trans('loans.installments')) !!}
								{!! Form::text('installments', isset($loan) && $loan->installments ? $loan->installments : old('installments'), ['id' => 'installments', 'class' => 'text-right form-control', 'maxlength' => '2', (isset($loan) && ($loan->status == 'paid' || $loan->status == 'process')) ? 'readonly' : '']) !!}
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								{!! Form::label('first_payment', trans('loans.first_payment')) !!}
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									{!! Form::text('first_payment', isset($loan) && $loan->first_payment ? Carbon\Carbon::parse($loan->first_payment)->format('d-m-Y') : old('first_payment'), ['class' => 'form-control']) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								<div id="calendar"></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								{!! Form::label('penalty_rate', trans('loans.penalty_rate')) !!}
								{!! Form::text('_penalty_rate', isset($loan) && $loan->penalty_rate ? $loan->penalty_rate : old('_penalty_rate'), ['id' => '_penalty_rate', 'class' => 'text-right form-control', (isset($loan) && ($loan->status == 'paid' || $loan->status == 'process')) ? 'readonly' : '']) !!}
								{!! Form::hidden('penalty_rate',  isset($loan) && $loan->penalty_rate ? $loan->penalty_rate : old('_penalty_rate')) !!}
							</div>
						</div>
						@if ($edit)
							@hasrole('admin,supervisor')
								<div class="row">
									<div class="form-group col-sm-12">
										{!! Form::label('status', trans('loans.status')) !!}
										{!! Form::select('status', $status, $loan->status, ['class' => 'form-control', ($loan->status == 'paid' || $loan->status == 'process') ? 'readonly' : '']); !!}
									</div>
								</div>
							@endhasrole
						@endif

					</div>

					<div class="col-sm-6">

						<div class="row">&nbsp;</div>
						<div class="row">&nbsp;</div>
						<div class="row">&nbsp;</div>

						{{-- Loans Amount --}}
						<div class="row">
							<div class="col-sm-8 pull-right">
								<div class="info-box bg-aqua">
									<span class="info-box-icon">
										<i class="fa fa-money"></i>
									</span>
									<div class="info-box-content">
										<span class="info-box-text">{{ trans('loans.loan_amount') }}</span>
										<span class="info-box-number" id="loan_amount">{{ Utility::numberFormat(isset($loan) ? $loan->amount : 0, false) }}</span>
									</div>
								</div>
							</div>
						</div>

						{{-- Loans Interest --}}
						<?php $_interet =  isset($loan) ? ($loan->amount * $loan->interest_rate / 100) : 0; ?>
						<div class="row">
							<div class="col-sm-8 pull-right">
								<div class="info-box bg-yellow">
									<span class="info-box-icon">
										<i class="fa fa-money"></i>
									</span>
									<div class="info-box-content">
										<span class="info-box-text">{{ trans('loans.loan_interest') }}</span>
										<span class="info-box-number" id="loan_interest">{{ Utility::numberFormat($_interet, false) }}</span>
									</div>
								</div>
							</div>
						</div>

						{{-- Loans Amount --}}
						<div class="row">
							<div class="col-sm-8 pull-right">
								<div class="info-box bg-green">
									<span class="info-box-icon">
										<i class="fa fa-money"></i>
									</span>
									<div class="info-box-content">
										<span class="info-box-text">{{ trans('loans.total_payment') }}</span>
										<span class="info-box-number" id="loan_total">{{ Utility::numberFormat(isset($loan) ? $loan->amount + $_interet : 0, false) }}</span>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div> {{-- box-body --}}

				<div class="box-footer">
					<button type="button" class="btn btn-success" id="sendFrm">
						<i class="fa fa-paper-plane-o"></i>&nbsp;
						{{ trans('globals.submit') }}
					</button>
				</div> {{-- box-footer --}}
			</div> {{-- box box-info --}}

		</div> {{-- col-sm-6 --}}
		{!! Form::token() !!}
		{!! Form::close() !!}
	</div> {{-- row --}}

	{{-- Installments Grid --}}
	<div class="row">
		<div class="col-sm-12">
			@if (isset($loan) && $edit && $loan->_installments->count() > 0)
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h4>
									<i class="fa fa-th"></i>&nbsp;{{ trans('globals.section_title.request_loan_descrip_03') }}
								</h4>
							</div>
							<div class="box-body">
								<table id="installments_grid" class="table table-bordered table-hover dataTable" role="grid" cellspacing="0" width="100%">
							        <thead>
							            <tr>
							                <th class="text-center">#</th>
							                <th class="text-center">{{ trans('loans.installment.status') }}</th>
							                <th class="text-right">{{ trans('loans.installment.due_date') }}</th>
							                <th class="text-right">{{ trans('loans.installment.amount') }}</th>
							                <th class="text-right">{{ trans('globals.interest') }}</th>
							                <th class="text-right">{{ trans('globals.total') }}</th>
							                <th class="text-center">{{ trans('globals.created_at') }}</th>
							                <th class="text-center">{{ trans('globals.updated_at') }}</th>
							                <th class="text-center">{{ trans('globals.actions') }}</th>
							            </tr>
							        </thead>
							        <tbody>
							        	@foreach ($loan->_installments as $installment)
								            <tr>
								                <td class="text-center">{{ $installment->installment_num }}</td>
								                <td class="text-center"><label class = "{{ trans('globals.loans_payment_status_class.'.$installment->status) }}">{{ ucfirst($installment->status) }}</label></td>
								                <td class="text-right">{{ Carbon\Carbon::parse($installment->expired_date)->format('F j, Y') }}</td>
								                <td class="text-right">{{ Utility::numberFormat($installment->amount, false) }}</td>
								                <td class="text-right">{{ Utility::numberFormat($installment->interest_amount, false) }}</td>
								                <td class="text-right">{{ Utility::numberFormat($installment->total_amount, false) }}</td>
								                <td class="text-center">{{ Carbon\Carbon::parse($installment->created_at)->format('F j, Y') }}</td>
								                <td class="text-center">{{ Carbon\Carbon::parse($installment->updated_at)->format('F j, Y') }}</td>
								                <td class="text-center">
								                	@if ($installment->status =='pending')
					                					<a class="btn btn-danger btn-xs" href="#" onclick="bootbox.confirm('{{ trans('validation.secure_delete_installment') }}', function(result) { if (result) window.location.href = '{{ route('installments.delete',$installment->id) }}'; }); return false;"><i class="glyphicon glyphicon-trash"></i></a>
								                	@else
														<i class="fa fa-check-square-o"></i>
								                	@endif
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

	{{-- Surcharges Grid --}}
	<div class="row">
		<div class="col-sm-12">
			@if (isset($surcharges) && $edit && $surcharges->count() > 0)
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h4>
									<i class="fa fa-th"></i>&nbsp;{{ trans('globals.section_title.surcharges_list') }}
								</h4>
							</div>
							<div class="box-body">
								<table id="surcharges_grid" class="table table-bordered table-hover dataTable" role="grid" cellspacing="0" width="100%">
							        <thead>
							            <tr>
							                <th class="text-center">{{ trans('globals.create_by') }}</th>
							                <th class="text-center">{{ trans('loans.surcharges_concept') }}</th>
							                <th class="text-right">{{ trans('loans.surcharges_amount') }}</th>
							                <th class="text-center">{{ trans('globals.created_at') }}</th>
							                <th class="text-center">{{ trans('globals.updated_at') }}</th>
							                <th class="text-center">{{ trans('globals.status') }}</th>
							                <th class="text-center">{{ trans('globals.actions') }}</th>
							            </tr>
							        </thead>
							        <tfoot>
							            <tr>
							                <th class="text-center">{{ trans('globals.create_by') }}</th>
							                <th class="text-center">{{ trans('loans.surcharges_concept') }}</th>
							                <th class="text-right">{{ trans('loans.surcharges_amount') }}</th>
							                <th class="text-center">{{ trans('globals.created_at') }}</th>
							                <th class="text-center">{{ trans('globals.updated_at') }}</th>
							                <th class="text-center">{{ trans('globals.status') }}</th>
							                <th class="text-center">{{ trans('globals.actions') }}</th>
							            </tr>
							        </tfoot>
							        <tbody>
							        	@foreach ($surcharges as $surcharge)
								            <tr>
								                <td class="text-center"><a href="{{ ($surcharge->user->role == 'customer') ? route('customers.edit', [$surcharge->user->id]) : route('employees.edit', $surcharge->user->id) }}">{{ ucfirst($surcharge->user->fullname) }}</a></td>
								                <td class="text-center">{{ ucfirst($surcharge->concept) }}</td>
								                <td class="text-right">{{ Utility::numberFormat($surcharge->amount, false) }}</td>
								                <td class="text-center">{{ Carbon\Carbon::parse($surcharge->created_at)->format('F j, Y') }}</td>
								                <td class="text-center">{{ Carbon\Carbon::parse($surcharge->updated_at)->format('F j, Y') }}</td>
								                <td class="text-center"><span class="label label-{{ $surcharge->status == 'paid' ? 'success' : 'primary' }}">{{ ucfirst($surcharge->status) }}</span></td>
								                <td class="text-center">
													<a  data-toggle="modal" data-target="#surchargesModal" href="{{ route('surcharges.edit', $surcharge->id) }}" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
								                	@hasrole('admin,supervisor')
								                		<a class="btn btn-danger btn-xs" href="#" onclick="bootbox.confirm('{{ trans('validation.secure_delete_surcharge') }}', function(result) { if (result) window.location.href = '{{ route('surcharges.delete',$surcharge->id) }}'; }); return false;"><i class="glyphicon glyphicon-trash"></i></a>
													@endhasrole
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

@section ('js_module')
	@parent
	<script src = "{{ asset('/js/jquery.number.min.js') }}" type = "text/javascript"></script>
	<script src = "{{ asset('/gocanto-bower/pnotify/pnotify.confirm.js') }}" type = "text/javascript"></script>
	<script src = "{{ asset('/gocanto-bower/moment/moment.js') }}" type = "text/javascript"></script>
	<script src = "{{ asset('/gocanto-bower/fullcalendar/dist/fullcalendar.min.js') }}" type = "text/javascript"></script>
	<script src = "{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type = "text/javascript"></script>
@endsection

@section ('jQueryScripts')
<script>
    $(function ()
    {
		$('#_amount, #_interest_rate, #_penalty_rate').number(true, 2, ',', '.');
		//$("#first_payment").inputmask("{{ trans('globals.inputmask.date') }}", {"placeholder": "{{ trans('globals.inputmask.date') }}"});

    	@if (!$edit)
	    	$("#user").select2({
			  placeholder: '{{ trans("globals.select") }}',
			  theme: "classic",
			  ajax: {
			    url: "{{ route('search.users') }}",
			    dataType: 'json',
			    type: "GET",
			    delay: 400,
			    data: function(params) {
	                return {
	                    q: params.term
	                }
	            },
	            processResults: function (data, page) {
	              return {
	                results: data
	              };
	            },
			  }
			});
		@else
			$('#installments_grid').DataTable({
		      "paging": true,
		      "lengthChange": true,
		      "searching": true,
		      "ordering": true,
		      "info": true,
		      "autoWidth": true
		    });
		@endif

		$("#sendFrm").click(function() {
			$('#amount').val($('#_amount').val());
			$('#interest_rate').val($('#_interest_rate').val());
			$('#penalty_rate').val($('#_penalty_rate').val());
			$('#loansFrm').submit();
		});

		$("#see_installments").click(function() {
			$('html, body').animate({ scrollTop: $("#installments_grid").offset().top }, 'slow');
		});

		$("#_amount").keyup(function(){
			amount = $(this).val();
			$('#loan_amount').number(amount, 2, ',', '.');
		});

		$("#_interest_rate").keyup(function(){
			amount = $("#_amount").val();
			interest = amount * $(this).val() / 100;
			$('#loan_interest').number(interest, 2, ',', '.');
			$('#loan_total').number(Number(amount) + Number(interest), 2, ',', '.');
		});

		$('input[name="first_payment"]').daterangepicker({
			minDate: moment().format('MM-DD-YYYY'),
	        singleDatePicker: true,
	        showDropdowns: true
	        }, 
		    function(start, end, label) {
		    	$("#first_payment").val(start.format('DD-MM-YYYY'));
		    }
		);
	    
		/*$('#calendar').fullCalendar({
			header: {
				left: 'prevYear, nextYear',
				center: 'title'
			},
			weekends: false,
			dayClick: function(date, jsEvent, view) {

				$(this).css('background-color', '#FAFAFA');

				$("#first_payment").val(date.format('DD MM YYYY'));

		    }
		});*/

    });
</script>
@endsection


