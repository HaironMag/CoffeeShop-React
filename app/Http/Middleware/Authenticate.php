<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Этот метод вызывает authenticate() из родительского класса
        // который в свою очередь вызовет redirectTo() при неудачной аутентификации
        return parent::handle($request, $next, ...$guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Для API запросов возвращаем null, чтобы не было редиректа
        if ($request->expectsJson() || $request->is('api/*')) {
            return null;
        }
        
        // Для веб-запросов возвращаем строку пути
        return '/auth/login';
    }
}