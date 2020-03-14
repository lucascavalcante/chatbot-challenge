<?php

namespace App\Listeners;

use App\Events\TransactionPerformed;
use App\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogTransactionPerformed
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
     * @param  TransactionPerformed  $event
     * @return void
     */
    public function handle(TransactionPerformed $event)
    {
        $log = new Log();
        $log->insert($event->log());
    }
}
