@extends('app')

@section('htmlheader_title')
    {{ trans('globals.section_title.customers_list') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ trans('globals.section_title.customers_list') }}</li>
@endsection

@section('main-content')

	<div class="box">

		<div class="box-header with-border">
			<h4 class="pull-left"><i class="fa fa-th"></i>&nbsp;{{ trans('globals.section_title.customers_list') }}</h4>
			<a href="{{ route('customers.create') }}" class="btn btn-sm btn-success pull-right">
				<span class="fa fa-plus-square"></span>&nbsp;{{ trans('globals.add_new') }}&nbsp;{{ trans('globals.customer') }}
			</a>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-sm-12">
					<table id="datagrid" class="table table-bordered table-hover dataTable" role="grid">
				        <thead>
				            <tr>
				                <th class="text-center">{{ trans('customers.identification') }}</th>
				                <th class="text-center">{{ trans('customers.full_name') }}</th>
				                <th class="text-center">{{ trans('customers.cellphone_number') }}</th>
				                <th class="text-center">{{ trans('customers.balance') }}</th>
				                <th class="text-center">{{ trans('customers.status') }}</th>
				                <th class="text-center">{{ trans('globals.actions') }}</th>
				            </tr>
				        </thead>
				        <tfoot>
				            <tr>
				                <th class="text-center">{{ trans('customers.identification') }}</th>
				                <th class="text-center">{{ trans('customers.full_name') }}</th>
				                <th class="text-center">{{ trans('customers.cellphone_number') }}</th>
				                <th class="text-center">{{ trans('customers.balance') }}</th>
				                <th class="text-center">{{ trans('customers.status') }}</th>
				                <th class="text-center">{{ trans('globals.actions') }}</th>
				            </tr>
				        </tfoot>
				        <tbody>
				        	@foreach ($data as $customer)
					            <tr>
					                <td class="text-center">{{ \Utility::codeMasked($customer['identification'],'CL') }}</td>
					                <td class="text-center">{{ $customer['full_name'] }}</td>
					                <td class="text-center">{{ $customer['cellphone_number'] }}</td>
					                <td class="text-right">{{ Utility::numberFormat($customer['balance'], false) }}</td>
					                <td class="text-center"><label class = "{{ trans('globals.status_class.'.$customer['status']) }}">{{ ucfirst($customer['status']) }}</label></td>
					                <td class="text-center">
					                	<a href="{{ route('customers.edit',[$customer['user_id'],'1']) }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
					                	@hasrole('admin,supervisor')
						                	@if ($customer['balance'] <= 0)
						                		<a href="{{ route('customers.change_status',[$customer['user_id'], $customer['status']]) }}" class="btn btn-{{ ($customer['status']=='active')?'danger':'success' }} btn-xs"><i class="glyphicon glyphicon-off"></i></a>
						                	@endif
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
            $(document).ready(function() {
			    $('#datagrid').DataTable({
			      "paging": true,
			      "lengthChange": true,
			      "searching": true,
			      "ordering": true,
			      "info": true,
			      "autoWidth": true
			    });
			});
        });
    </script>
@endsection