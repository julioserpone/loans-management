@extends('app')

@section('htmlheader_title')
    {{ trans('globals.section_title.payments_list') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ trans('globals.section_title.payments_list') }}</li>
@endsection

@section('main-content')

	<div class="box">

		<div class="box-header with-border">
			<h4 class="pull-left">
				<i class="fa fa-th"></i>&nbsp;{{ trans('globals.section_title.payments_list') }}
			</h4>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-sm-12">
					<table id="payments_grid" class="table table-bordered table-hover dataTable" role="grid" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th class="text-center">{{ trans('payments.customer') }}</th>
				                <th class="text-center">{{ trans('globals.loans') }}</th>
				                <th class="text-center">{{ trans('payments.loan_amount') }}</th>
				                <th class="text-center">{{ trans('payments.loans_balance') }}</th>
				                <th class="text-center">{{ trans('payments.payment_date') }}</th>
				                <th class="text-center">{{ trans('payments.payment_amount') }}</th>
				                <th class="text-center">{{ trans('payments.payment_method') }}</th>
				                <th class="text-center">{{ trans('payments.payment_type') }}</th>
				                <th class="text-center">{{ trans('payments.concept') }}</th>
				                <th class="text-center">{{ trans('globals.actions') }}</th>
				            </tr>
				        </thead>
				        <tfoot>
				            <tr>
				                <th class="text-center">{{ trans('payments.customer') }}</th>
				                <th class="text-center">{{ trans('globals.loans') }}</th>
				                <th class="text-center">{{ trans('payments.loan_amount') }}</th>
				                <th class="text-center">{{ trans('payments.loans_balance') }}</th>
				                <th class="text-center">{{ trans('payments.payment_date') }}</th>
				                <th class="text-center">{{ trans('payments.payment_amount') }}</th>
				                <th class="text-center">{{ trans('payments.payment_method') }}</th>
				                <th class="text-center">{{ trans('payments.payment_type') }}</th>
				                <th class="text-center">{{ trans('payments.concept') }}</th>
				                <th class="text-center">{{ trans('globals.actions') }}</th>
				            </tr>
				        </tfoot>
				        <tbody>
				        	@foreach ($data as $payment)
								<tr>
					                <td class="text-center">{{ ucfirst($payment['user']) }}</td>
					                <td class="text-center"><a href="{{ route('loans.edit', [$payment['loan_id']]) }}">{{ \Utility::codeMasked($payment['loan_id'],'CT') }}</a></td>
					                <td class="text-right">{{ \Utility::numberFormat($payment['loan_amount'], false) }}</td>
					                <td class="text-right">{{ \Utility::numberFormat($payment['balance'], false) }}</td>
					                <td class="text-center">{{ Carbon\Carbon::parse($payment['created_at'])->format('F j, Y') }}</td>
					                <td class="text-right">{{ \Utility::numberFormat($payment['payment_amount'], false) }}</td>
					                <td class="text-center">{{ ucfirst($payment['method']) }}</td>
				                	<td class="text-center">{{ $payment['concept'] == 'payment' ? trans('globals.payments_type.'.$payment['type']) : trans('globals.payments_concepts.'.$payment['concept']) }}</td>
				                	<td class="text-center">{{ trans('globals.payments_concepts.'.$payment['concept']) }}</td>
					                <td class="text-center">
					                	<a href="{{ route('payments.edit', $payment['id']) }}" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
					                	@hasrole('admin,supervisor')
					                		<a class="btn btn-danger btn-xs" href="#" onclick="bootbox.confirm('{{ trans('validation.secure_delete_payment') }}', function(result) { if (result) window.location.href = '{{ route('payments.delete',$payment['id']) }}'; }); return false;"><i class="glyphicon glyphicon-trash"></i></a>
										@endhasrole
					                </td>
					            </tr>
				            @endforeach
				        </tbody>
				    </table>
				</div>
			</div>
		</div>
	</div>

@endsection

@include('partials.message')

@section ('jQueryScripts')
<script>
        $(function () {
			$('#payments_grid').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});
        });
    </script>
@endsection
