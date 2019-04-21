					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('city_id', trans('customers.city')) !!}<br>
							{!! Form::select('city_id', $cities, isset($customers->city_id) ? $customers->city_id : (old('city_id')!='' ? old('city_id') : $medellin->id), ['id' => 'city_id', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('address', trans('customers.home_address')) !!}
							{!! Form::text('address', isset($customers->address) ? $customers->address : old('address'), ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('cellphone_number', trans('users.cellphone_number')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								{!! Form::text('cellphone_number', isset($customers->user->cellphone_number) ? $customers->user->cellphone_number : old('cellphone_number'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('homephone_number', trans('users.homephone_number')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								{!! Form::text('homephone_number', isset($customers->user->homephone_number) ? $customers->user->homephone_number : old('homephone_number'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('email', trans('users.email')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-envelope-o"></i>
								</div>
								{!! Form::email('email', isset($customers->user->email) ? $customers->user->email : old('email'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('notes', trans('customers.notes')) !!}
							{!! Form::textarea('notes', isset($customers->notes) ? $customers->notes : old('notes'), ['class' => 'form-control']) !!}
						</div>
					</div>
