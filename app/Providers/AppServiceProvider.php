<?php

namespace App\Providers;

use App\Interfaces\IChildrenRepository;
use App\Interfaces\ICourseRepository;
use App\Interfaces\IParentsRepository;
use App\Interfaces\IQuizRepository;
use App\Interfaces\ISmsTokenRepository;
use App\Repository\ChildrenRepository;
use App\Repository\CourseRepository;
use App\Repository\ParentsRepository;
use App\Repository\QuizRepository;
use App\Repository\SmsTokenRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(IParentsRepository::class, ParentsRepository::class);
        $this->app->bind(ISmsTokenRepository::class, SmsTokenRepository::class);
        $this->app->bind(IChildrenRepository::class, ChildrenRepository::class);
        $this->app->bind(ICourseRepository::class, CourseRepository::class);
        $this->app->bind(IQuizRepository::class, QuizRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        URL::forceScheme('https');
    }
}
