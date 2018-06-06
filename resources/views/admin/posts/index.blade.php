@extends('layouts.admin')
@section('content')
	@if (Session::has('post_created')) 
		<p class="bg-info">{{session('post_created')}}</p>
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
	    			<td>{{$post->category_id}}</td>
	    			<td>{{$post->title}}</td>
	    			<td>{{$post->body}}</td>
	    			<td>{{$post->created_at->diffForHumans()}}</td>
	    			<td>{{$post->updated_at->diffForHumans()}}</td>
	    		</tr>
	    	@endforeach
	    </tbody>
	</table>
@stop