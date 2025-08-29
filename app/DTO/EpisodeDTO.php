<?php

namespace App\DTO;

use Illuminate\Support\Facades\Session;

class EpisodeDTO
{
    /**
     * @param string $title
     * @param string $description
     * @param string $video_link
     */
    public function __construct(
        public string $title,
        public string $description,
        public string $video_link,
    ) { }

    /**
     * @return array{
     *     title: string,
     *     description: string,
     *     video_link: string,
     *     workspace_id: int
     * }
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'video_link' => trim($this->video_link),
            'workspace_id' => Session::get('workspace_id'),
        ];
    }
}
