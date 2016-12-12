@extends('layouts.public.public')

@section('content')
<div class="container">
    <div class="panel panel-default">
  <div class="panel-body">
         <div class="row-fluid">

            <p class="alert alert-info">Order form</p>

            <h4>Terma dan syarat</h4>
            <p>Order hanya akan di prosess jika bayaran diterima pada sebelum <strong>12.00 PM</strong> setiap hari.Bayaran selepas 12.00pm akan di prosess pada hari keesokannya</p>

            <p>Sila isi butiran yang tersedia di bawah ini dan sila kembalikan ORDER ID yang terdapat pada order form selepas berjaya dhantar.Dan order ID tersebut hendaklah disimpan sebagai rujukan kepada kami.</p>
        
             <h4>Butiran</h4>
             <p>Brand - {{ $item->brand }}</p>
             <p>Model - {{ $item->model }}</p>
             <p>CODE - {{ $item->identifier }}</p>
             <p>Extras - {{ $item->attributes }}</p>
             <p><img src="{{ asset('images').DIRECTORY_SEPARATOR.$item->image }}" alt="{{ $item->item_slug }}"></p>
            {!! Form::open(['url' => route('orderform.store',$item->item_slug),'files' => true]) !!}
               

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
