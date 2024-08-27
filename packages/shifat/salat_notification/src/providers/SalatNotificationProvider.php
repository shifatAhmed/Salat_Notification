<?php

namespace Shifat\Salat_notification\Providers;

//use Shifat\Salat_notification\Console\RunEveryMinute;
use Shifat\Salat_notification\Console\RunEveryMinute;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;


class SalatNotificationProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Schedule $schedule)
    {
        $this->commands([
            RunEveryMinute::class,
        ]);
        $schedule->command('run:everyminute')->everyMinute();

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../views', 'salat_notification');
    }

    public function register()
    {
   
    }
}
