<?php

declare(strict_types=1);

namespace App\Commands\Todoist\Tasks;

use App\Services\DataObjects\Task;
use App\Services\Todoist;

use function Laravel\Prompts\error;
use function Laravel\Prompts\table;

use LaravelZero\Framework\Commands\Command;
use Throwable;

final class ListCommand extends Command
{
    protected $signature = 'tasks:list { project? : The Project ID to limit to. }';

    protected $description = 'Get a list of all active tasks from the Todoist API.';

    public function handle(Todoist $todoist): int
    {
        try {
            $tasks = $todoist->tasks()->list(
                project: $this->argument(
                    key: 'project',
                ),
            );
        } catch (Throwable $exception) {
            error(
                message: $exception->getMessage(),
            );

            return Command::FAILURE;
        }

        table(
            headers: ['ID'],
            rows: $tasks->map(fn(Task $task): array => $task->toArray()),
        );

        return Command::SUCCESS;
    }
}
