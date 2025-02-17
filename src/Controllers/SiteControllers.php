<?php

namespace Controllers;

use Exception;
use Models\ARMeteo;
use Models\ARSpotify;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class SiteControllers
{
    public function home(Request $request, Response $response): Response
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $query = "Geneve"; // Ville par défaut
        $meteo = new ARMeteo();
        $weatherData = $meteo->searchWeather($query);
        
        if (!isset($_SESSION['token'])) {
           return $response->withHeader('Location', '/generateKey')->withStatus(302);
        }

        $spotify = new ARSpotify($_SESSION['token']);

        //Vérifier si le token est valide
      

        //Vérification des données météo
        $weatherCondition = 'happy';
        if (isset($weatherData['weather'][0]['description'])) {
            $weatherCondition = strtolower($weatherData['weather'][0]['description']);
        } else {
            error_log("Erreur: Aucune donnée météo reçue.");
        }

        //Correspondance météo → recherche de morceaux Spotify
        $weatherTracks = [
            "ciel clair" => "happy",
            "nuages épars" => "chill",
            "pluie" => "sad",
            "orage" => "rock",
            "neige" => "cozy",
            "Légère pluie" => "relax",
            "Couvert" => "housse",
        ];

        $searchQuery = $weatherTracks[ucfirst($weatherCondition)];
        // Recherche des morceaux Spotify
        $searchResults = $spotify->SearchTrack($searchQuery);
        $tracks = [];

        if (isset($searchResults['tracks']['items'])) {
            foreach ($searchResults['tracks']['items'] as $track) {
                $tracks[] = [
                    'id' => $track['id'],
                    'name' => $track['name'],
                    'artist' => $track['artists'][0]['name']
                ];
            }
        }

        // Préparer les données pour la vue
        $dataDetail = [
            'weather' => ucfirst($weatherCondition),
            'tracks' => $tracks
        ];

        $dataLayout = ['title' => 'Météo & Musique'];
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout);
        $phpView->setLayout("Layout.php");

        return $phpView->render($response, 'Home.php', $dataDetail);
    }
}
