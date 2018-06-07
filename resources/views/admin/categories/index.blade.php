@extends('layouts.admin')
@section('content')
	<h1>Categories</h1>
	@if(Session::has('created_category'))
		<p class="bg-info">{{session('created_category')}}</p>
	@elseif(Session::has('updated_category'))
		<p class="bg-info">{{session('updated_category')}}</p>
	@elseif(Session::has('deleted_category'))
		<p class="bg-danger">{{session('deleted_category')}}</p>
	@endif
	<div class="row">
		<div class="col-sm-6">
			{!! Form::open(['method'=>'POST', 'action'=>'AdminCategoriesController@store']) !!}
				<div class="form-group">
					{!! Form::label('name', 'Name:') !!}
					{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Name']) !!}
				</div>
				<div class="form-group">
					{!! Form::submit('Create Category', ['class'=>'btn btn-primary']) !!}
				</div>
			{!! Form::close() !!}
		</div>
		<div class="col-sm-6">
			@if($categories)
			<table class="table table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Category</th>
						<th>Created</th>
						<th>Updated</th>
						<th><span class="fa fa-trash"></span></th>
					</tr>
				</thead>
				<tbody>
					@foreach($categories AS $category)
						<tr>
							<td>{{$category->id}}</td>
							<td><a href="{{route('admin.categories.edit', $category->id)}}">{{$category->name}}</a></td>
							<td>{{$category->created_at ? $category->created_at->diffForHumans() : ''}}</td>
							<td>{{$category->updated_at ? $category->updated_at->diffForHumans() : ''}}</td>
							<td><a href="{{route('category.delete', $category->id)}}"><span class="fa fa-trash btn-danger"></a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			@include('includes.form_error')
		</div>
	</div>
@stop