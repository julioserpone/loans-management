@extends('app')

@section('htmlheader_title')
    {{ trans('globals.section_title.employees_list') }}
@endsection

@section('contentheader_title')
    {{ trans('globals.section_title.employees_list') }}
@endsection

@section('contentheader_description')
	{{ trans('globals.section_title.employees_list_descrip') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ trans('globals.section_title.employees_list') }}</li>
@endsection

@section('main-content')

	<div class="box">

		<div class="box-header with-border">
			<a href="/employees/create" class="btn btn-sm btn-success pull-right">
				<span class="fa fa-user-plus"></span>&nbsp;{{ trans('globals.add_new') }}&nbsp;{{ trans('globals.employee') }}
			</a>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-sm-12">
					<table id="datagrid" class="table table-bordered table-hover dataTable" role="grid">
				        <thead>
				            <tr>
				                <th class="text-center">{{ trans('users.identification') }}</th>
				                <th class="text-center">{{ trans('users.full_name') }}</th>
				                <th class="text-center">{{ trans('users.cellphone_number') }}</th>
				                <th class="text-center">{{ trans('users.homephone_number') }}</th>
				                <th class="text-center">{{ trans('users.age') }}</th>
				                <th class="text-center">{{ trans('users.balance') }}</th>
				                <th class="text-center">{{ trans('users.status') }}</th>
				                <th class="text-center">{{ trans('globals.actions') }}</th>
				            </tr>
				        </thead>
				        <tfoot>
				            <tr>
				                <th class="text-center">{{ trans('users.identification') }}</th>
				                <th class="text-center">{{ trans('users.full_name') }}</th>
				                <th class="text-center">{{ trans('users.cellphone_number') }}</th>
				                <th class="text-center">{{ trans('users.homephone_number') }}</th>
				                <th class="text-center">{{ trans('users.age') }}</th>
				                <th class="text-center">{{ trans('users.balance') }}</th>
				                <th class="text-center">{{ trans('users.status') }}</th>
				                <th class="text-center">{{ trans('globals.actions') }}</th>
				            </tr>
				        </tfoot>
				        <tbody>
				        	@foreach ($data as $user)
					            <tr>
					                <td class="text-center">{{ $user['identification'] }}</td>
					                <td class="text-center">{{ ucwords($user['full_name']) }}</td>
					                <td class="text-center">{{ $user['cellphone_number'] }}</a></td>
					                <td class="text-center">{{ $user['homephone_number'] }}</td>
					                <td class="text-center">{{ $user['age'] }}</td>
					                <td class="text-right">{{ Utility::numberFormat($user['balance'], false) }}</td>
					                <td class="text-center"><label class = "{{ trans('globals.status_class.'.$user['status']) }}">{{ ucfirst($user['status']) }}</label></td>
					                <th class="text-center">
					                	<a href="{{ route('employees.edit', $user['id']) }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
					                	@hasrole('admin,supervisor')
					                		@if ($user['balance'] <= 0)
						                		<a href="{{ route('employee.change_status',[$user['id'], $user['status']]) }}" class="btn btn-{{ ($user['status']=='active')?'danger':'success' }} btn-xs"><i class="glyphicon glyphicon-off"></i></a>
					                		@endif
					                	@endhasrole
					                </th>
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


