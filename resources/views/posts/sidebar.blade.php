  {{-- Card for Most commented post --}}
  <x-card title="{{__('Most Commented')}}">
    @foreach ($mostCommented as $post)
    <li class="list-group-item"> 
      <a href="{{route('posts.show', ['post' => $post->id])}}">{{ $post->title }}
        <span class="badge bg-success">{{ $post->comments_count }}</span>
      </a>
    </li>
   @endforeach
</x-card>

{{-- Card for Users who created many posts --}}
<x-card 
  title="{{__('Most Active')}}" 
 :items="collect($manyPosts)->pluck('name')">
</x-card>

{{-- Users who created many posts last month --}}
<x-card 
  title="{{__('Most Active Last Month')}}" 
 :items="collect($activeInLastMonth)->pluck('name')">
</x-card>