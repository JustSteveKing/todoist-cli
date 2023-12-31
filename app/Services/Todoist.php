<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Resources\ProjectResource;
use App\Services\Resources\TaskResource;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use JustSteveKing\Tools\Http\Enums\Method;

final readonly class Todoist
{
    /**
     * @param PendingRequest $request
     */
    public function __construct(
        protected PendingRequest $request,
    ) {}

    public function projects(): ProjectResource
    {
        return new ProjectResource(
            service: $this,
        );
    }

    public function tasks(): TaskResource
    {
        return new TaskResource(
            service: $this,
        );
    }

    /**
     * @param Method $method
     * @param string $url
     * @param array<string,mixed>|null $body
     * @return PromiseInterface|Response
     * @throws Exception
     */
    public function send(Method $method, string $url, null|array $body = null): PromiseInterface|Response
    {
        return $this->request->send(
            method: $method->value,
            url: $url,
            options: [
                'json' => $body,
            ],
        );
    }
}
