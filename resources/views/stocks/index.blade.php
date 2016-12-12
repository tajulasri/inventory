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
							    <li>

								  <li><a href="{{ route('image.stream',['x' => base64_encode($item->image)]) }}">Image</a></li>
								  <li>
                
                      <a type="submit" href="{{ route('item.destroy',$item->id) }}" onclick="if(confirm('Delete this item?')) { return true; } return false;"> Delete</a>
                    
                  </li>
							  </ul>
							</div>
						</td>
					</tr>
					@endforeach
      			@else

      			@endif
      		</tbody>
      	</table>

      	{{ $items->links() }}
  </div>
@endsection
