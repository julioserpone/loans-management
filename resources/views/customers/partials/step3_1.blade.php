					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('reference_type', trans('customers.reference_type')) !!}
							{!! Form::select('reference_type', $references_type, isset($customers->reference_type) ? $customers->reference_type : old('reference_type'), ['id' => 'reference_type', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('reference_relationship', trans('customers.reference_relationship')) !!}
							{!! Form::select('reference_relationship', $relationships, isset($customers->reference_relationship) ? $customers->reference_relationship : old('reference_relationship'), ['id' => 'reference_relationship', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('identification', trans('customers.identification')) !!}
							<div class="input-group input-group-md">
								<div class="input-group-btn">
									<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="ident_reference">
										@if (isset($customers->reference_identification_type))
											{{ strtoupper($customers->reference_identification_type) }}
										@elseif (old('identification_type'))
											{{ strtoupper(old('reference_identification_type')) }}
										@else
											{{ trans('globals.type') }}
										@endif
										<span class="fa fa-caret-down"></span>
									</button>
									<ul class="dropdown-menu">
										@foreach (array_keys(trans('globals.identification_type')) as $key => $iden)
											<li>
												<a href = "javascript:void(0);" onclick = "$('#reference_identification_type').val('{{ $iden }}'); $('#ident_reference').text('{{ strtoupper($iden) }}');">{{ strtoupper($iden) }}</a>
											</li>
										@endforeach
									</ul>
								</div>
								{!! Form::text('reference_identification', isset($customers->reference_identification) ? $customers->reference_identification : old('reference_identification'), ['class' => 'form-control']) !!}
								{!! Form::hidden('reference_identification_type', isset($customers->reference_identification_type) ? $customers->reference_identification_type : old('reference_identification_type'), ['id' => 'reference_identification_type','class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('reference_first_name', trans('customers.first_name')) !!}
							{!! Form::text('reference_first_name', isset($customers->reference_first_name) ? $customers->reference_first_name : old('reference_first_name'), ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('reference_last_name', trans('customers.last_name')) !!}
							{!! Form::text('reference_last_name', isset($customers->reference_last_name) ? $customers->reference_last_name : old('reference_last_name'), ['class' => 'form-control']) !!}
						</div>
					</div>