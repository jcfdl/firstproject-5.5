@extends('layouts.blog-post')
@section('content')
	<!-- Blog Post -->

    <!-- Title -->
    <h1>{{$post->title}}</h1>
    <!-- Author -->
    <p class="lead">
        by <a href="#">{{$post->user->name}}</a>
    </p>

    <hr>

    <!-- Date/Time -->
    <p><span class="glyphicon glyphicon-time"></span> Posted on {{$post->created_at->formatLocalized('%A, %d %B %Y')}}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive" src="{{$post->photo->path}}" alt="">

    <hr>

    <!-- Post Content -->
    <p>{{$post->body}}</p>

    <hr>
    @if(Session::has('comment_created'))
    	<p class="bg-info">{{session('comment_created')}}</p>
    @endif

    <!-- Blog Comments -->
    @if(Auth::check())
        <!-- Comments Form -->
        <div class="well">
            <h4>Leave a Comment:</h4>
           	{!! Form::open(['method'=>'POST', 'action'=>'PostCommentsController@store']) !!}
           		<div class="form-group"> 
               		{!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>3]) !!}
               		{!! Form::hidden('post_id', $post->id) !!}
               	</div>
               	<div class="form-group">
               		{!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
               	</div>
            {!! Form::close() !!}
        </div>
    @endif

    <hr>

    <!-- Posted Comments -->

    <!-- Comment -->
    @if(count($comments) > 0)
        @foreach($comments as $comment)
            <div class="media">
                <a class="pull-left" href="#">
                    <img height="64" width="64" class="media-object" src="{{Auth::user()->gravatar}}" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        {{$comment->author}}
                        <small>{{$comment->created_at->formatLocalized('%B %d, %Y at %I:%M %p')}}</small>
                    </h4>
                    {{$comment->body}}
                    @if(Session::has('reply_created'))
                        <p class="bg-info">{{session('reply_created')}}</p>
                    @endif 
                    @if(count($comment->replies) > 0)
                        @foreach($comment->replies AS $reply)                           
                            <!-- Nested Comment -->
                            <div id="nested-comment" class="media">
                                @if($reply->is_active == 1)
                                    <a class="pull-left" href="#">
                                        <img height="64" width="64" class="media-object" src="{{$reply->photo}}" alt="">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            {{$reply->author}}
                                            <small>{{$reply->created_at->formatLocalized('%B %d, %Y at %I:%M %p')}}</small>
                                        </h4>
                                        {{$reply->body}}
                                    </div>            
                                @endif
                            </div>
                            <!-- End Nested Comment -->
                        @endforeach
                        <div class="comment-reply-container"> 
                            <button class="toggle-reply btn btn-primary pull-right">Reply</button>
                            <div class="comment-reply col-sm-6"> 
                                {!! Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply']) !!}
                                    <div class="form-group">
                                        {!! Form::label('title', 'Title:') !!}
                                        {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>1]) !!}
                                        {!! Form::hidden('comment_id', $comment->id) !!}
                                    </div> 
                                    <div class="form-group">
                                        {!! Form::submit('submit', ['class'=>'btn btn-primary']) !!}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>           
                    @endif
                </div>
            </div>
        @endforeach
    @endif                
@stop
@section('scripts')
    <script>
        $(".toggle-reply").click(function() {
            $(this).next().slideToggle("slow");
        });
    </script>
@stop