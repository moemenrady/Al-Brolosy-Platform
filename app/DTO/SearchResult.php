<?php

namespace App\DTO;

final class SearchResult
{
    public int $id;
    public string $type;
    public string $title;
    public ?string $subtitle;
    public ?string $description;
    public ?string $image;
    public ?string $url;
    public ?string $icon;
    public ?string $badge;
    public int $score;
    public array $metadata;

    public function __construct(
        int $id,
        string $type,
        string $title,
        ?string $subtitle = null,
        ?string $description = null,
        ?string $image = null,
        ?string $url = null,
        ?string $icon = null,
        ?string $badge = null,
        int $score = 0,
        array $metadata = []
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->description = $description;
        $this->image = $image;
        $this->url = $url;
        $this->icon = $icon;
        $this->badge = $badge;
        $this->score = $score;
        $this->metadata = $metadata;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'image' => $this->image,
            'url' => $this->url,
            'icon' => $this->icon,
            'badge' => $this->badge,
            'score' => $this->score,
            'metadata' => $this->metadata,
        ];
    }
}
