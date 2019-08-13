<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class QueryListener
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
     * @param  QueryExecuted  $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        if($event->sql){
            $bindings = [];
            foreach ($event->bindings as $binding) {
                $bindings[] = $binding instanceof \DateTime ? $binding->format('YYYY-MM-DD HH:mm:ss') : $binding;
            }
            Log::channel('sql')->debug("[{$event->time}ms] " . str_replace_array('?', $bindings, $event->sql) . PHP_EOL);
        }
    }
}
