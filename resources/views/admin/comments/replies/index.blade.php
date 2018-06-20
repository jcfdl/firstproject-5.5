@extends('layouts.admin')
@section('content')
	@if(count($replies) > 0)
		<h1>Replies</h1>
		@if(Session::has('reply_deleted'))
			<p class="bg-danger">{{session('reply_deleted')}}</p>
		@endif
		<table class="table">
			<thead>
				<tr>
					<td>ID</td>
					<td>Author</td>
					<td>Email</td>
					<td>Body</td>
				</tr>
			</thead>
			<tbody>
				@foreach($replies as $reply)
					<tr>
						<td>{{$reply->id}}</td>
						<td>{{$reply->author}}</td>
						<td>{{$reply->email}}</td>
						<td>{{$reply->body}}</td>
						<td>
							<a class="btn btn-rounded btn-default" href="{{route('home.post', $reply->comment->post->id)}}"><span class="fa fa-eye"></span></a>
							@if($reply->is_active == 1)
								<a class="btn btn-warning btn-rounded" href="{{route('reply.edit', $reply->id)}}"><span class="fa fa-times"></a>
							@else 
								<a class="btn btn-success btn-rounded" href="{{route('reply.edit', $reply->id)}}"><span class="fa fa-check"></a>
							@endif
							<a class="btn btn-danger btn-rounded" href="{{route('reply.delete', $reply->id)}}"><span class="fa fa-trash"></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else 
		<h1 class="text-center">No replies</h1>
	@endif
@stop