					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('company', trans('customers.company')) !!}
							{!! Form::text('company', isset($customers->company) ? $customers->company : old('company'), ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('contract_type', trans('customers.contract_type')) !!}
							{!! Form::select('contract_type', $contract_type, isset($customers->contract_type) ? $customers->contract_type : old('contract_type'), ['id' => 'contract_type', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
						</div>
					</div>
					<div class="row contract_temporary">
						<div class="form-group col-sm-12">
							{!! Form::label('company_temporal', trans('customers.company_temporal')) !!}
							{!! Form::text('company_temporal',  isset($customers->company_temporal) ? $customers->company_temporal : old('company_temporal'), ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('company_position', trans('customers.company_position')) !!}
							{!! Form::text('company_position',  isset($customers->company_position) ? $customers->company_position : old('company_position'), ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('company_salary', trans('customers.company_salary')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="glyphicon glyphicon-usd"></i>
								</div>
								{!! Form::text('company_salary', number_format(isset($customers->company_salary) ? $customers->company_salary : old('company_salary'), 2, ',','.'), ['id' => 'company_salary', 'class' => 'text-right form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('company_time_worked', trans('customers.company_time_worked')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								{!! Form::text('company_time_worked', isset($customers->company_time_worked) ? $customers->company_time_worked : old('company_time_worked'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('eps', trans('customers.eps')) !!}
							{!! Form::select('eps', $eps, isset($customers->eps) ? $customers->eps : old('eps'),  ['id' => 'eps', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
						</div>
					</div>