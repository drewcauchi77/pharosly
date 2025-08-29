<?php

namespace App\DTO;

class WorkspaceDTO
{
    /**
     * @param string $name
     * @param int $user_id
     */
    public function __construct(
        public string $name,
        public int $user_id
    ) { }

    /**
     * @return array{
     *     name: string,
     *     user_id: int
     * }
     */
    public function toArray(): array
    {
        return [
            'name' => trim($this->name),
            'user_id' => $this->user_id,
        ];
    }
}
