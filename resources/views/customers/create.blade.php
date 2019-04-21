@extends('app')

@section('htmlheader_title')
    {{ ($edit) ? trans('globals.section_title.customers_edit') : trans('globals.section_title.customers_add') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ ($edit) ? trans('globals.section_title.customers_edit') : trans('globals.section_title.customers_add') }}</li>
@endsection

@section('main-content')

	<div class="box">
		<div class="box-header with-border">
			<h4>
				@if ($edit)
					<i class="fa fa-pencil-square-o"></i>&nbsp;{{ trans('globals.section_title.customers_edit') }}
				@else
					<i class="fa fa-plus-square"></i>&nbsp;{{ trans('globals.section_title.customers_add') }}
				@endif
			</h4>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="wizard">
			            <div class="wizard-inner">
			                <div class="connecting-line"></div>
			                <ul class="nav nav-tabs" role="tablist">

			                    <li role="presentation" class="@if($step=='1') active @endif step1">
			                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="{{ trans('globals.section_title.customers_step1_1') }}">
			                            <span class="round-tab">
			                                <i class="glyphicon glyphicon-user"></i>
			                            </span>
			                        </a>
			                    </li>

			                    <li role="presentation" class="@if($step=='2') active @else @if (!$edit) disabled @endif @endif step2">
			                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="{{ trans('globals.section_title.customers_step2_1') }}">
			                            <span class="round-tab">
			                                <i class="fa fa-briefcase"></i>
			                            </span>
			                        </a>
			                    </li>
			                    <li role="presentation" class="@if($step=='3') active @else @if (!$edit) disabled @endif @endif step3">
			                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="{{ trans('globals.section_title.customers_step3_1') }}">
			                            <span class="round-tab">
			                                <i class="fa fa-group"></i>
			                            </span>
			                        </a>
			                    </li>
			                    <li role="presentation" class="@if($step=='4') active @else @if (!$edit) disabled @endif @endif step4">
			                        <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab" title="{{ trans('globals.section_title.customers_step4_1') }}">
			                            <span class="round-tab">
			                                <i class="fa fa-folder"></i>
			                            </span>
			                        </a>
			                    </li>
			                </ul>
			            </div>
		                <div class="tab-content">
		                    <div class="tab-pane active" role="tabpanel" id="step1">
			                    @if(!$edit)
									{!! Form::model(Request::all(),['route'=>['customers.store'], 'method'=>'POST', 'name'=>'customer_step1', 'id'=> 'customer_step1', 'role'=>'form', 'files' => true]) !!}
								@else
								    {!! Form::model($customers, ['route'=>['customers.update',$customers->user_id], 'method'=>'PUT', 'role'=>'form', 'name' => 'customer_step1', 'id' => 'customer_step1', 'files' => true]) !!}
								@endif
								{!! Form::hidden('step', '1') !!}
		                        <div class="col-sm-6">

									<div class="box box-info">
										<div class="box-header with-border">
											<i class="fa fa-user"></i>&nbsp;{{ trans('globals.section_title.customers_step1_1') }}
										</div>
										<div class="box-body">

											@include('customers.partials.step1_1')

										</div>{{-- box-body --}}
									</div>{{-- box box-info --}}

		                        </div>
		                        <div class="col-sm-6">
									<div class="box box-info">
										<div class="box-header with-border">
											<i class="fa fa-user"></i>&nbsp;{{ trans('globals.section_title.customers_step1_2') }}
										</div>
										<div class="box-body">

											@include('customers.partials.step1_2')

										</div>{{-- box-body --}}
									</div>{{-- box box-info --}}

									<ul class="list-inline pull-right">
			                            <li>
			                            	<button type="button" class="btn btn-primary next-step" onclick="$('#customer_step1').submit();">
			                            		<i class="fa fa-paper-plane-o"></i>&nbsp;{{ trans('globals.submit_continue') }}
			                            	</button>
			                            </li>
			                        </ul>
		                        </div>
		                        {!! Form::token() !!}
								{!! Form::close() !!}
		                    </div>


		                    <div class="tab-pane" role="tabpanel" id="step2">
		                    	@if(!$edit)
									{!! Form::model(Request::all(),['route'=>['customers.store'], 'method'=>'POST', 'name'=>'customer_step2', 'id'=> 'customer_step2', 'role'=>'form']) !!}
								@else
								    {!! Form::model($customers, ['route'=>['customers.update',$customers->user_id], 'method'=>'PUT', 'role'=>'form', 'name' => 'customer_step2', 'id' => 'customer_step2']) !!}
								@endif
								{!! Form::hidden('step', '2') !!}
		                        <div class="col-sm-6">

									<div class="box box-warning">
										<div class="box-header with-border">
											<i class="fa fa-user"></i>&nbsp;{{ trans('globals.section_title.customers_step2_1') }}
										</div>
										<div class="box-body">

											@include('customers.partials.step2_1')

										</div>{{-- box-body --}}
									</div>{{-- box box-info --}}

		                        </div>
		                        <div class="col-sm-6">
									<div class="box box-warning">
										<div class="box-header with-border">
											<i class="fa fa-user"></i>&nbsp;{{ trans('globals.section_title.customers_step2_2') }}
										</div>
										<div class="box-body">

											@include('customers.partials.step2_2')

										</div>{{-- box-body --}}
									</div>{{-- box box-warning --}}

									<ul class="list-inline pull-right">
										<li><button type="button" class="btn btn-default prev-step">{{ trans('globals.previous') }}</button></li>
			                            <li>
			                            	<button type="button" class="btn btn-primary next-step" id="sendStep2">
			                            		<i class="fa fa-paper-plane-o"></i>&nbsp;{{ trans('globals.submit_continue') }}
			                            	</button>
			                            </li>
			                        </ul>
		                        </div>
		                        {!! Form::token() !!}
								{!! Form::close() !!}

		                    </div>
		                    <div class="tab-pane" role="tabpanel" id="step3">
		                    	@if(!$edit)
									{!! Form::model(Request::all(),['route'=>['customers.store'], 'method'=>'POST', 'name'=>'customer_step3', 'id'=> 'customer_step3', 'role'=>'form']) !!}
								@else
								    {!! Form::model($customers, ['route'=>['customers.update',$customers->user_id], 'method'=>'PUT', 'role'=>'form', 'name' => 'customer_step3', 'id' => 'customer_step3']) !!}
								@endif
								{!! Form::hidden('step', '3') !!}
		                        <div class="col-sm-6">
		                        	<div class="box box-danger">
										<div class="box-header with-border">
											<i class="fa fa-group"></i>&nbsp;{{ trans('globals.section_title.customers_step3_1') }}
										</div>
										<div class="box-body">

											@include('customers.partials.step3_1')

										</div>{{-- box-body --}}
									</div>{{-- box box-danger --}}

			                    </div>
								<div class="col-sm-6">
									<div class="box box-danger">
										<div class="box-header with-border">
											<i class="fa fa-user"></i>&nbsp;{{ trans('globals.section_title.customers_step3_2') }}
										</div>
										<div class="box-body">

											@include('customers.partials.step3_2')

										</div>{{-- box-body --}}
									</div>{{-- box box-danger --}}

									<ul class="list-inline pull-right">
										<li><button type="button" class="btn btn-default prev-step">{{ trans('globals.previous') }}</button></li>
			                            <li>
			                            	<button type="button" class="btn btn-primary next-step" onclick="$('#customer_step3').submit();">
			                            		<i class="fa fa-paper-plane-o"></i>&nbsp;{{ trans('globals.submit_continue') }}
			                            	</button>
			                            </li>
			                        </ul>
		                        </div>
		                        {!! Form::token() !!}
								{!! Form::close() !!}
		                    </div>
		                    <div class="tab-pane" role="tabpanel" id="step4">
		                    	@if(!$edit)
									{!! Form::model(Request::all(),['route'=>['customers.store'], 'method'=>'POST', 'name'=>'customer_step4', 'id'=> 'customer_step4', 'role'=>'form', 'files' => true]) !!}
								@else
								    {!! Form::model($customers, ['route'=>['customers.update',$customers->user_id], 'method'=>'PUT', 'role'=>'form', 'name' => 'customer_step4', 'id' => 'customer_step4', 'files' => true]) !!}
								@endif
								{!! Form::hidden('step', '4') !!}
								{!! Form::hidden('document_id', isset($document->id) ? $document->id : null) !!}
		                        <div class="col-sm-6">
		                        	<div class="box box-warning">
										<div class="box-header with-border">
											<i class="fa fa-folder"></i>&nbsp;{{ trans('globals.section_title.customers_step4_1') }}
										</div>
										<div class="box-body">

											@include('customers.partials.step4_1')

										</div>{{-- box-body --}}
									</div>{{-- box box-warning --}}
			                        <ul class="list-inline">
			                            <li>
			                            	<button type="button" class="btn btn-success next-step" onclick="$('#customer_step4').submit();">
			                            		<i class="fa fa-paper-plane-o"></i>&nbsp;{{ trans('globals.save') }}
			                            	</button>
			                            </li>
			                        </ul>
			                    </div>
			                    <div class="col-sm-6">
		                        	<div class="box box-warning">
										<div class="box-header with-border">
											<i class="fa fa-folder"></i>&nbsp;{{ trans('globals.section_title.customers_step4_2') }}
										</div>
										<div class="box-body">

											@include('customers.partials.documents')

										</div>{{-- box-body --}}
									</div>{{-- box box-warning --}}
			                        <ul class="list-inline pull-right">
			                            <li><button type="button" class="btn btn-default prev-step">{{ trans('globals.previous') }}</button></li>
			                            <li>
				                            <a href="{{ route('customers.index') }}" class="btn btn-primary next-step">
												<span class="fa fa-paper-plane-o"></span>&nbsp;{{ trans('globals.finish') }}
											</a>
			                            </li>
			                        </ul>
			                    </div>
			                    {!! Form::token() !!}
								{!! Form::close() !!}
		                    </div>
		                    <div class="clearfix"></div>
		                </div>
	        		</div>
				</div>
			</div>
        </div> {{-- body --}}
   	</div>

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
							            	<th class="text-center">{{ trans('globals.loans') }}</th>
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
							            	<th class="text-center">{{ trans('globals.loans') }}</th>
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
								            	<td class="text-center"><a href="{{ route('loans.edit', [$loan['id']]) }}">{{ \Utility::codeMasked($loan['id'],'CT') }}</a></td>
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

@section ('js_module')
	@parent
	<script src = "{{ asset('/js/jquery.number.min.js') }}" type = "text/javascript"></script>
@endsection

@section ('jQueryScripts')
<script>
    $(function ()
    {

		$("#bank_id").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			ajax: {
				url: "{{ route('search.banks') }}",
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

		$("#city_id").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			ajax: {
				url: "{{ route('search.cities') }}",
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

		$("#company_city_id").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			ajax: {
				url: "{{ route('search.cities') }}",
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

		$("#reference_city_id").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			ajax: {
				url: "{{ route('search.cities') }}",
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

		$("#eps").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			data: {!! json_encode($eps) !!}
		});

		$("#contract_type").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			data: {!! json_encode($contract_type) !!}
		});

		$("#company_affiliation_type").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			data: {!! json_encode($affiliation_type) !!}
		});

		$("#reference_type").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			data: {!! json_encode($references_type) !!}
		});

		$("#reference_relationship").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			data: {!! json_encode($relationships) !!}
		});

		$("#document_type").select2({
			placeholder: '{{ trans("globals.select") }}',
			theme: "classic",
			data: {!! json_encode($document_type) !!}
		});

		$("#contract_type").change(function() {
			var $obj = $(".contract_temporary");
			($(this).val() != "temporary") ? $obj.hide() : $obj.show();
		});

	    //Initialize tooltips
	    $('.nav-tabs > li a[title]').tooltip();

	    //Wizard
	    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

	        var $target = $(e.target);

	        if ($target.parent().hasClass('disabled')) {
	            return false;
	        }
	    });

	    $(".prev-step").click(function (e) {

	        var $active = $('.wizard .nav-tabs li.active');
	        prevTab($active);

	    });

	    //application of DataTable to the grid of loans
	    $('#gridLoansCustomer').DataTable({
	      "paging": true,
	      "lengthChange": true,
	      "searching": true,
	      "ordering": true,
	      "info": true,
	      "autoWidth": true
	    });

	    //MaskInputs
	    $("#birth_date").inputmask("{{ trans('globals.inputmask.date') }}", {"placeholder": "{{ trans('globals.inputmask.date') }}"});
	    $("#company_time_worked").inputmask("{{ trans('globals.inputmask.date') }}", {"placeholder": "{{ trans('globals.inputmask.date') }}"});
    	$("#homephone_number").inputmask("{{ trans('globals.inputmask.phone_home_mask') }}", {"placeholder": "{{ trans('globals.inputmask.phone_home_placeholder') }}"});
    	$("#cellphone_number").inputmask("{{ trans('globals.inputmask.phone_mask') }}", {"placeholder": "{{ trans('globals.inputmask.phone_placeholder') }}"});
    	$("#company_salary").number(true, 2, ',', '.');
    	//$("#_company_salary").inputmask("{{ trans('globals.inputmask.amount') }}", { numericInput: true });
    	$("#company_landphone").inputmask("{{ trans('globals.inputmask.phone_mask') }}", {"placeholder": "{{ trans('globals.inputmask.phone_placeholder') }}"});
    	$("#company_cellphone").inputmask("{{ trans('globals.inputmask.phone_mask') }}", {"placeholder": "{{ trans('globals.inputmask.phone_placeholder') }}"});
    	$("#reference_landphone").inputmask("{{ trans('globals.inputmask.phone_mask') }}", {"placeholder": "{{ trans('globals.inputmask.phone_placeholder') }}"});
    	$("#reference_cellphone").inputmask("{{ trans('globals.inputmask.phone_mask') }}", {"placeholder": "{{ trans('globals.inputmask.phone_placeholder') }}"});

    	//Activar tab segun step
		var $active = $('.wizard .nav-tabs li.step{{ $step-1 }}');
		$active.next().removeClass('active');
		nextTab($active);

		//Update div Contract type
		$("#contract_type").change();

		//Send Form
		$("#sendStep2").click(function() {
			//$('#company_salary').val($('#_company_salary').val());
			$('#customer_step2').submit();
		});
    });

    function nextTab(elem) {
	    $(elem).next().find('a[data-toggle="tab"]').click();
	}
	function prevTab(elem) {
	    $(elem).prev().find('a[data-toggle="tab"]').click();
	}

</script>
@endsection


