<?php

declare(strict_types=1);

namespace App\Commands\Setup;

use App\Contracts\ConfigContract;
use LaravelZero\Framework\Commands\Command;

final class InitCommand extends Command
{
    protected $signature = 'init';

    protected $description = 'Initialize the Todoist CLI application.';

    public function handle(ConfigContract $config): int
    {
        $token = $this->components->ask(
            question: 'What is your Todoist API Token?',
        );

        if ( ! $token) {
            $this->components->alert(
                string: 'You need to provide an API Token to setup this CLI tool.',
            );

            return Command::INVALID;
        }

        $this->components->task(
            description: 'Initializing the configuration ....',
            task: fn() => $config->clear()->set(
                key: 'token',
                value: $token,
            ),
        );

        $this->components->info(
            string: 'Configuration saved, you can now use this CLI application.',
        );

        return Command::SUCCESS;
    }
}
