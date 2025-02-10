<?php

namespace Controllers;

// Import des classes nécessaires
use Exception;
use Models\ARMeteo;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class MeteoControllers
{
    public function afficherMeteo(Request $request, Response $response, $args): Response
    {
        $query = filter_input(INPUT_GET, 'ville', FILTER_SANITIZE_SPECIAL_CHARS);
        $dataLayout = ['title' => 'Météo'];
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout); 
        $phpView->setLayout("Layout.php"); 
        
        $meteo = new ARMeteo();
        $weatherData = null;

        if (!empty($query)) {
            $weatherData = $meteo->searchWeather($query);

            // Vérification des erreurs de l'API OpenWeatherMap
            if (isset($weatherData['cod']) && $weatherData['cod'] != 200) {
                $weatherData = ['error' => "Ville/Pays/Quartier introuvable ou erreur API."];
            }
        }

        $dataDetail = ['weatherData' => $weatherData];

        return $phpView->render($response, '/Meteo/weather.php', $dataDetail);
    }
}
?>
