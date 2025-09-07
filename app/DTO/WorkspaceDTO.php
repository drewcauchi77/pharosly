<?php

namespace App\DTO;

class WorkspaceDTO
{
    /**
     * @param string $name
     * @param array<string> $labels
     * @param string $subdomain
     * @param string|null $domain
     * @param string $path
     * @param int $user_id
     */
    public function __construct(
        public string $name,
        public array $labels,
        public string $subdomain,
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
            'subdomain' => trim($this->subdomain),
            'domain' => $this->domain ? trim($this->domain) : null,
            'path' => trim($this->path),
            'user_id' => $this->user_id,
        ];
    }
}
