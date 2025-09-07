<?php

namespace App\DTO;

class WorkspaceDTO
{
    /**
     * @param string $name
     * @param array<string> $labels
     * @param string $internal_domain
     * @param string|null $domain
     * @param string $path
     * @param int $user_id
     */
    public function __construct(
        public string $name,
        public array $labels,
        public string $internal_domain,
        public string|null $domain,
        public string $path,
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
            'labels' => json_encode($this->labels),
            'internal_domain' => trim($this->internal_domain),
            'domain' => $this->domain ? trim($this->domain) : null,
            'path' => trim($this->path),
            'user_id' => $this->user_id,
        ];
    }
}
