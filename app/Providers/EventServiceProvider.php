<?php

namespace App\Providers;

use App\Events\CertificateChangeStatusEvent;
use App\Events\OrderUpdatedEvent;
use App\Listeners\ChangeStatusListener;
use App\Listeners\SendCertificate;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\\VKontakte\\VKontakteExtendSocialite@handle',
        ],
        OrderUpdatedEvent::class=>[
            SendCertificate::class
        ],
        CertificateChangeStatusEvent::class=> [
            ChangeStatusListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }
}
