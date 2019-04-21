@extends('app')

@section('htmlheader_title')
    {{ trans('globals.section_title.loans_list') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ trans('globals.section_title.loans_list') }}</li>
@endsection

@section('main-content')

	<div class="box">

		<div class="box-header with-border">
			<h4 class="pull-left">
				<i class="fa fa-th"></i>&nbsp;{{ trans('globals.section_title.loans_list') }}
			</h4>
			<a href="{{ route('loans.create') }}" class="btn btn-sm btn-success pull-right">
				<span class="fa fa-plus-square"></span>&nbsp;{{ trans('globals.add_new') }}&nbsp;{{ trans('globals.loans') }}
			</a>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-sm-12">
					<table id="holydays_grid" class="table table-bordered table-hover dataTable" role="grid" cellspacing="0" width="100%">
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
				        	@foreach ($data as $loan)
					            <tr>
					                <td class="text-center"><a href="{{ ($loan['role'] == 'customer') ? route('customers.edit', [$loan['user_id'], '1']) : route('employees.edit', $loan['user_id']) }}">{{ ucfirst($loan['user']) }}</a></td>
					                <td class="text-right">{{ Utility::numberFormat($loan['amount'], false) }}</td>
					                <td class="text-right">{{ Utility::numberFormat($loan['balance'], false) }}</td>
					                <td class="text-center">{{ Utility::numberFormat($loan['interest_rate'], false) }}&nbsp;%</td>
					                <td class="text-center">{{ ucfirst($loan['frequency']) }}</td>
					                <td class="text-center">{{ Carbon\Carbon::parse($loan['first_payment'])->format('F j, Y') }}</td>
					                <td class="text-center">{{ ($loan['balance'] > 0) ? Carbon\Carbon::parse($loan['next_payment'])->format('F j, Y') : '' }}</td>
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
													@if ($loan['status'] != 'paid')
														@if ($loan['status'] != 'process')
															<li @if (!$loan['canEdit']) class="disabled" @endif><a href="{{ route('loans.status', [$loan['id'], 'process']) }}"><i class="glyphicon glyphicon-ok"></i>&nbsp;{{ trans('globals.approve_label') }}</a></li>
														@endif
														@if ($loan['status'] != 'rejected')
															<li @if (!$loan['canEdit']) class="disabled" @endif><a href="{{ route('loans.status', [$loan['id'], 'rejected']) }}"><i class="glyphicon glyphicon-trash"></i>&nbsp;{{ trans('globals.reject_label') }}</a></li>
														@endif
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
				</div>
			</div>
		</div>
	</div>

	@include('partials.modal', ['id' => 'surchargesModal', 'size' => 'modal-sm'])

@endsection

@include('partials.message')

@section ('jQueryScripts')
	<script>
        $(function () {
            $(document).ready(function() {
			    $('#holydays_grid').DataTable({
			      "paging": true,
			      "lengthChange": true,
			      "searching": true,
			      "ordering": true,
			      "info": true
			    });
			});
        });
    </script>
@endsection
