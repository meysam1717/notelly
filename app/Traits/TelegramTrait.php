<?php

namespace App\Traits;

use App\DTOs\TelegramInitDataDto;
use Exception;

trait TelegramTrait
{


    /**
     * @throws Exception
     */
    public function validateInitData(string $initData): bool{
        $botToken = config('telegram.bot_token');
        if (empty($botToken))
        {
            throw new Exception('Telegram bot token could not found in (/config/telegram.php');
        }
        $telegramInitDataDto = TelegramInitDataDto::fromQuery($initData);

        $secret_key = hash_hmac("sha256",  $botToken,"WebAppData", true);
        $calculated_hash = bin2hex(hash_hmac("sha256", $telegramInitDataDto->prepareForValidation(), $secret_key, true));

        return $calculated_hash == $telegramInitDataDto->getHash();
    }

    public function extractInitData(string $initData): TelegramInitDataDto
    {
        return TelegramInitDataDto::fromQuery($initData);
    }

}

