@extends('layouts.app')

{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

@section('title', 'Thread')
@section('content')
<div class="row justify-content-center pt-3">
    <div class="col-auto">
        <table class="table table-borderless">
            <thead class="thead-light">
                <tr>
                    <th>{{$thread->name}}</th>
                    <th>Created By</th>
                    <th>Last Updated</th>
                    <th>Tags</th>
                    <th>Edit</th>
                    <th>Attach Image</th>
                    <th></th>
                    <th>Delete</th>
                    {{-- <th>Edited By</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($thread->posts() as $post)
                <tr>
                    <td>{{$post->post_comment}}
                        @if($post->image_path)
                            <img src="{{ asset('images/' . $post->image_path) }}" width="50" height="75">
                        @endif
                    </td>
                    <td><a href='/users/{{$post->user->id}}'>{{$post->user->display_name}}</a></td>
                    <td>{{$post->created_at}}</td>
                    <td>
                        @foreach($post->tags as $tag)
                            <a href='/tags/{{$tag->name}}'>{{$tag->name}} | </a>
                        @endforeach
                    </td>
                    @can('canEdit', $post)
                        <td><a href="{{ route('posts.edit', [$post->id]) }}" button class="btn btn-warning">Edit</a></td>
                        {{-- image upload section of submission --}}

                        <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <input type="text" name="name" value="{{$post->id}}" class="form-control"  hidden>

                                {{-- image button to upload image while creating post --}}
                                <td><button type="submit" class="btn btn-info" >Upload Image</button></td>

                                <td><input type="file" accept=".png, .jpg, .bmp, .gif" name="image" class="form-control"></td>
                                
                        </form>
                    @else<td></td><td></td>
                    @endcan
                    @can('canDelete', $post)
                        <form method="POST" action="{{ route('posts.destroy', [$post->id]) }}">
                            @csrf
                            @method('DELETE')
                            <td><button class="btn btn-danger" type="submit">Delete</button></td>
                        </form>
                    @else
                    <td></td>
                    @endcan
                        {{-- <td><td>{{$post->edited_by}}</td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row justify-content-center pt-3">
            {{ $thread->posts()->links() }}
        </div>

        @auth
        @can('canCreate')
        <div id="PostReplyForm" >
            <div class="card-body">
                <form method="POST" action="{{ route('posts.store', ['post_comment' => "post_comment", 'thread_id' => $thread->id, 'user_id' => \Auth::user()->id]) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <textarea class="form-control" placeholder="{{__('Type your reply here.')}}" name="post_comment" id="post_comment" rows="5"></textarea>
                    </div>
                    <div class="row justify-content-center pt-2"></div>

                    <div class="form-group">
                        <button class="btn btn-success btn-lg" type="submit" id="post_comment" value="post_comment">{{__('Post Reply')}}</button>
                        <a href="{{ route('posts.create', [$thread->id]) }}" button class="btn btn-warning">Post With Ajax</a>
                    </div>
                </form>
            </div>
        </div>

        @else
        {{-- Notify user does not have permission to create post (not necessarily) --}}
        <div class="row justify-content-center pt-3">
            <p>{{__('No Permission to Create Post')}}</p>
        </div>
        @endcan
        @endauth

        {{-- notify logged out users need to be logged in to post comment --}}
        @guest
        <div class="row justify-content-center pt-3">
                <p>{{__('Only logged in users can post a reply.')}}</p>
        </div>
        @endguest
    </div>
</div>
@endsection