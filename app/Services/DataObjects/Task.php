<?php

declare(strict_types=1);

namespace App\Services\DataObjects;

final readonly class Task
{
    public function __construct(
        public string $id,
    ) {
    }

    /**
     * @param array{
     *     id:string,
     * } $data
     * @return Task
     */
    public static function fromArray(array $data): Task
    {
        return new Task(
            id: $data['id'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
