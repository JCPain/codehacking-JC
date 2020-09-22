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
    <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>

    <hr>

    <!-- Preview Image -->
    <img class="img-responsive" src="{{$post->photo->file ? : 'https://source.unsplash.com/featured/?sky'}}" alt="">

    <hr>

    <!-- Post Content -->
    <p class="lead">{{$post->body}}</p>

    <hr>

    @if(Session::has('msg-created'))
        <p class="alert alert-info">{{session('msg-created')}}</p>
    @elseif(Session::has('msg-created-reply'))
        <p class="alert alert-info">{{session('msg-created-reply')}}</p>
    @endif
    
    <!-- Blog Comments -->

    @if(Auth::check())

        <!-- Comments Form -->
        <div class="well">
            <h4>Leave a Comment:</h4>
            {!! Form::open(['method' => 'POST', 'action' => 'PostCommentsController@store']) !!}
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <div class="form-group">
                    {!! Form::label('body', 'Body:') !!}
                    {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3]) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Submit Comment', ['class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>

    @endif

    <hr>

    <!-- Posted Comments -->

    @if(count($comments) > 0)

        @foreach($comments as $comment)

            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img width="64" height="64" class="media-object" src="{{Auth::user()->gravatar}}" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{$comment->author}}
                        <small>{{$comment->created_at->diffForHumans()}}</small>
                    </h4>
                    <p>{{$comment->body}}</p>
                    <hr>

                    @if(count($comment->replies) > 0)
                        @foreach($comment->replies as $reply)
                            @if($reply->is_active == 1)
                                <!-- Nested Comment -->
                                <div id="nested-comment" class="media">
                                    <a class="pull-left" href="#">
                                        <img width="64px" height="64px" class="media-object" src="{{$reply->photo}}" alt="">
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{$comment->author}}
                                            <small>{{$comment->created_at->diffForHumans()}}</small>
                                        </h4>
                                        <p>{{$reply->body}}</p>
                                    </div>
                                </div>
                                <!-- End Nested Comment --> 
                            @endif
                        @endforeach
                        <br>
                    @else
                        <h4 class="alert alert-info">No Reply</h4>
                    @endif
            
                    <div class="form-group">
                        <button class="toggle-reply btn btn-info">Reply</button>
                    </div>
                    <div class="comment-reply">
                        {!! Form::open(['method' => 'POST', 'action' => 'CommentRepliesController@createReply']) !!}
                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                            <div class="form-group">
                                {{-- {!! Form::label('body', 'Body:') !!} --}}
                                {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 1]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit('Submit', ['class' => 'btn btn-info pull-right']) !!}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        @endforeach

    @endif
@stop

@section('scripts')
    <script>
        $('.toggle-reply').click(function() {

            $('.comment-reply').slideToggle("fast");

        });
    </script>
@stop