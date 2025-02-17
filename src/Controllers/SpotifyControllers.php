<?php

namespace Controllers;

use Exception;
use Models\Alert;
use Models\ARMeteo;
use Models\ARSpotify;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;


class SpotifyControllers
{
    private $clientId = '4de97f0d1f7c43c08cd74d482bf00dee';
    private $clientSecret = '134f9146d040440bbdbc561ccde31e35';
    private $redirectUri = 'http://meteofy.loc/callback';

    public function generateKey(Request $request, Response $response): Response
    {
        $authUrl = 'https://accounts.spotify.com/authorize?' . http_build_query([
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'redirect_uri' => $this->redirectUri,
            'scope' => 'user-library-read user-read-playback-state user-read-private playlist-modify-public playlist-modify-private',
            'show_dialog' => 'true',
        ]);

        return $response->withHeader('Location', $authUrl)->withStatus(302);
    }

    public function callback(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();
        if (!isset($queryParams['code'])) {
            $response->getBody()->write("Erreur: Code d'autorisation non reçu.");
            return $response->withStatus(400);
        }

        $code = $queryParams['code'];
        $tokenUrl = 'https://accounts.spotify.com/api/token';

        $data = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

        $responseData = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (isset($responseData['access_token'])) {
            $_SESSION['token'] = $responseData['access_token'];
            $_SESSION['refresh_token'] = $responseData['refresh_token'];
            $_SESSION['token_time'] = time();
           
            return $response->withHeader('Location', '/')->withStatus(302);
        } else {
            $response->getBody()->write("Erreur lors de l'obtention du token : " . print_r($responseData, true));
            return $response->withStatus(400);
        }
    }

    public function SearchTrack(Request $request, Response $response, $args): Response
    {
        $query = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
      
        if ($query == '') {
            return $response->withHeader('Location', '/')->withStatus(302);
            
        }
        if (!isset($_SESSION['token'])) {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }
    
        $spotify = new ARSpotify($_SESSION['token']);
        
     
        $testResponse = $spotify->SearchTrack("test");
        
        if (isset($testResponse['error']) && $testResponse['error']['status'] == 401) {
            unset($_SESSION['token']);
            return $response->withHeader('Location', '/login')->withStatus(302);
        }
    
        
        $dataDetail = ['data' => $spotify->SearchTrack($query)];
    
        $dataLayout = ['title' => 'Home'];
        $phpView = new PhpRenderer(__DIR__ . '/../Views', $dataLayout);
        $phpView->setLayout("Layout.php");
    
        return $phpView->render($response, '/Spotitfy/search.php', $dataDetail);
    }
    
    
    
    
}
