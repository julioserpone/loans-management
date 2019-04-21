					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('reference_city_id', trans('customers.city')) !!}
							{!! Form::select('reference_city_id', $cities, isset($customers->reference_city_id) ? $customers->reference_city_id : (old('reference_city_id')!='' ? old('reference_city_id') : $medellin->id), ['id' => 'reference_city_id', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('reference_address', trans('customers.reference_address')) !!}
							{!! Form::text('reference_address', isset($customers->reference_address) ? $customers->reference_address : old('reference_address'), ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('reference_cellphone', trans('customers.reference_cellphone')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								{!! Form::text('reference_cellphone', isset($customers->reference_cellphone) ? $customers->reference_cellphone : old('reference_cellphone'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('reference_landphone', trans('customers.reference_landphone')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								{!! Form::text('reference_landphone', isset($customers->reference_landphone) ? $customers->reference_landphone : old('reference_landphone'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('reference_email', trans('customers.email')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-envelope-o"></i>
								</div>
								{!! Form::email('reference_email', isset($customers->reference_email) ? $customers->reference_email : old('reference_email'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>