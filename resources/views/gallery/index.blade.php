@extends('layouts.app')

@section('content')
    {!! Form::open(['url' => route('image.bucket.upload'),'files' => true]) !!}
    <div class="form-group">
        <input type="file" name="file[]" />
    </div>

    <div class="form-group">
        <input type="file" name="file[]" />
    </div>

    <div class="form-group">
        <input type="file" name="file[]" />
    </div>

    <div class="form-group">
        {!! Form::submit('New upload',['class' => 'btn btn-danger']) !!}
    </div>
    {!! Form::close() !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-condensed table-bordered table-hover">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>URL</td>
                    <td>MANAGE</td>
                </tr>
                </thead>

                <tbody>
                    @if($items->count())
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td><a href="{{ $item->path }}">{{ $item->path }}</a></td>
                            <td></td>
                        </tr>
                        @endforeach
                        @endif
                </tbody>
            </table>

            {{ $items->links() }}
        </div>
@endsection
