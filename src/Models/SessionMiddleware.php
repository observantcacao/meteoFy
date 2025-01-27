<?php
namespace Models;

class SessionMiddleware
{
    public function __invoke($request, $handler)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $response = $handler->handle($request);
        return $response;
    }
}