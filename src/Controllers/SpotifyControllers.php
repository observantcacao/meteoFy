<?php

namespace Controllers;

// Import des classes nécessaires
use Exception;
use Models\ARSpotify;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

/**
 * Classe contrôleur pour gérer le site
 */
class SpotifyControllers{

    public function generateKey(Request $request, Response $response): Response
    {
        $dataLayout = ['title' => 'Home']; // Données pour le layout
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout); // Instancie le moteur de vue PHP
        $phpView->setLayout("Layout.php"); // Définit le fichier de layout
        return $phpView->render($response, 'GenerateToken.php'); // Rend la vue Home.php
    }
    public function SearchTrack(Request $request, Response $response , $args): Response
    {
        $query = filter_input(INPUT_GET,'search', FILTER_SANITIZE_SPECIAL_CHARS);
       
        $dataLayout = ['title' => 'Home']; // Données pour le layout
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout); // Instancie le moteur de vue PHP
        $phpView->setLayout("Layout.php"); // Définit le fichier de layout
        $track = new ARSpotify();
        ;
        $dataDetail = ['data' => $track->SearchTrack($query)];
        return $phpView->render($response, '/Spotitfy/search.php',$dataDetail); // Rend la vue Home.php
    }

    
}