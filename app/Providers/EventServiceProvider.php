<?php

namespace App\Providers;

use App\Events\Evaluated;
use App\Events\PublishedBook;
use App\Events\StoreBookEvent;
use App\Events\TrackingUserActivity;
use App\Listeners\AddBookToUserActivityListener;
use App\Listeners\CalculateBookRating;
use App\Listeners\IncreaseUserBooksEvent;
use App\Listeners\SendNotificationForBookIsPublished;
use App\Models\Book;
use App\Models\Category;
use App\Models\Evaluation;
use App\Models\SchedulingInfo;
use App\Models\User;
use App\Observers\BookObserver;
use App\Observers\CategoryObserver;
use App\Observers\EvaluationObserver;
use App\Observers\SchedulingInfoObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Evaluated::class => [
            CalculateBookRating::class,
        ],
        PublishedBook::class => [
            SendNotificationForBookIsPublished::class,
        ],
        StoreBookEvent::class => [
            IncreaseUserBooksEvent::class,

        ],
        TrackingUserActivity::class => [
            AddBookToUserActivityListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

        User::observe(UserObserver::class);
        Book::observe(BookObserver::class);
        Category::observe(CategoryObserver::class);
        Evaluation::observe(EvaluationObserver::class);
        SchedulingInfo::observe(SchedulingInfoObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
