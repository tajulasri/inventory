@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
  <div class="panel-body">
         <div class="row-fluid">
            {!! Form::open(['url' => route('order.store'),'files' => true]) !!}
                

                <div class="form-group">
                    {!! Form::label('item') !!}
                        <select name="item_id" id="" class="form-control">
                            @foreach(\App\Entity\Item::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->model }}</option>
                            @endforeach
                        </select>
                </div>

                
                <div class="form-group">
                    {!! Form::label('status') !!}
                    <select name="status" id="" class="form-control">
                        <option value="0">Pending</option>
                        <option value="1">Accept</option>
                        <option value="2">Cancelled</option>
                    </select>
                </div>
                
                <div class="form-group">
                    {!! Form::label('quantity') !!}
                    {!! Form::number('quantity',old('quantity'),['class' => 'form-control','placeholder' => 'Quantity']) !!}
                </div>


                <div class="form-group">
                    {!! Form::label('customer') !!}
                    {!! Form::text('customer',old('customer'),['class' => 'form-control','placeholder' => 'Customer Name']) !!}
                </div>


                <div class="form-group">
                    {!! Form::label('customer contact') !!}
                    {!! Form::text('customer_contact',old('customer_contact'),['class' => 'form-control','placeholder' => 'Customer Contact']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('customer address') !!}
                    {!! Form::textarea('customer_address',
                    old('customer_address'),['class' => 'form-control','placeholder' => 'Customer address','style' => 'resize:none;']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('remarks') !!}
                    {!! Form::textarea('remarks',
                    old('remarks'),['class' => 'form-control','placeholder' => 'Remarks','style' => 'resize:none;']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Place Order',['class' => 'btn btn-danger']) !!}
                </div>
            {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection
