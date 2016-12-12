@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
  <div class="panel-body">
         <div class="row-fluid">

            <h4>Details</h4>
            <p>{{ $order->item->brand }} - {{ $order->item->model }}</p>
            {!! Form::open(['url' => route('order.update',$order->id),'files' => true,'method' => 'PUT']) !!}
                
                <div class="form-group">
                    {!! Form::label('customer') !!}
                    {!! Form::text('customer',$order->customer_name,['class' => 'form-control','placeholder' => 'Customer Name']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('quantity') !!}
                    {!! Form::number('quantity',$order->quantity,['class' => 'form-control','placeholder' => 'Quantity']) !!}
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
                    {!! Form::label('customer contact') !!}
                    {!! Form::text('customer_contact',$order->customer_contact,['class' => 'form-control','placeholder' => 'Customer Contact']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('customer address') !!}
                    {!! Form::textarea('customer_address',
                    $order->customer_address,['class' => 'form-control','placeholder' => 'Customer address','style' => 'resize:none;']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('remarks') !!}
                    {!! Form::textarea('remarks',
                    $order->remarks,['class' => 'form-control','placeholder' => 'Remarks','style' => 'resize:none;']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Save changes',['class' => 'btn btn-danger']) !!}
                </div>
            {!! Form::close() !!}
      </div>
  </div>
</div>
@endsection
