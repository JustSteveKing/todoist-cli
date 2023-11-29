<?php

declare(strict_types=1);

namespace App\Commands\Todoist\Projects;

use App\Enums\Color;
use App\Services\Payloads\Projects\Create;
use App\Services\Todoist;
use LaravelZero\Framework\Commands\Command;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;

final class CreateCommand extends Command
{
    protected $signature = 'projects:create';

    protected $description = 'Create a new Project.';

    public function handle(Todoist $todoist): int
    {
        $name = $this->components->ask(
            question: 'What do you want to call this project?',
        );

        if (! $name) {
            $this->components->error(
                string: 'Your project requires a name.',
            );

            return Command::INVALID;
        }

        // ask the color
        if (confirm(label: 'Do you want to assign a color?')) {
            $color = select(
                label: 'Color',
                options: Color::select(),
                scroll: 5,
            );
        }
        // ask the parent ID if any
        // Do you want this to be a favorite?
        // What view style do you want this to be?

        // Actually create the thing.
        $project = $todoist->projects()->create(
            payload: new Create(
                name: $name,
                color: isset($color)
                    ? Color::from(
                        value: $color,
                    ) : null,
            ),
        );

        $this->components->info(
            string: "Project [$project->name] has been created. ID: [$project->id]",
        );

        return Command::SUCCESS;
    }
}
