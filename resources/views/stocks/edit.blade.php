@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
  <div class="panel-body">
      <div class="row-fluid">
      		{!! Form::open(['url' => route('item.update',$item->id),'files' => true,'method' => 'PUT']) !!}
				
				<div class="form-group">
					<p class="alert alert-info">
						Order URL: <a href="{{ route('orderform.index',$item->item_slug) }}">{{ route('order.index',$item->item_slug) }}</a>
					</p>
				</div>
				<div class="form-group">
					{!! Form::label('Brand') !!}
					{!! Form::text('brand',$item->brand,['class' => 'form-control','placeholder' => 'Brand']) !!}
				</div>


				<div class="form-group">
					{!! Form::label('ORDER FORM') !!}
					{!! Form::text('item_slug',$item->item_slug,['class' => 'form-control','placeholder' => 'Item slug','readonly']) !!}
				</div>


				<div class="form-group">
					{!! Form::label('Model') !!}
					{!! Form::text('model',$item->model,['class' => 'form-control','placeholder' => 'Model']) !!}
				</div>


				<div class="form-group">
					{!! Form::label('sku') !!}
					{!! Form::text('identifier',$item->identifier,['class' => 'form-control','placeholder' => 'Sku (82782743-ADIDAS)']) !!}
				</div>

				  <div class="form-group">
					  {!! Form::label('extras attributes') !!}
					  {!! Form::text('attributes',$item->attributes,['class' => 'form-control','placeholder' => 'SIZE 43']) !!}
				  </div>

				<div class="form-group">
					{!! Form::label('category') !!}
					<select name="category_id" id="" class="form-control">
						@foreach(\App\Entity\Category::all() as $category)
							<option value="{{ $category->id }}"> {{ $category->name }}</option>
						@endforeach
					</select>
				</div>


				<div class="form-group">
					{!! Form::label('buy price') !!}
					{!! Form::number('buy',$item->buy,['class' => 'form-control','placeholder' => 'RM 3.00']) !!}
				</div>


				<div class="form-group">
					{!! Form::label('sell price') !!}
					{!! Form::number('sell',$item->sell,['class' => 'form-control','placeholder' => 'RM 2.00']) !!}
				</div>

					<div class="form-group">
					{!! Form::label('image') !!}
					{!! Form::file('image',['class' => 'file-upload']) !!}
				</div>

				<div class="form-group">
					{!! Form::submit('Add Item',['class' => 'btn btn-danger']) !!}
				</div>
      		{!! Form::close() !!}
      </div>
  </div>
@endsection
