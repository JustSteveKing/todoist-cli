<?php

declare(strict_types=1);

namespace App\Commands\Todoist\Projects;

use App\Services\DataObjects\Project;
use App\Services\Todoist;
use LaravelZero\Framework\Commands\Command;
use Throwable;

final class ListCommand extends Command
{
    protected $signature = 'projects:list';

    protected $description = 'List all projects from the Todoist API.';

    public function handle(Todoist $todoist): int
    {
        try {
            $projects = $todoist->projects()->list();
        } catch (Throwable $exception) {
            $this->components->error(
                string: $exception->getMessage(),
            );

            return Command::FAILURE;
        }

        $projects->each(function (Project $project) {
            $this->components->twoColumnDetail(
                first: 'ID',
                second: $project->id,
            );
            $this->components->twoColumnDetail(
                first: 'Name',
                second: $project->name,
            );
            $this->components->twoColumnDetail(
                first: 'Color',
                second: $project->color,
            );
            $this->components->twoColumnDetail(
                first: 'View',
                second: $project->view->name,
            );
        });

        return Command::SUCCESS;
    }
}
