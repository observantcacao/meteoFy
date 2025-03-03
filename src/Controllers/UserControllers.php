<?php

namespace Controllers;

// Import des classes nécessaires
use Exception;
use Models\ActLogger;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Models\Alert;
use Models\ARUser;
/**
 * Classe contrôleur pour gérer le site
 */
class UserControllers{
private int $nbrErreur = 0;

    public function LoginForm(Request $request, Response $response): Response
    {
        $dataLayout = ['title' => 'connexion']; // Données pour le layout
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout); // Instancie le moteur de vue PHP
        $phpView->setLayout("Layout.php"); // Définit le fichier de layout
        return $phpView->render($response, '/login/LoginForm.php'); // Rend la vue Home.php
    }

    public function LoginPost(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();
        $pseudo = $body['pseudo'];
        $password = $body['password'];

        if (ARUser::isValid($pseudo, $password)) {
            Alert::add('success', 'L\'utilisateur a été identifié');
            ActLogger::log('Information : un utilisateur s\'est connecté : '.$pseudo,'info');
        }  else {
            if ($this->nbrErreur >= 3) {
                ActLogger::log('CRITICAL : L\'utilisateur '.$pseudo.' tente de rentrer sur le compte (+ de 3 erreur au mot de passe) ','warning');
            }else{
                ActLogger::log('Erreur : échec lors de la connexion pour '.$pseudo,'warning');
                $this->nbrErreur ++;
            }
            Alert::add('danger', 'Username et/ou password inconnus !');
            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302); // 302 pour une redirection temporaire 
        }
        $_SESSION['username'] = $pseudo;
        return $response
            ->withHeader('Location', '/')
            ->withStatus(302); // 302 pour une redirection temporaire 
    }

    public function logOut(Request $request, Response $response): Response{
        ActLogger::log('Information : L\'utilisaeur '.$_SESSION['username'].' s\'est déconnecté','info');
        unset($_SESSION['username']);
        Alert::add('success', 'Utilisateur déconnecté');
        return $response
            ->withHeader('Location', '/')
            ->withStatus(302); // 302 pour une redirection temporaire 
    }
}
