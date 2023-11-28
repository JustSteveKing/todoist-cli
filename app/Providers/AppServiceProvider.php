<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\ConfigContract;
use App\Repositories\LocalConfig;
use App\Services\Todoist;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            abstract: Todoist::class,
            concrete: function (): Todoist {
                /** @var LocalConfig $config */
                $config = $this->app->make(
                    abstract: ConfigContract::class,
                );

                return new Todoist(
                    request: Http::baseUrl(
                        url: 'https://api.todoist.com/rest/v2',
                    )->asJson()->acceptJson()->withToken(
                        token: $config->string('token'),
                    )->withUserAgent(
                        userAgent: 'Todoist_CLI_PHP',
                    ),
                );
            },
        );

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
