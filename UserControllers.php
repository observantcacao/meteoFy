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
        try {
            
            $body = $request->getParsedBody();
            $pseudo = $body['pseudo'];
            $password = password_hash($body['password'],PASSWORD_DEFAULT);
            
            $utilisateur = new ARUser();
            $utilisateur->hashPassword = $password;
            $utilisateur->pseudo = $pseudo;
            $utilisateur->create();
            if (ARUser::isValid($pseudo, $password)) {
                Alert::add('success', 'L\'utilisateur a été ajouté');
        } 
        } catch (\Throwable $th) {
            Alert::add('warning',"nom d'utilisateur deja pris");
            return $response
            ->withHeader('Location', '/register')
            ->withStatus(302);
        }
            
        return $response
            ->withHeader('Location', '/')
            ->withStatus(302); // 302 pour une redirection temporaire 
    }

    public function LoginPost(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();
        $pseudo = $body['pseudo'];
        $password = password_hash($body['password'],);

        Alert::add("warning",$pseudo);
        Alert::add("warning",$password);
        if (ARUser::isValid($pseudo, $password)) {
            Alert::add('success', 'L\'utilisateur a été identifié');

        } else {
            Alert::add('danger', 'Username et/ou password inconnus !');
            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302); // 302 pour une redirection temporaire 
        }
        $_SESSION['user_connected'] = ARUser::findIDViaUser($pseudo)->id;
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