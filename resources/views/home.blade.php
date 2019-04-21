@extends('app')

@section('htmlheader_title')
    {{ trans('globals.section_title.dashboard') }}
@endsection

@section('breadcrumb_li')
    <li class="active">{{ trans('globals.section_title.dashboard') }}</li>
@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green">
                    <i class="fa fa-money"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('globals.revenue') }}</span>
                    <span class="info-box-number" id="_revenue">{{ trans('globals.loading') }}</span>
                    <small><a href="{{ route('payments.index') }}"><i class="glyphicon glyphicon-search"></i>&nbsp;{{ trans('globals.see_more') }}</a></small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow">
                    <i class="fa fa-usd"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('globals.outstanding') }}</span>
                    <span class="info-box-number" id="_outstanding">{{ $outstanding }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua">
                    <i class="fa fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('globals.customers') }}</span>
                    <span class="info-box-number" id="_customers">{{ trans('globals.loading') }}</span>
                    <small><a href="{{ route('customers.index') }}"><i class="glyphicon glyphicon-search"></i>&nbsp;{{ trans('globals.see_more') }}</a></small>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red">
                    <i class="fa fa-cube"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('globals.loans') }}</span>
                    <span class="info-box-number" id="_loans">{{ trans('globals.loading') }}</span>
                    <small><a href="{{ route('loans.index') }}"><i class="glyphicon glyphicon-search"></i>&nbsp;{{ trans('globals.see_more') }}</a></small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">&nbsp;</div>

    @if (isset($data['installments']))
    <div class="row">
         <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4 class="pull-left">
                        <i class="fa fa-clock-o"></i>&nbsp;{{ trans('globals.section_title.upcoming_installments') }}
                    </h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="installments_grid" class="table table-bordered table-hover dataTable" role="grid" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ trans('globals.user_employee') }}</th>
                                        <th class="text-center">{{ trans('globals.loans') }}</th>
                                        <th class="text-center">{{ trans('globals.installment') }}</th>
                                        <th class="text-center">{{ trans('loans.installment.due_date') }}</th>
                                        <th class="text-right">{{ trans('loans.installment.amount') }}</th>
                                        <th class="text-right">{{ trans('globals.interest') }}</th>
                                        <th class="text-right">{{ trans('globals.total') }}</th>
                                        <th class="text-center">{{ trans('globals.created_at') }}</th>
                                        <th class="text-center">{{ trans('globals.updated_at') }}</th>
                                        <th class="text-center">{{ trans('loans.installment.status') }}</th>
                                        <th class="text-center">{{ trans('globals.actions') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                     <tr>
                                        <th class="text-center">{{ trans('globals.user_employee') }}</th>
                                        <th class="text-center">{{ trans('globals.loans') }}</th>
                                        <th class="text-center">{{ trans('globals.installment') }}</th>
                                        <th class="text-center">{{ trans('loans.installment.due_date') }}</th>
                                        <th class="text-right">{{ trans('loans.installment.amount') }}</th>
                                        <th class="text-right">{{ trans('globals.interest') }}</th>
                                        <th class="text-right">{{ trans('globals.total') }}</th>
                                        <th class="text-center">{{ trans('globals.created_at') }}</th>
                                        <th class="text-center">{{ trans('globals.updated_at') }}</th>
                                        <th class="text-center">{{ trans('loans.installment.status') }}</th>
                                        <th class="text-center">{{ trans('globals.actions') }}</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($data['installments'] as $installment)
                                        <tr>
                                            <td class="text-center"><a href="{{ ($installment['user_role'] == 'customer') ? route('customers.edit', [$installment['user_id'], '1']) : route('employees.edit', $installment['user_id']) }}">{{ $installment['user_name'] }}</a></td>
                                            <td class="text-center"><a href="{{ route('loans.edit', [$installment['loan_id']]) }}">{{ \Utility::codeMasked($installment['loan_id'],'CT') }}</a></td>
                                            <td class="text-center">{{ $installment['installment_num'] }}</td>
                                            <td class="text-center">{{ $installment['expired_date'] }}</td>
                                            <td class="text-right">{{ $installment['amount'] }}</td>
                                            <td class="text-right">{{ $installment['interest_amount'] }}</td>
                                            <td class="text-right">{{ $installment['total_amount'] }}</td>
                                            <td class="text-center">{{ $installment['created_at'] }}</td>
                                            <td class="text-center">{{ $installment['updated_at'] }}</td>
                                            <td class="text-center"><label class = "{{ trans('globals.loans_payment_status_class.'.strtolower($installment['status'])) }}">{{ $installment['status'] }}</label></td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-default dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        &nbsp;&nbsp;&nbsp;{{ trans('globals.options') }}&nbsp;&nbsp;&nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                                        <li><a href="{{ route('loans.edit', $installment['loan_id']) }}"><i class="glyphicon glyphicon-search"></i>&nbsp;{{ trans('globals.see_more') }}</a></li>
                                                        <li><a href="{{ route('payments.add', ['id' => $installment['loan_id']]) }}"><i class="fa fa-credit-card"></i>&nbsp;{{ trans('globals.add_payment') }}</a></li>
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
        </div>
    </div>
    @endif

    @if (isset($data['surcharge']))
    <div class="row">
         <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h4 class="pull-left">
                        <i class="fa fa-clock-o"></i>&nbsp;{{ trans('globals.section_title.upcoming_surcharges') }}
                    </h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="surcharges_grid" class="table table-bordered table-hover dataTable" role="grid" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ trans('loans.installment.status') }}</th>
                                        <th class="text-center">{{ trans('payments.concept') }}</th>
                                        <th class="text-right">{{ trans('loans.installment.amount') }}</th>
                                        <th class="text-center">{{ trans('globals.created_at') }}</th>
                                        <th class="text-center">{{ trans('globals.updated_at') }}</th>
                                        <th class="text-center">{{ trans('globals.actions') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                     <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ trans('loans.installment.status') }}</th>
                                        <th class="text-center">{{ trans('payments.concept') }}</th>
                                        <th class="text-right">{{ trans('loans.installment.amount') }}</th>
                                        <th class="text-center">{{ trans('globals.created_at') }}</th>
                                        <th class="text-center">{{ trans('globals.updated_at') }}</th>
                                        <th class="text-center">{{ trans('globals.actions') }}</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($data['surcharge'] as $surcharge)
                                        <tr>
                                            <td class="text-center">{{ $surcharge['surcharge_num'] }}</td>
                                            <td class="text-center"><label class = "{{ trans('globals.loans_payment_status_class.'.strtolower($surcharge['status'])) }}">{{ $surcharge['status'] }}</label></td>
                                            <td class="text-center">{{ $surcharge['concept'] }}</td>
                                            <td class="text-right">{{ $surcharge['amount'] }}</td>
                                            <td class="text-center">{{ $surcharge['created_at'] }}</td>
                                            <td class="text-center">{{ $surcharge['updated_at'] }}</td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-default dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        &nbsp;&nbsp;&nbsp;{{ trans('globals.options') }}&nbsp;&nbsp;&nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                                                        <li><a href="{{ route('payments.add', ['id' => $surcharge['loan_id']]) }}"><i class="fa fa-credit-card"></i>&nbsp;{{ trans('globals.add_payment') }}</a></li>
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
        </div>
    </div>
    @endif

@endsection

@include('partials.message')

@section ('jQueryScripts')
    <script>
        $(function ()
        {

            $(document).ready(function() {
                $('#installments_grid, #surcharges_grid').DataTable({
                  "paging": true,
                  "lengthChange": true,
                  "searching": true,
                  "ordering": true,
                  "info": true
                });
            });

            $.ajax({
                url: "{{ route('dashboard.box') }}",
                method: "POST",
                data: { box: 'revenue', _token: "{{ csrf_token() }}" },
                dataType: 'json',
            }).done(function(data)
            {
                $('#_revenue').html(data['output']);
            });

            $.ajax({
                url: "{{ route('dashboard.box') }}",
                method: "POST",
                data: { box: 'customers', _token: "{{ csrf_token() }}" },
                dataType: 'json',
            }).done(function(data)
            {
                $('#_customers').html(data['output']);
            });

            $.ajax({
                url: "{{ route('dashboard.box') }}",
                method: "POST",
                data: { box: 'loans', _token: "{{ csrf_token() }}" },
                dataType: 'json',
            }).done(function(data)
            {
                $('#_loans').html(data['output']);
            });


        });
    </script>
@endsection
