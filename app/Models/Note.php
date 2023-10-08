<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $folder_id
 * @property array $data
 */
class Note extends Model
{

    protected $fillable = [
        'folder_id',
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

    public function setFolderId(int $folder_id): void
    {
        $this->folder_id = $folder_id;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

}
