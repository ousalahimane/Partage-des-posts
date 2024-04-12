<?php

namespace App\Listeners;

use App\Jobs\NotifyUsersPostWasCommented;
use App\Mail\CommentedPostMarkdown;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyUsersAboutComment
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Mail::to($event->comment->commentable->user->email)->queue(new CommentedPostMarkdown($event->comment));

        NotifyUsersPostWasCommented::dispatch($event->comment);
    }
}
