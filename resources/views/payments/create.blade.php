@extends('app')

@section('htmlheader_title')
    {{ trans('globals.section_title.'.($edit?'payments_edit_title':'payments_add_title')) }}
@endsection

@section('contentheader_title')
    {{ trans('globals.section_title.'.($edit?'payments_edit_title':'payments_add_title')) }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ trans('globals.section_title.payments_add_title') }}</li>
@endsection

@section('css_module')
	<link href = "{{ asset('/plugins/iCheck/all.css') }}" rel = "stylesheet" type="text/css" />
@endsection

@include('partials.message')

@section('main-content')

	@if(!$edit)
		{!! Form::model(Request::all(),['route'=>['payments.store'], 'method'=>'POST', 'name'=>'paymentsFrm', 'id'=> 'paymentsFrm', 'role'=>'form']) !!}
    @else
        {!! Form::model($payment, ['route'=>['payments.update', $payment->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'paymentsFrm', 'id' => 'paymentsFrm']) !!}
    @endif

	<div class="row" id="loans_installments">
		<div class="col-sm-12">
			<div class="box">
				<div class="box-header with-border">
					<h4>
						<i class="fa fa-cubes"></i>&nbsp;{{ trans('loans.loans_installments', ['loan' => Utility::codeMasked($loan->id,'CT')]) }}
					</h4>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-sm-12">
							<table id="userInstallmentsListGrid" class="table table-bordered table-hover dataTable" role="grid">
						        <thead>
						            <tr>
						                <th class="text-center">#</th>
						                <th class="text-center">{{ trans('payments.status') }}</th>
						                <th class="text-center">{{ trans('payments.expired_date') }}</th>
						                <th class="text-right">{{ trans('payments.amount') }}</th>
						                <th class="text-right">{{ trans('payments.interest_added') }}</th>
						                <th class="text-right" class="text-right">{{ trans('payments.total_amount') }}</th>
						                <th class="text-center">{{ trans('payments.over_due') }}</th>
						                <th class="text-center">{{ trans('payments.updated_at') }}</th>
						                <th class="text-center">{{ trans('globals.actions') }}</th>
						            </tr>
						        </thead>
						        <tbody id="loans_installments_body">
						        	@foreach ($loan->_installments as $installment)
						        		<?php $_install = $installment->status == 'pending' ? $installment->id : (isset($_install) ? $_install : $installment->id); ?>
							            <tr>
							                <td class="text-center">{{ $installment->installment_num }}</td>
							                <td class="text-center"><label class = "{{ trans('globals.loans_payment_status_class.'.$installment->status) }}">{{ ucfirst($installment->status) }}</label></td>
							                <td class="text-center">{{ Carbon\Carbon::parse($installment->expired_date)->format('F j, Y') }}</td>
							                <td class="text-right">{{ Utility::numberFormat($installment->amount, false) }}</td>
							                <td class="text-right">{{ Utility::numberFormat($installment->interest_amount, false)  }}</td>
							                <td class="text-right">{{ Utility::numberFormat($installment->total_amount, false)  }}</td>
							                <td class="text-center">
											<?php
												$date = strtotime($installment->expired_date);
												if (time() > $date)	{
													echo '<span class="label label-danger">'.trans('globals.yes_label').'</span>';
												} else {
													echo '<span class="label label-primary">'.trans('globals.no_label').'</span>';
												}
											?>
							                </td class="text-center">
							                <td class="text-center">{{ Carbon\Carbon::parse($installment->updated_at)->format('F j, Y') }}</td>
							                <th class="text-center">
							                	@if ((!$edit && $installment->status != 'paid') || (isset($payment) && $payment->type != 'installment' && $installment->status != 'paid'))
							                		<input type="radio" id = "inst_{{ $installment->id }}" name="install-radio" class="minimal" amount = "{{ $installment->total_amount }}" installment = "{{ $installment->id }}" @if (isset($payment) && $payment->installment_id == $installment->id) checked = "checked" @endif >
							               		@else
							               			<i class="glyphicon glyphicon-ban-circle"></i>
							               		@endif
							                </th>
							            </tr>
						            @endforeach
						            <?php $_install = ($edit && isset($payment) && $payment->type == 'payment' && $payment->installment_id != '') ? $payment->installment_id : $_install; ?>
						        </tbody>
					    	</table>
						</div>
					</div>
				</div> {{-- box-body --}}
			</div> {{-- box box-info --}}
		</div> {{-- col-sm-12 --}}
	</div> {{-- row --}}

	<div class="row">
		<div class="col-sm-12">

			<div class="box box-info">
				<div class="box-header with-border"><h4><i class="fa fa-list-alt"></i>&nbsp;{{ trans('payments.payment_summary') }}</h4></div>
				<div class="box-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="row">
								<div class="form-group col-sm-6">
									{!! Form::label('concept', trans('payments.concept')) !!}:
									<select name="concept" id="concept" class="input-sm form-control" @if ($edit) readonly="readonly" @endif >
										@foreach (trans('globals.payments_concepts') as $key => $concept)
											<option value = "{{ $key }}" @if((isset($payment) && $key == $payment->concept) || (!$edit && $key == 'other')) selected="selected" @endif >{{ ucfirst($concept) }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-sm-6" id="paymentTypeLayer" style="display:none">
									{!! Form::label('payment_type', trans('payments.payment_type')) !!}:
									{!! Form::select('payment_type', [], null, ['id' => 'payment_type', 'class' => 'input-sm form-control']); !!}
								</div>
								<div class="form-group col-sm-6" id="surchargesLayer" style="display:none">
									{!! Form::label('surcharges', trans('payments.surcharges')) !!}:
									<select name="surcharges" id="surcharges" class="input-sm form-control">
										@if (isset($surcharges) && $surcharges->count() > 0)
											@foreach ($surcharges as $surcharge)
												<option value="{{ $surcharge->id }}" amount = "{{ $surcharge->amount }}">{{ ucfirst($surcharge->concept).': '.Utility::numberFormat($surcharge->amount, false) }}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-6">
									{!! Form::label('debt_collector', trans('payments.debt_collector')) !!}:
									{!! Form::select('debt_collector', [], null, ['id' => 'debt_collector', 'class' => 'form-control']); !!}
									@if (isset($payment))
										<div class="row">&nbsp;</div>
										<div class="callout callout-info">
											<i class="fa fa-user"></i>&nbsp;{{ $payment->debt_collector->fullName }}
										</div>
									@endif
								</div>
								<div class="form-group col-sm-6">
									{!! Form::label('paymentAmount', trans('payments.total_payment')) !!}:
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
										<input type="text" id="paymentAmount" name="paymentAmount" value="{{ isset($payment) ? Utility::numberFormat($payment->payment, false) : old('paymentAmount') }}" @if (isset($payment) && $payment->concept != 'other') readonly="readonly" @endif class = "input-sm  text-right form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-6">
									{!! Form::label('paymentMethod', trans('payments.method')) !!}:
									{!! Form::select('paymentMethod', trans('globals.payments_methods'), isset($payment) ? $payment->method : old('paymentMethod'), ['id' => 'paymentMethod', 'class' => 'input-sm  form-control']); !!}
								</div>
								<div class="form-group col-sm-6" id="penaltyRateLayer" @if (!$edit) style="display: none" @endif>
									{!! Form::label('penaltyRate', trans('payments.penalty_rate')) !!}:
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" id="penaltyRateCheck" name="penaltyRateCheck" @if (isset($payment->penalty_amount) && $payment->penalty_amount > 0) checked="checked" @endif>
										</span>
										<input type="text" id="penaltyRate" name="penaltyRate" value = "{{ isset($payment) ?  Utility::numberFormat($penaltyAmount > 0 ? $penaltyAmount : $payment->penalty_amount, false) : 0 }}" class="form-control input-sm  text-right" readonly="readonly">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-12">
									{!! Form::label('paymentNotes', trans('payments.notes')) !!}:
									<textarea rows="3" class="form-control" id="paymentNotes" name="paymentNotes">{{ isset($payment) ? $payment->notes : old('paymentNotes') }}</textarea>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="panel panel-warning">
								<div class="panel-heading"><i class="fa fa-cube"></i>&nbsp;{{ trans('globals.loan_info', ['loan' =>  $loan->id]) }}</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-sm-12">
											<h4><i class="fa fa-ellipsis-v"></i>&nbsp;{{ trans('loans.loan_amount') }}:</h4>
											{{ Utility::numberFormat($loan->amount, false) }}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<h4><i class="fa fa-ellipsis-v"></i>&nbsp;{{ trans('loans.loan_interest') }}:</h4>
											{{ Utility::numberFormat($_interet, false) }}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<h4><i class="fa fa-ellipsis-v"></i>&nbsp;{{ trans('loans.total_payment') }}:</h4>
											{{ Utility::numberFormat($_loans_amount, false) }}
										</div>
									</div>
									<div class="row">&nbsp;</div>
									<div class="row">
										<div class="col-sm-12">
											<a href="{{ route('loans.edit', $loan->id) }}"><i class="glyphicon glyphicon-search"></i>&nbsp;{{ trans('globals.see_more') }}</a>
										</div>
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
			</div>
		</div>
	</div>

	<input type = "hidden" name = "loan_id" value = "{{ $loan->id }}">
	<input type = "hidden" name = "edit" value = "{{ $edit }}">
	<input type = "hidden" name = "selected_install" id = "selected_install" value = "{{ $edit ? $payment->installment_id: '' }}">
	<input type = "hidden" name = "selected_surcharge" id = "selected_surcharge" value = "{{ $edit ? $payment->surcharge_id: '' }}">

	{!! Form::token() !!}
	{!! Form::close() !!}
@endsection

@section ('js_module')
	@parent
	<script src = "{{ asset('/js/jquery.number.min.js') }}" type = "text/javascript"></script>
	<script src = "{{ asset('/js/jquery-dateFormat.min.js') }}" type = "text/javascript"></script>
	<script src = "{{ asset('/plugins/iCheck/icheck.min.js') }}" type = "text/javascript"></script>
@endsection

@section ('jQueryScripts')
<script>
    $(function ()
    {
    	$('#paymentAmount, #penaltyRate').number(true, 2, ',', '.');

    	$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_flat-green',
      		radioClass: 'iradio_flat-green'
	    });

	    $('#userInstallmentsListGrid').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true
	    });

    	$("#debt_collector").select2({
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

		@if ($edit && isset($payment) && $payment->type == 'payment')
			paymentTypeOptions();
		@endif

		$('input').on('ifClicked', function(event)
		{
			var that = $(this);

			if ((that).is(':checked')) {
				$(that).iCheck('uncheck');
				$('#selected_install').val('');
				$('#concept').val('payment');
				$('#paymentTypeLayer').fadeOut();
				$('#paymentAmount').removeAttr("readonly");
			} else {
				$('#selected_install').val($(this).attr('installment'));
				$('#concept').val('payment');
				$('#paymentTypeLayer').fadeIn();
				paymentTypeOptions();
			}

			grabPenaltyRate();

		});

		$('#concept').change(function()
		{
			if ($(this).val() == 'surcharge') {

				$('#paymentTypeLayer').hide();
				$('#surchargesLayer').show();
				$('#inst_{{ $_install }}').iCheck('uncheck');
				$('#paymentAmount').val($('option:selected', '#surcharges').attr('amount'));

			}

			if ($(this).val() == 'other') {

				$('#paymentTypeLayer, #surchargesLayer').hide();
				$('#paymentAmount').removeAttr("readonly");
				$('#paymentAmount').val('');
				$('#inst_{{ $_install }}').iCheck('uncheck');
				$('#paymentAmount').focus();

			}

			if ($(this).val() == 'payment') {

				@if ($edit && $payment->installment_id != '')

					$('#selected_install').val('{{ $payment->installment_id  }}');
					$('#paymentAmount').val('{{ $payment->payment }}');
					$('#payment_type').val('{{ $payment->type }}');

				@else

					if ($('#selected_install').val() == '') {

						$('#selected_install').val('{{ $_install }}');
						$('#inst_{{ $_install }}').iCheck('check');
						$('#payment_type').val('installment');

					}

				@endif

				paymentTypeOptions();
				$('#surchargesLayer').hide();
				$('#paymentTypeLayer').show();
				$('#paymentAmount').attr("readonly","readonly");
			}

		});

	    $("#sendFrm").click(function()
		{
			$('#paymentsFrm').submit();
		});

		$('#payment_type').change(function()
		{
			$('#paymentAmount').val($('option:selected', this).attr('amount'));
		});

		$('#surcharges').change(function()
		{
			$('#paymentAmount').val($('option:selected', this).attr('amount'));
		});

		@if ($edit && isset($payment) && $payment->concept == 'payment' && $payment->installment_id != '')

			paymentTypeOptions();
			$('#surchargesLayer').hide();
			$('#paymentTypeLayer').show();
			$('#paymentAmount').attr("readonly","readonly");

		@endif

		function paymentTypeOptions()
		{
			$.ajax({
			  	url: "{{ route('payments.paymentSummary') }}",
			  	method: "POST",
			  	data: { edit: '{{ $edit }}', selected_install: $('#selected_install').val(), loan_id: "{{ $loan->id }}", _token: "{{ csrf_token() }}" },
			  	dataType: 'json',
			}).done(function(data)
			{
				var drop = '';

				if (data['_capital']) {
					drop = '<option value = "capital" amount = "'+data['_capital']+'">{{ trans("globals.payments_type.capital") }}: '+data['capital']+'</option>';
				}

				if (data['_interest']) {
					drop += '<option value = "interest" amount = "'+data['_interest']+'">{{ trans("globals.payments_type.interest") }}: '+data['interest']+'</option>';
				}

				if (data['_installment']) {
					drop += '<option value = "installment" amount = "'+data['_installment']+'" selected>{{ trans("globals.payments_type.installment") }}: '+data['installment']+'</option>';
				}

				if (data['out'] == 'ok')
				{
					$('#payment_type').html(drop);
					$('#paymentAmount').attr("readonly","readonly");

					@if (!$edit)
						//$('#paymentAmount').val(data['_installment']);
						$('#paymentAmount').val($('option:selected', '#payment_type').attr('amount'));
					@else
						$('#payment_type').val('{{ $payment->type }}');
					@endif
			  	}
			});
		}

		function grabPenaltyRate()
		{
			console.log('hey!');

			$.ajax({
			  	url: "{{ route('payments.penaltyRate') }}",
			  	method: "POST",
			  	data: { edit: '{{ $edit }}', selected_install: $('#selected_install').val(), loan_id: "{{ $loan->id }}", _token: "{{ csrf_token() }}" },
			  	dataType: 'json',
			}).done(function(data)
			{
				if (data['hasPenalty'] == 'yes') {

					$('#penaltyRateLayer').show();
					$('#penaltyRate').val(data['penalty_amount']);

				} else {

					$('#penaltyRateLayer').hide();
					$('#penaltyRate').val('');

				}

			});

		}

    });
</script>
@endsection


