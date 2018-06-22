@extends('layouts.admin')
@section('content')
	@if (Session::has('deleted_image'))
		<p class="bg-danger">{{session('deleted_image')}}</p>
	@endif
	<h1>Media</h1>
	@if($photos)
		<form action="delete/media" method="POST" class="form-inline">
			{{ csrf_field() }}
			<input type="submit" name="delete" class="btn btn-danger" value="Delete">				
			<table class="table table-hover">
				<thead>
					<tr>
						<th><input type="checkbox" id="medias"></th>
						<th>Id</th>
						<th>Name</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
					@foreach($photos AS $photo)
						<tr>
							<td><input class="checkBoxes" type="checkbox" name="mediaArr[]" value="{{$photo->id}}"></td>
							<td>{{$photo->id}}</td>
							<td><img src="{{$photo->path}}" alt=""></td>
							<td>{{$photo->created_at->diffForHumans()}}</td>
							<td><a href="{{route('admin.media.delete', $photo->id)}}" title="" class="btn btn-danger">Delete</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</form>
	@else
		<p>No Photos</p>
	@endif
@stop
@section('scripts')
	<script>
		$(document).ready(function() {
			$('#medias').click(function() {
				if(this.checked) {
					$('.checkBoxes').each(function() {
						this.checked = true;
					});
				} else {
					$('.checkBoxes').each(function() {
						this.checked = false;
					});
				}
				
			});
		});
	</script>
@stop