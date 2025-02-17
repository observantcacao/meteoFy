<?php

use Controllers\AdminControllers;
use Controllers\MeteoControllers;
use Controllers\SiteControllers;
use Controllers\SpotifyControllers;
use Controllers\UserControllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', [SiteControllers::class, 'home']);

$app->get( '/searchTrack[/]', [SpotifyControllers::class, 'SearchTrack']);
$app->get("/login",[UserControllers::class, 'LoginForm']);
$app->get("/logout",[UserControllers::class, 'LogOut']);
$app->post("/loginPost",[UserControllers::class, 'LoginPost']);

// Routes pour l'authentification Spotify
$app->get("/generate", [SpotifyControllers::class, 'generateKey']);
$app->get("/callback", [SpotifyControllers::class, 'callback']); // Ajout de cette route

// Routes administrateur
$app->get("/admin", [AdminControllers::class, 'home']);
$app->get("/admin/logs", function (Request $request, Response $response) {
    $response->getBody()->write('<p>Page avec les informations admin</p>');
    return $response;
});
$app->get("/admin/apiStatus", function (Request $request, Response $response) {
    $response->getBody()->write('<p>Page avec le statut de lAPI</p>');
    return $response;
});
$app->get("/meteo",[MeteoControllers::class, 'afficherMeteo']);