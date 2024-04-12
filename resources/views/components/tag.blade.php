
@foreach ($tags as $tag)
    <a href="{{route('posts.tag.index', ['id' => $tag->id])}}"><span class="badge bg-success">{{ $tag->name }}</span></a>
@endforeach
