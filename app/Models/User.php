<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer $id
 * @property integer $telegram_id
 * @property ?string $first_name
 * @property ?string $last_name
 * @property ?string $username
 * @property ?string $language_code
 * @property ?boolean $allows_write_to_pm
 */
class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'telegram_id',
        'first_name',
        'last_name',
        'username',
        'language_code',
        'allows_write_to_pm',
    ];

    protected $casts= [
        'allows_write_to_pm' => 'boolean'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getTelegramId(): int
    {
        return $this->telegram_id;
    }

    public function setTelegramId(int $telegram_id): self
    {
        $this->telegram_id = $telegram_id;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getLanguageCode(): ?string
    {
        return $this->language_code;
    }

    public function setLanguageCode(?string $language_code): self
    {
        $this->language_code = $language_code;
        return $this;
    }

    public function getAllowsWriteToPm(): ?bool
    {
        return $this->allows_write_to_pm;
    }

    public function setAllowsWriteToPm(?bool $allows_write_to_pm): self
    {
        $this->allows_write_to_pm = $allows_write_to_pm;
        return $this;
    }





}
