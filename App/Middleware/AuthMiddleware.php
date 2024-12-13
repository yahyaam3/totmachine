<?php
namespace App\Middleware;

use Emeset\Contracts\Http\Request;
use Emeset\Contracts\Http\Response;
use Emeset\Contracts\Container;
use Emeset\Middleware as BaseMiddleware;

class AuthMiddleware {
    public function __invoke(Request $request, Response $response, Container $container, $next)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $response->redirect("Location: /login");
            return $response;
        }

        // Continue to next middleware/controller
        $response = BaseMiddleware::next($request, $response, $container, $next);
        return $response;
    }
}