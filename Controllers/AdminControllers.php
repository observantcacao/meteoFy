<?php

namespace Controllers;

// Import des classes nécessaires
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

/**
 * Classe contrôleur pour gérer les page admins
 */
class AdminControllers
{
    public function home(Request $request, Response $response): Response
    {
        $dataLayout = ['title' => 'Home']; // Données pour le layout
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout); // Instancie le moteur de vue PHP
        $phpView->setLayout("Layout.php"); // Définit le fichier de layout
        return $phpView->render($response, '/admin/Home.php'); // Rend la vue Home.php
    }

    public function pageLog(Request $request, Response $response): Response
    {
        $dataLayout = ['title' => 'Home']; // Données pour le layout
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout); // Instancie le moteur de vue PHP
        $phpView->setLayout("Layout.php"); // Définit le fichier de layout

        $json = file_get_contents('/../log/logMeteoFy.log');

        if ($json === false) {
            die('erreur lors de la lecture du dossier log');
        }

        $json_data = json_decode($json);
        $dataDetail = ['logs' => $json_data];
        return $phpView->render($response, '/admin/Logs.php',$dataDetail); // Rend la vue Home.php
    }

    public function pageApiStatus(Request $request, Response $response): Response
    {
        $dataLayout = ['title' => 'Home']; // Données pour le layout
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout); // Instancie le moteur de vue PHP
        $phpView->setLayout("Layout.php"); // Définit le fichier de layout
        
        return $phpView->render($response, '/admin/ApiStatus.php'); // Rend la vue Home.php

    }
}