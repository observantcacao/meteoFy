<?php
use Controllers\SiteControllers;
use Controllers\UserControllers;
use Models\PDOSingleton;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', [SiteControllers::class, 'home']);
$app->get("/search",function ( Request $request , Response $response ) {$response->getBody()->write('<p>page ou les recherche seront afficher</p>'); return $response ; });

$app->get("/login",[UserControllers::class, 'LoginForm']);
$app->get("/register",[UserControllers::class, 'RegisterForm']);
$app->get("/logOut",function ( Request $request , Response $response ) {$response->getBody()->write('<p>deconexion</p>'); return $response ; });
$app->post("/loginPost",function ( Request $request , Response $response ) {$response->getBody()->write('<p>page de connexion</p>'); return $response ; });

$app->get("/admin",function ( Request $request , Response $response ) {$response->getBody()->write('<p>page ou il y les informations admin</p>'); return $response ; });
$app->get("/admin/logs",function ( Request $request , Response $response ) {$response->getBody()->write('<p>page ou il y les informations admin</p>'); return $response ; });
$app->get("/admin/apiStatus",function ( Request $request , Response $response ) {$response->getBody()->write('<p>page ou il y les informations admin</p>'); return $response ; });