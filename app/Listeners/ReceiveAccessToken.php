<?php

namespace App\Listeners;

use App\Events\AccessTokenReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReceiveAccessToken
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AccessTokenReceived $event)
    {
        \Artisan::call('receive:token', []);
    }
}
