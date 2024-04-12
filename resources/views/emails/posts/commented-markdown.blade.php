<x-mail::message>
# Introduction
Someone has commented your post

The body of your message.

<x-mail::button :url="route('posts.show', ['post' => $comment->commentable->id])">
    Read more
</x-mail::button>


<x-mail::button :url="route('users.show', ['user' => $comment->user->id])">
    {{ $comment->user->name }} Profile
</x-mail::button>

 <x-mail::panel>
    {{ $comment->content }}
 </x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
