<?php

declare(strict_types=1);

namespace App\Services\Payloads\Projects;

use App\Enums\Color;
use App\Enums\View;

final readonly class Create
{
    public function __construct(
        public string $name,
        public null|string $parentId = null,
        public null|Color $color = null,
        public bool $isFavorite = false,
        public View $view = View::Board,
    ) {}

    /**
     * @return array{
     *     name:string,
     *     parent_id:null|string,
     *     color:null|string,
     *     is_favorite:bool,
     *     view_style:string,
     * }
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'parent_id' => $this->parentId,
            'color' => $this->color?->value,
            'is_favorite' => $this->isFavorite,
            'view_style' => $this->view->name,
        ];
    }
}
