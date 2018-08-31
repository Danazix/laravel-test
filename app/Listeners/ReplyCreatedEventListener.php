<?php

namespace App\Listeners;

use App\Events\MessageCreated;
use App\Notifications\GotReplyNotification;

class ReplyCreatedEventListener
{
    /**
     * Handle the event.
     *
     * @param MessageCreated $event
     * @return void
     */
    public function handle(MessageCreated $event): void
    {
        $message = $event->getMessage();

        if($message->parent()->exists()) {
            $message->parent->user->notify(new GotReplyNotification($message));
        }
    }
}
