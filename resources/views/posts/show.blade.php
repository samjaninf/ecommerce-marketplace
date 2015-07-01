@extends('app')

@section('page-title')
    {{ $post->title }}
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>
                    {{ $post->title }}
                    <span class="page-actions">
                        <a href="{{ route('posts.index') }}" class="btn btn-default">News list</a>
                    </span>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <p>Written the {{ $post->created_at->format('d/m/Y \a\t H:i') }}</p>
                <p class="news-content">
                    {!! nl2br(e($post->content)) !!}
                </p>
            </div>
        </div>
    </div>
@stop
