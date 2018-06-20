@extends('layouts.admin')
@section('content')
	@if(count($comments) > 0)
		<h1>Comments</h1>
		@if(Session::has('comment_deleted'))
			<p class="bg-danger">{{session('comment_deleted')}}</p>
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
				@foreach($comments as $comment)
					<tr>
						<td>{{$comment->id}}</td>
						<td>{{$comment->author}}</td>
						<td>{{$comment->email}}</td>
						<td>{{$comment->body}}</td>
						<td>
							<a class="btn btn-rounded btn-default" href="{{route('home.post', $comment->post->id)}}"><span class="fa fa-eye"></span></a>
							<a class="btn btn-rounded btn-primary" href="{{route('reply.show', $comment->id)}}"><span class="fa fa-eye"></span></a>
							@if($comment->is_active == 1)
								<a class="btn btn-warning btn-rounded" href="{{route('comment.edit', $comment->id)}}"><span class="fa fa-times"></a>
							@else 
								<a class="btn btn-success btn-rounded" href="{{route('comment.edit', $comment->id)}}"><span class="fa fa-check"></a>
							@endif
							<a class="btn btn-danger btn-rounded" href="{{route('comment.delete', $comment->id)}}"><span class="fa fa-trash"></a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else 
		<h1 class="text-center">No comments</h1>
	@endif
@stop