<p class="text-muted">
    {{ $slot }} {{ $date->diffForHumans() }} 
    {!! isset($name) ? ', by <a href='. route('users.show', ['user' => $userId]) .'>' .$name .'</a>' : null !!}
</p>
