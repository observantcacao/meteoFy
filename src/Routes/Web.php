<?php
use Controllers\AdminControllers;
use Controllers\SiteControllers;
use Controllers\SpotifyControllers;
use Controllers\UserControllers;
use Models\PDOSingleton;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', [SiteControllers::class, 'home']);
$app->get("/searchTrack",[SpotifyControllers::class, 'searchTrack']);

$app->get("/generate",[SpotifyControllers::class, 'generateKey']);
$app->get("/callback",[SpotifyControllers::class, 'callback']);
$app->get("/login",[UserControllers::class, 'LoginForm']);
$app->get("/register",[UserControllers::class, 'RegisterForm']);
$app->get("/logout",[UserControllers::class, 'LogOut']);
$app->post("/loginPost",[UserControllers::class, 'loginPost']);
$app->post("/registerPost",[UserControllers::class, 'RegisterPost']);

$app->get("/admin",[AdminControllers::class, 'home']);
$app->get("/admin/logs",[AdminControllers::class, 'pageLog']);
$app->get("/admin/apiStatus",[AdminControllers::class, 'pageApiStatus']);