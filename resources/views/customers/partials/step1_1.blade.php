					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('first_name', trans('customers.first_name')) !!}
							{!! Form::text('first_name',  isset($customers->user->first_name) ? $customers->user->first_name : old('first_name'), ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('last_name', trans('customers.last_name')) !!}
							{!! Form::text('last_name', isset($customers->user->last_name) ? $customers->user->last_name : old('last_name'), ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('identification', trans('customers.identification')) !!}
							<div class="input-group input-group-md">
								<div class="input-group-btn">
									<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id="ident">
										@if (isset($customers->user->identification_type))
											{{ strtoupper($customers->user->identification_type) }}
										@elseif (old('identification_type'))
											{{ strtoupper(old('identification_type')) }}
										@else
											{{ trans('globals.type') }}
										@endif
										<span class="fa fa-caret-down"></span>
									</button>
									<ul class="dropdown-menu">
										@foreach (array_keys(trans('globals.identification_type')) as $key => $iden)
											<li>
												<a href = "javascript:void(0);" onclick = "$('#identification_type').val('{{ $iden }}'); $('#ident').text('{{ strtoupper($iden) }}');">{{ strtoupper($iden) }}</a>
											</li>
										@endforeach
									</ul>
								</div>
								{!! Form::text('identification', isset($customers->user->identification) ? $customers->user->identification : old('identification'), ['class' => 'form-control']) !!}
								{!! Form::hidden('identification_type', isset($customers->user->identification_type) ? $customers->user->identification_type : old('identification_type'), ['id' => 'identification_type','class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('gender', trans('customers.gender')) !!} <br>
							{!! Form::radio('gender', 'male', isset($customers->user->gender) && $customers->user->gender == 'male' ? true : false, ['class' => 'radio-inline']) !!} {{ trans('globals.gender.male') }}
							{!! Form::radio('gender', 'female', isset($customers->user->gender) && $customers->user->gender == 'female' ? true : false, ['class' => 'radio-inline']) !!} {{ trans('globals.gender.female') }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('birth_date', trans('customers.birth_date')) !!}
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								{!! Form::text('birth_date', isset($customers->user->birth_date) ? Carbon\Carbon::parse($customers->user->birth_date)->format('d-m-Y') : old('birth_date'), ['class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('banks', trans('customers.bank')) !!}
							{!! Form::select('bank_id', $banks, isset($customers->bank_id) ? $customers->bank_id : old('bank_id'), ['id' => 'bank_id', 'class' => 'form-control select2', 'style' => 'width:100%']); !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-6">
							{!! Form::label('card_number', trans('customers.card_number')) !!}
							{!! Form::text('card_number', isset($customers->card_number) ? $customers->card_number : old('card_number'), ['class' => 'form-control']) !!}
						</div>
						<div class="form-group col-sm-6">
							{!! Form::label('card_key', trans('customers.card_key')) !!}
							<input id='card_key' name='card_key' class='form-control' type='password' data-toggle='password' value = "{{ isset($customers->card_key) ? $customers->card_key : old('card_key') }}">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							{!! Form::label('photo', trans('globals.photo')) !!}
							{!! Form::file('photo', ['class' => 'form-control']) !!}
						</div>
						@if ($edit)
							<div class="form-group col-sm-12">
								<img src = "{{ $customers->user->pic_url }}" class = "img-profile" alt = "{{ $customers->user->first_name }}" />
							</div>
						@endif
					</div>