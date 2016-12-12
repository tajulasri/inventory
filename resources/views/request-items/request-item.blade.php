@extends('layouts.public.public')
@section('content')
    <div class="panel panel-default">
  <div class="panel-body">
         <div class="row-fluid">
            {!! Form::open(['url' => route('request-item.store'),'files' => true]) !!}

                <div class="form-group">
                    {!! Form::label('category') !!}
                        <select name="category_id" id="" class="form-control">
                            @foreach(\App\Entity\Category::all() as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                </div>
                
                  <div class="form-group">
                    {!! Form::label('contact') !!}
                    {!! Form::text('contact',old('contact'),['class' => 'form-control','placeholder' => 'Email / Phone']) !!}
                </div>


                 <div class="form-group">
                    {!! Form::label('image') !!}
                    {!! Form::file('image') !!}
                </div>

                <div class="form-group">
                    {!! Form::label('content') !!}
                    {!! Form::textarea('content',
                    old('content'),['class' => 'form-control','placeholder' => 'Contents','style' => 'resize:none;']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Send Request',['class' => 'btn btn-danger']) !!}
                </div>
            {!! Form::close() !!}
      </div>
  </div>
@endsection
