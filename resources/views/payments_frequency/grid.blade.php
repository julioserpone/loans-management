@extends('app')

@section('htmlheader_title')
    {{ trans('globals.section_title.payments_freq_list') }}
@endsection

@section('contentheader_title')
    {{ trans('globals.section_title.payments_freq_list') }}
@endsection

@section('contentheader_description')
	{{ trans('globals.section_title.payments_freq_list_descrip') }}
@endsection

@section('breadcrumb_li')
	<li class="active">{{ trans('globals.section_title.payments_freq_list') }}</li>
@endsection

@section('main-content')

	<div class="box">

		<div class="box-header with-border">
			<a href="{{ route('paymentsFrequency.create') }}" class="btn btn-sm btn-success pull-right">
				<span class="fa fa-user-plus"></span>&nbsp;{{ trans('globals.add_new') }}&nbsp;{{ trans('globals.payment_frequency') }}
			</a>
		</div>

		<div class="box-body">
			<div class="row">
				<div class="col-sm-12">
					<table id="datagrid" class="table table-bordered table-hover dataTable" role="grid">
				        <thead>
				            <tr>
				                <th>{{ trans('globals.id') }}</th>
				                <th>{{ trans('globals.description') }}</th>
				                <th>{{ trans('globals.days') }}</th>
				                <th>{{ trans('globals.status') }}</th>
				                <th>{{ trans('globals.actions') }}</th>
				            </tr>
				        </thead>
				        <tfoot>
				            <tr>
				                <th>{{ trans('globals.id') }}</th>
				                <th>{{ trans('globals.description') }}</th>
				                <th>{{ trans('globals.days') }}</th>
				                <th>{{ trans('globals.status') }}</th>
				                <th>{{ trans('globals.actions') }}</th>
				            </tr>
				        </tfoot>
				        <tbody>
				        	@foreach ($payments_frequency as $payment_freq)
					            <tr>
					                <td>{{ Utility::codeMasked($payment_freq->id) }}</td>
					                <td>{{ ucwords($payment_freq->description) }}</td>
					                <td>{{ $payment_freq->days }}</td>
					                <td>{{ $payment_freq->status }}</td>
					                <th class="text-center">
					                	<a href="{{ route('paymentsFrequency.edit', $payment_freq->id) }}" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
					                	<a href="{{ route('payments_frecuency.delete', $payment_freq->id) }}" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
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


