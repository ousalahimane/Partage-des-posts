
 
@forelse($comments as $comment)
  <p>
    {{ $comment->content }}
  </p>
  <x-updated :date="$comment->created_at" :name="$comment->user->name" :userId="$comment->user->id">{{__('Added')}}</x-updated>
@empty
    <p>{{__('No comments yet!')}}</p>
@endforelse