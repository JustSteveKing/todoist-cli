<?php

declare(strict_types=1);

return [

    'name' => 'Todoist',

    'version' => app('git.version'),

    'env' => 'development',

    'timezone' => 'UTC',

    'providers' => [
        App\Providers\AppServiceProvider::class,
    ],

];
