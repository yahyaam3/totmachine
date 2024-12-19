<?php
namespace App\Middleware;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use Emeset\Middleware as BaseMiddleware;

class AdminMiddleware {
    public function __invoke(Request $request, Response $response, Container $container, $next)
    {
        $role = $_SESSION['user_role'] ?? '';
        // Allowed role: ADMINISTRATOR only
        if ($role !== 'ADMINISTRATOR') {
            $response->redirect("Location: /");
            return $response;
        }

        $response = BaseMiddleware::next($request, $response, $container, $next);
        return $response;
    }
} 
