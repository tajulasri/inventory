@extends('layouts.app')

@section('content')

<div class="panel panel-default">
  <div class="panel-body">
      <div class="row-fluid">
      		{!! Form::open(['url' => route('stock.store')]) !!}
				<div class="form-group">
					{!! Form::label('item') !!}
						<select name="item_id" id="" class="form-control">
							@foreach(\App\Entity\Item::all() as $item)
								<option value="{{ $item->id }}">{{ $item->model }}</option>
							@endforeach
						</select>
				</div>

				<div class="form-group">
					{!! Form::label('balance') !!}
					{!! Form::number('balance',old('balance'),['placeholder' => 'Stock Balance','class' => 'form-control']) !!}
				</div>

				<div class="form-group">

					{!! Form::submit('Add Stock',['class' => 'btn btn-danger']) !!}
				</div>
      		{!! Form::close() !!}
      </div>
  </div>
@endsection
