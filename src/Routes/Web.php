<?php
use Controllers\SiteControllers;
use Controllers\TasksControllers;
use Controllers\UserControllers;
use Models\PDOSingleton;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', [SiteControllers::class, 'home']);