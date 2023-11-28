<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\ConfigContract;
use App\Repositories\LocalConfig;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            abstract: ConfigContract::class,
            concrete: function (): LocalConfig {
                $path = isset($_ENV['APP_ENV']) && 'testing' === $_ENV['APP_ENV']
                    ? base_path(path: 'tests')
                    : ($_SERVER['HOME'] ?? $_SERVER['USERPROFILE']);

                return new LocalConfig(
                    path: "{$path}/.config/todoist/config.json",
                );
            },
        );
    }
}
