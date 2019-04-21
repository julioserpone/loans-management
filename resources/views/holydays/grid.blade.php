
    <table id="holydays_datagrid" class="table table-bordered table-hover dataTable" role="grid">
        <thead>
            <tr>
                <th>{{ trans('holyday.holyday') }}</th>
                <th>{{ trans('holyday.responsable') }}</th>
                <th class = "text-center">{{ trans('globals.updated_at') }}</th>
                <th class = "text-center">{{ trans('globals.actions') }}</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>{{ trans('holyday.holyday') }}</th>
                <th>{{ trans('holyday.responsable') }}</th>
                <th class = "text-center">{{ trans('globals.updated_at') }}</th>
                <th class = "text-center">{{ trans('globals.actions') }}</th>
            </tr>
        </tfoot>
        <tbody id="holydays_datagrid_body">
        	@foreach ($holydays as $holyday)
                <tr>
                    <td>{{ Carbon\Carbon::parse($holyday->holyday)->format('F j, Y') }}</td>
                    <td>{{ $holyday->user->fullName }}</td>
                    <td class = "text-center">{{ Carbon\Carbon::parse($holyday->updated_at)->format('F j, Y') }}</td>
                    <td class="text-center"><a href="{{ route('holydays.delete', $holyday->id) }}" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div id="there_is_not_holidays" style="display:none">
        <div class="row">&nbsp;</div>
        <div class="alert alert-warning" role="alert">
            <i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>{{ trans('globals.warning') }}!</strong>&nbsp;{{ trans('holyday.there_is_not_holidays') }}
        </div>
        <div class="row">&nbsp;</div>
    </div>
