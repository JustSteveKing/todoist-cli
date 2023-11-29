<?php

declare(strict_types=1);

namespace App\Services\DataObjects;

use App\Enums\View;

final readonly class Project
{
    public function __construct(
        public string $id,
        public string $name,
        public int    $commentCount,
        public int    $order,
        public string $color,
        public bool   $isShared,
        public bool   $isFavorite,
        public null|string $parentId,
        public bool   $inboxProject,
        public bool   $teamInbox,
        public View $view,
        public string $url,
    ) {}

    /**
     * @param array{
     *     id:string,
     *     parent_id:null|string,
     *     order:int,
     *     color:string,
     *     name:string,
     *     comment_count:int,
     *     is_shared:bool,
     *     is_favorite:bool,
     *     is_inbox_project:bool,
     *     is_team_inbox:bool,
     *     url:string,
     *     view_style:string,
     * } $data
     * @return Project
     */
    public static function fromArray(array $data): Project
    {
        return new Project(
            id: $data['id'],
            name: $data['name'],
            commentCount: $data['comment_count'],
            order: $data['order'],
            color: $data['color'],
            isShared: $data['is_shared'],
            isFavorite: $data['is_favorite'],
            parentId: $data['parent_id'] ?? null,
            inboxProject: $data['is_inbox_project'],
            teamInbox: $data['is_team_inbox'],
            view: View::from(
                value: $data['view_style'],
            ),
            url: $data['url'],
        );
    }

    /**
     * @return array{
     *     id:string,
     *     name:string,
     *     color:string,
     *     view:View,
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'view' => $this->view,
        ];
    }
}
