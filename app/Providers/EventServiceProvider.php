<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\TokenIssued' => [
            'App\Listeners\UpdateCallTable',
        ],
        'App\Events\TokenCalled' => [
            'App\Listeners\UpdateDisplay',
        ],
        'App\Events\TokenCalled2' => [
            'App\Listeners\UpdateDisplay2',
        ],
        'App\Events\CsvGenerate' => [
            'App\Listeners\CsvFileUpdate',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
