					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('document_type', trans('customers.document_type')) !!}
							{!! Form::select('document_type', $document_type, isset($document->document_type) ? $document->document_type : old('document_type'), ['id' => 'document_type', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('document_description', trans('customers.document_description')) !!}
							{!! Form::text('document_description', isset($document->document_description) ? $document->document_description : old('document_description'), ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('file', trans('customers.file')) !!}
							{!! Form::file('file', ['class' => 'form-control']) !!}
						</div>
					</div>