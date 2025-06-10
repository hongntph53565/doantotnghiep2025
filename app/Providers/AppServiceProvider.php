<?php

namespace App\Providers;

use App\Services\MailService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $listen = [
        \App\Events\UserRegistered::class => [
            \App\Listeners\SendWelcomeEmail::class,
            \App\Listeners\CreateMemberShipCard::class,
        ],
        \App\Events\PaymentEvents::class => [
            \App\Listeners\UpdateMemberCard::class,
        ],

    ];

    public function register(): void
    {
        $this->app->singleton(MailService::class, function () {
            return new MailService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
