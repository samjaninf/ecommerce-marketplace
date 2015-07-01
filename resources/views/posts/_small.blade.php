<div class="news">
    <div class="date">
        {!! $post->created_at->format('\<\s\p\a\n\>d\<\/\s\p\a\n\>\<\b\r\>M') !!}
    </div>
    <div class="contents">
        <div class="title">
            <a href="{{ route('posts.show', [$post->id]) }}">{{ $post->title }}</a>
        </div>

        <div class="abstract">
            <p>{{ \Illuminate\Support\Str::words($post->content, 40) }}</p>
        </div>
    </div>
</div>
