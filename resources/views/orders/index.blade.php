@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
  <div class="panel-body">
      	<table class="table table-condensed table-bordered table-hover">
      		<thead>
      			<tr>
      				<td>NO</td>
      				<td>ORDER ID</td>
      				<td>MODEL</td>
      				<td>DATE ORDER</td>
      				<td>STATUS</td>
      				<td>MANAGE</td>
      			</tr>
      		</thead>

      		<tbody>
      			@if($orders->count())
					@foreach($orders as $item)
						<tr>
						<td>{{ $counter++ }}</td>
						<td>#{{ $item->id }}</td>
						<td>{{ $item->item->model }}</td>
						<td>{{ $item->created_at }}</td>
						<td><label class="label label-info">{{ \App\Entity\Purchase::getPurchaseStatus($item) }}</label></td>
						<td>
							<div class="btn-group">
							  <a href="#" class="btn btn-warning"><span> <i class="glyphicon glyphicon-th"></i> Manage</a>
							  <a href="#" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></a>
							  <ul class="dropdown-menu">
							    <li><a href="{{ route('order.show',$item->id) }}">View</a></li>
							    <li>
                
                      			<form action="{{ route('item,delete',$item->id) }}" method="DELETE">
										<button type="submit" onclick="return confirm('Delete this item?');"> Delete</button>
								</form>
                    
                  </li>
							  </ul>
							</div>
						</td>
					</tr>
					@endforeach
      			@else
					<div class="alert alert-info">No record found.</div>
      			@endif
      		</tbody>
      	</table>

      	{{ $orders->links() }}
  </div>
@endsection
