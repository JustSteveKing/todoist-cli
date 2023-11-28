<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ConfigContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Override;

final readonly class LocalConfig implements ConfigContract
{
    public function __construct(
        private string $path,
    ) {}

    #[Override] public function all(): array
    {
        if ( ! is_dir(dirname(path: $this->path))) {
            if ( ! mkdir(
                directory: $concurrentDirectory = dirname(
                    path: $this->path,
                ),
                permissions: 0755,
                recursive: true
            ) && ! is_dir(filename: $concurrentDirectory)) {
                throw new CouldNotCreateDirectory(
                    message: "Directory [{$concurrentDirectory}] was not created",
                );
            }
        }

        if (file_exists(filename: $this->path)) {
            return json_decode(
                json: file_get_contents(
                    filename: $this->path,
                ),
                associative: true,
                depth: 512,
                flags: JSON_THROW_ON_ERROR,
            );
        }

        return [];
    }

    #[Override] public function clear(): ConfigContract
    {
        File::delete(
            paths: $this->path,
        );

        return $this;
    }

    #[Override] public function get(string $key, mixed $default = null): array|int|string|null
    {
        return Arr::get(
            array: $this->all(),
            key: $key,
            default: $default,
        );
    }

    #[Override] public function set(string $key, array|int|string $value): ConfigContract
    {
        $config = $this->all();

        Arr::set(
            array: $config,
            key: $key,
            value: $value,
        );

        file_put_contents(
            filename: $this->path,
            data: json_encode(
                value: $config,
                flags: JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT,
            ),
        );

        return $this;
    }
}
