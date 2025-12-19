<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FixCorsHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Убираем возможные дублирования заголовков
        $response->headers->remove('Access-Control-Allow-Origin');
        $response->headers->remove('Access-Control-Allow-Methods');
        $response->headers->remove('Access-Control-Allow-Headers');
        
        // Устанавливаем правильные заголовки один раз
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        
        return $response;
    }
}