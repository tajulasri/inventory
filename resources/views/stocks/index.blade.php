@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
  <div class="panel-body">
      	<table class="table table-condensed table-bordered table-hover">
      		<thead>
      			<tr>
      				<td>NO</td>
      				<td>BRAND</td>
      				<td>MODEL</td>
					<td>SKU (CODE) </td>
      				<td>BALANCE</td>
      				<td>SELL</td>
      				<td>BUY</td>
      				<td>STATUS</td>
      				<td>MANAGE</td>
      			</tr>
      		</thead>

      		<tbody>
      			@if($items->count())
					@foreach($items as $item)
						<tr>
						<td>{{ $counter++ }}</td>
						<td>{{ $item->brand }}</td>
						<td>{{ $item->model }}</td>
							<td>{{ $item->identifier }}</td>
						<td>{{ $item->stock->balance }}</td>
						<td>{{ $item->sell }}</td>
						<td>{{ $item->buy }}</td>
						<td><label class="label label-primary">{{ \App\Entity\Item::getItemStatus($item) }}</label></td>
						<td>
							<div class="btn-group">
							  <a href="#" class="btn btn-warning"><span> <i class="glyphicon glyphicon-th"></i> Manage</a>
							  <a href="#" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></a>
							  <ul class="dropdown-menu">
							    <li><a href="{{ route('item.show',$item->id) }}">View</a></li>
								  <li><a href="{{ route('image.stream',['x' => base64_encode($item->image)]) }}">Image</a></li>
								  <li>
								  </li>
							  </ul>
							</div>

							<form action="{{ route('item.destroy', $item->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
								<input type="hidden" name="_method" value="DELETE">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
							</form>
						</td>
					</tr>
					@endforeach
      			@else
					<div class="alert alert-info">No record found.</div>
      			@endif
      		</tbody>
      	</table>

      	{{ $items->links() }}
  </div>
@endsection
