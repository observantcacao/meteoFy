<?php

use Models\SessionMiddleware;
use Slim\Factory\AppFactory;

// Activer le chargement automatique des classes
require __DIR__ .'/../../vendor/autoload.php';

$app = AppFactory::create() ;

// Ajouter le middleware de session
$app->add(new Models\SessionMiddleware());

$app->addErrorMiddleware(true, true, true);

require __DIR__ .'/../Routes/Web.php';

$app->run();
