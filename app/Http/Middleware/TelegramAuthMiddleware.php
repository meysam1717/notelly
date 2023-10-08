<?php

namespace App\Http\Middleware;

use App\UseCases\Auth\LoginByTelegramUseCase;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TelegramAuthMiddleware
{

    public function __construct(
        private readonly LoginByTelegramUseCase $loginByTelegramUseCase,
    )
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        try {
            $initData = $request->header('init-data');
            $isValidData = $this->loginByTelegramUseCase->execute($initData);
            if (!$isValidData){
                throw new ValidationException('Telegram data is not valid');
            }
        }catch (Exception $e){
            abort(403, $e->getMessage());
        }
        return $next($request);
    }
}
