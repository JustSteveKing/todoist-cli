<?php

declare(strict_types=1);

namespace App\Services\Resources;

use App\Services\DataObjects\Project;
use App\Services\Exceptions\TodoistApiException;
use App\Services\Payloads\Projects\Create;
use App\Services\Todoist;
use Illuminate\Support\Collection;
use JustSteveKing\Tools\Http\Enums\Method;
use JustSteveKing\Tools\Http\Enums\Status;

final readonly class ProjectResource
{
    public function __construct(
        private Todoist $service,
    ) {}

    public function list(): Collection
    {
        $response = $this->service->send(
            method: Method::GET,
            url: '/projects',
        );

        if ($response->failed()) {
            $exception = $response->toException();

            throw new TodoistApiException(
                message: $exception->getMessage(),
                code: $exception?->getCode() ?? Status::UNAUTHORIZED->value,
                previous: $exception,
            );
        }


        return $response->collect()->map(fn(array $data) => Project::fromArray(
            data: $data,
        ));
    }

    public function create(Create $payload): Project
    {
        $response = $this->service->send(
            method: Method::POST,
            url: '/projects',
            body: $payload->toArray(),
        );

        if ($response->failed()) {
            $exception = $response->toException();

            throw new TodoistApiException(
                message: $exception->getMessage(),
                code: $exception?->getCode() ?? Status::UNAUTHORIZED->value,
                previous: $exception,
            );
        }

        return Project::fromArray(
            data: $response->json(),
        );
    }
}
