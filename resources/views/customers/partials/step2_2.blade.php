					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('city_id', trans('customers.city')) !!}
							{!! Form::select('company_city_id', $cities, isset($customers->company_city_id) ? $customers->company_city_id : (old('company_city_id')!='' ? old('company_city_id') : $medellin->id), ['id' => 'company_city_id', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('company_affiliation_type', trans('customers.company_affiliation_type')) !!}
							{!! Form::select('company_affiliation_type', $affiliation_type, isset($customers->company_affiliation_type) ? $customers->company_affiliation_type : old('company_affiliation_type'), ['id' => 'company_affiliation_type', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('company_address', trans('customers.company_address')) !!}
							{!! Form::text('company_address', isset($customers->company_address) ? $customers->company_address : old('company_address'), ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('company_landphone', trans('customers.company_landphone')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								{!! Form::text('company_landphone', isset($customers->company_landphone) ? $customers->company_landphone : old('company_landphone'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('company_cellphone', trans('customers.company_cellphone')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								{!! Form::text('company_cellphone', isset($customers->company_cellphone) ? $customers->company_cellphone : old('company_cellphone'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					
					
