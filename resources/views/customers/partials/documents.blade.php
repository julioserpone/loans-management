@if ($edit)
	<div class="row">
		<div class="col-sm-12">
			<table id="documents" class="table table-bordered table-hover dataTable" role="grid">
		        <thead>
		            <tr>
		                <th>{{ trans('customers.document_type') }}</th>
		                <th>{{ trans('customers.document_description') }}</th>
		                <th>{{ trans('globals.actions') }}</th>
		            </tr>
		        </thead>
		        <tfoot>
		            <tr>
		                <th>{{ trans('customers.document_type') }}</th>
		                <th>{{ trans('customers.document_description') }}</th>
		                <th>{{ trans('globals.actions') }}</th>
		            </tr>
		        </tfoot>
		        <tbody>
		        	@foreach ($grid_documents as $document)
			            <tr>
			                <td>{{ $document->document_type }}</td>
			                <td>{{ $document->document_description }}</td>
			                <td class="text-center">
			                	<a href="{{ route('customers.edit_document',[$customers->user_id,'4',$document->id]) }}" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i></a>
			                	<a href="{{ route('customers.download_document',$document->id) }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-download"></i></a>
			                	<a href="{{ route('customers.delete_document',$document->id) }}" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
			                </td>
			            </tr>
		            @endforeach
		        </tbody>
		    </table>
		</div>
	</div>

	<script>
        $(function () {
            $(document).ready(function() {
			    $('#documents').DataTable({
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
@endif
