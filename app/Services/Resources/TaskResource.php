<?php

declare(strict_types=1);

namespace App\Services\Resources;

use App\Services\DataObjects\Task;
use App\Services\Exceptions\TodoistApiException;
use App\Services\Todoist;
use Illuminate\Support\Collection;
use JustSteveKing\Tools\Http\Enums\Method;
use JustSteveKing\Tools\Http\Enums\Status;

final readonly class TaskResource
{
    public function __construct(
        private Todoist $service,
    ) {}

    public function list(null|string $project = null): Collection
    {
        $url = '/tasks';

        if ($project) {
            $url .= "?project_id={$project}";
        }

        $response = $this->service->send(
            method: Method::GET,
            url: $url,
        );

        if ($response->failed()) {
            $exception = $response->toException();

            throw new TodoistApiException(
                message: $exception->getMessage(),
                code: $exception?->getCode() ?? Status::UNAUTHORIZED->value,
                previous: $exception,
            );
        }

        return $response->collect()->map(fn (array $data): Task => Task::fromArray(
            data: $data,
        ));
    }
}
