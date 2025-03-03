<?php

namespace Controllers;

// Import des classes nécessaires
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Models\ARUser;
use Models\Alert;

/**
 * Classe contrôleur pour gérer le site
 */
class UserControllers{

    public function LoginForm(Request $request, Response $response): Response
    {
        $dataLayout = ['title' => 'connexion']; // Données pour le layout
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout); // Instancie le moteur de vue PHP
        $phpView->setLayout("Layout.php"); // Définit le fichier de layout
        return $phpView->render($response, '/login/LoginForm.php'); // Rend la vue Home.php
    }

    public function RegisterForm(Request $request, Response $response): Response
    {
        $dataLayout = ['title' => 'connexion']; // Données pour le layout
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout); // Instancie le moteur de vue PHP
        $phpView->setLayout("Layout.php"); // Définit le fichier de layout
        return $phpView->render($response, '/login/RegisterForm.php'); // Rend la vue Home.php
    }

    public function RegisterPost(Request $request, Response $response): Response
    {
       
    
            
        return $response
            ->withHeader('Location', '/')
            ->withStatus(302); // 302 pour une redirection temporaire 
    }

    public function LoginPost(Request $request, Response $response): Response
    {
       
        return $response
            ->withHeader('Location', '/')
            ->withStatus(302); // 302 pour une redirection temporaire 
    }

    public function logOut(Request $request, Response $response): Response{
        unset($_SESSION['user_connected']);
        Alert::add('success', 'Utilisateur déconnecté');
        return $response
            ->withHeader('Location', '/')
            ->withStatus(302); // 302 pour une redirection temporaire 
    }
}
