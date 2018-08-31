<?php

namespace App\Providers;

use App\Events\MessageCreated;
use App\Listeners\ReplyCreatedEventListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MessageCreated::class => [
            ReplyCreatedEventListener::class,
        ],
    ];
}
