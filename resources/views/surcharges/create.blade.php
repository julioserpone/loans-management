<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">
		@if ($edit && isset($surcharge))
			{{ trans('loans.surcharges_update_title', ['id' => $surcharge->loan_id]) }}
		@else
			{{ trans('loans.surcharges_add_title', ['id' => $loan->id]) }}
		@endif
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
			@if(!$edit)
				{!! Form::model(Request::all(),['route'=>['surcharges.store'], 'method'=>'POST', 'name'=>'surchargesFrm', 'id'=> 'surchargesFrm', 'role'=>'form']) !!}
		    @else
		        {!! Form::model($surcharge, ['route'=>['surcharges.update', $surcharge->id], 'method'=>'PUT', 'role'=>'form', 'name' => 'surchargesFrm', 'id' => 'surchargesFrm']) !!}
		    @endif
			<div class="form-group">
				{!! Form::label('surchargeConcept', trans('loans.surcharges_concept')) !!}:
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-leaf"></i></span>
					{!! Form::text('surchargeConcept', isset($surcharge) ? $surcharge->concept : old('surchargeConcept'), ['id' => 'surchargeConcept', 'class' => 'input-sm form-control']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('surchargeAmount', trans('loans.surcharges_amount')) !!}:
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-dollar"></i></span>
					{!! Form::text('_surchargeAmount', isset($surcharge) && $surcharge->amount && $edit? Utility::numberFormat($surcharge->amount, false) : old('_surchargeAmount'), ['id' => '_surchargeAmount', 'class' => 'input-sm text-right form-control']) !!}
					{!! Form::hidden('surchargeAmount', isset($surcharge) && $surcharge->amount && $edit ? $surcharge->amount : old('_surchargeAmount')) !!}
				</div>
			</div>
			<input type="hidden" name="loan_id" value="{{ (isset($surcharge) && $edit) ? $surcharge->loan_id : $loan->id }}">
			{!! Form::close() !!}
		</div>
	</div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-success" id="sendSurchargeFrm">
		<i class="fa fa-paper-plane-o"></i>&nbsp;
		{{ trans('globals.submit') }}
	</button>
</div>

<script src = "{{ asset('/js/jquery.number.min.js') }}" type = "text/javascript"></script>

<script>
    $(function () {
		$('#_surchargeAmount').number(true, 2, ',', '.');

		$('#sendSurchargeFrm').click(function ()
		{
			$('#surchargeAmount').val($('#_surchargeAmount').val());
			$('#surchargesFrm').submit();

		});
    });
</script>
