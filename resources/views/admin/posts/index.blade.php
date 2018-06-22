@extends('layouts.admin')
@section('content')
	@if (Session::has('post_created')) 
		<p class="bg-info">{{session('post_created')}}</p>
	@elseif (Session::has('post_edited'))
		<p class="bg-info">{{session('post_edited')}}</p>
	@elseif (Session::has('post_deleted'))
		<p class="bg-danger">{{session('post_deleted')}}</p>
	@endif
	<h1>Posts</h1>
	<table class="table table-hover">
	    <thead>
	    <tr>
		    <th>ID</th>		    
		    <th>Photo</th>
		    <th>Owner</th>
		    <th>Category</th>
		    <th>Title</th>
		    <th>Body</th>
		    <th>View Post</th>
		    <th>View Comments</th>
		    <th>Created</th>
		    <th>Updated</th>
	    </tr>
	    </thead>
	    <tbody>
	    	@foreach ($posts as $post)
	    		<tr>
	    			<td>{{$post->id}}</td>
	    			<td><img src="{{$post->photo ? $post->photo->path : 'http://via.placeholder.com/240x180'}}" alt=""></td>
	    			<td>{{$post->user->name}}</td>
	    			<td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
	    			<td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->title}}</a></td>
	    			<td>{{str_limit($post->body, 7)}}</td>
	    			<td><a href="{{route('home.post', $post->slug)}}">View Post</a></td>
	    			<td><a href="{{route('comment.show', $post->id)}}">View Comments</a></td>
	    			<td>{{$post->created_at->diffForHumans()}}</td>
	    			<td>{{$post->updated_at->diffForHumans()}}</td>
	    		</tr>
	    	@endforeach
	    </tbody>
	</table>

	<div class="row">
		<div class="col-sm-6 col-sm-offset-5">
			{{$posts->render()}}
		</div>
	</div>
@stop