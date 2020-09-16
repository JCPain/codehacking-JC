@extends('layouts.admin')
@section('content')
    <h1>Media</h1>
    @if(Session::has('msg-created'))
        <p class="bg-success">{{session('msg-created')}}</p>
    @elseif(Session::has('msg-updated'))
        <p class="bg-info">{{session('msg-updated')}}</p>
    @elseif(Session::has('msg-deleted'))
        <p class="bg-danger">{{session('msg-deleted')}}</p>
    @endif
    <div class="row">
        <div class="col-sm-6">
            @if($photos)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Created Date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($photos as $photo)
                            <tr>
                                <td>{{$photo->id}}</td>
                                <td><img height="50" width="100" src="{{$photo->file}}" alt=""></td>
                                <td>{{$photo->created_at ? $photo->created_at->diffForHumans() : 'no date'}}</td>
                                <td>
                                    {!! Form::open(['method' => 'DELETE', 'action' => ['AdminMediasController@destroy', $photo->id]]) !!}
                                    <div class="form-group">
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@stop