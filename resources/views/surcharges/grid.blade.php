@extends('app')

@section('htmlheader_title')
    {{ trans('globals.section_title.surcharges_list') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ trans('globals.section_title.surcharges_list') }}</li>
@endsection

@section('main-content')

	<div class="box">

		<div class="box-header with-border">
			<h4 class="pull-left">
				<i class="fa fa-th"></i>&nbsp;{{ trans('globals.section_title.surcharges_list') }}
			</h4>
			@if ($loans->count() > 0)
				<a href="{{ route('loans.index') }}" class="btn btn-sm btn-success pull-right">
					<span class="fa fa-plus-square"></span>&nbsp;{{ trans('globals.add_new') }}&nbsp;{{ trans('globals.surcharge') }}
				</a>
			@endif
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-sm-12">
					<table id="surcharges_grid" class="table table-bordered table-hover dataTable" role="grid" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				            	<th class="text-center">{{ trans('globals.loans') }}</th>
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
				            	<th class="text-center">{{ trans('globals.loans') }}</th>
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
					            	<td class="text-center"><a href="{{ route('loans.edit', [$surcharge->loan->id]) }}">{{ \Utility::codeMasked($surcharge->loan->id,'CT') }}</a></td>
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
			    $('#surcharges_grid').DataTable({
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
