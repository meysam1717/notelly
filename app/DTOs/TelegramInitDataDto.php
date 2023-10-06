<?php

namespace App\DTOs;

use Carbon\Carbon;

class TelegramInitDataDto implements \JsonSerializable
{


    /**
     * @var array<string, mixed> $initData
     */
    protected array $initData = [];

    protected TelegramUserDto $telegramUserDto;

    public static function fromQuery(string $queryString): self
    {
        $array = explode('&', rawurldecode($queryString));
        $newSelf = new self();
        foreach ($array as $item) {
            $keyValuePair = explode('=', $item);
            $newSelf->initData[$keyValuePair[0]] = $keyValuePair[1];
        }
        $newSelf->telegramUserDto = TelegramUserDto::fromQuery($newSelf->initData['user']);
        return $newSelf;
    }

    public function prepareForValidation(): string
    {
        $result = [];
        foreach ($this->initData as $key => $value) {
            if ($key !== 'hash') {
                $result[] = $key . "=" . $value;
            }
        }
        sort($result);
        return implode("\n", $result);
    }

    public function getInitData(): array
    {
        return $this->initData;
    }

    public function getQueryId(): string
    {
        return $this->initData['query_id'];
    }

    public function getTelegramUserDto(): TelegramUserDto
    {
        return $this->telegramUserDto;
    }

    public function getAuthDate(): Carbon
    {
        return Carbon::createFromTimestamp($this->initData['auth_date']);
    }

    public function getHash(): string
    {
        return $this->initData['hash'];
    }


    public function jsonSerialize(): mixed
    {
        return [
            'initData' => $this->getInitData(),
            'query_id' => $this->getQueryId(),
            'auth_date' => $this->getAuthDate()->toJSON(),
            'hash' => $this->getHash(),
            'user' => $this->getTelegramUserDto(),
        ];
    }
}
