@extends('layouts.admin')
@section('content')
	@if (Session::has('deleted_image'))
		<p class="bg-danger">{{session('deleted_image')}}</p>
	@endif
	<h1>Media</h1>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Created</th>
			</tr>
		</thead>
		<tbody>
			@foreach($photos AS $photo)
				<tr>
					<td>{{$photo->id}}</td>
					<td><img src="{{$photo->path}}" alt=""></td>
					<td>{{$photo->created_at->diffForHumans()}}</td>
					<td><a href="{{route('admin.media.delete', $photo->id)}}" title="" class="btn btn-danger">Delete</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop