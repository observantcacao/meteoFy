<?php

namespace Controllers;

// Import des classes nécessaires
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

/**
 * Classe contrôleur pour gérer le site
 */
class SiteControllers
{
    public function home(Request $request, Response $response): Response
    {
        $dataLayout = ['title' => 'Home']; // Données pour le layout
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout); // Instancie le moteur de vue PHP
        $phpView->setLayout("Layout.php"); // Définit le fichier de layout
        return $phpView->render($response, 'Home.php'); // Rend la vue Home.php
    }


}