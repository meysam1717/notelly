<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $folder_id
 * @property string $title
 * @property ?array $data
 */
class Note extends Model
{

    protected $fillable = [
        'folder_id',
        'title',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getFolderId(): int
    {
        return $this->folder_id;
    }

    public function setFolderId(int $folder_id): self
    {
        $this->folder_id = $folder_id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return ?array<string, mixed>
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param ?array<string, mixed> $data
     */
    public function setData(?array $data): self
    {
        $this->data = $data;
        return $this;
    }

}
