<div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" placeholder="Post title">
</div>

<div class="form-group">
    <label for="content">Content:</label>
    <textarea name="content" id="content" class="form-control" rows="10" placeholder="Content of your post">{{ old('content', $post->title) }}</textarea>
</div>