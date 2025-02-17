<?php

namespace Models;

use Models\PDOSingleton;
use Interfaces\IActiveRecord;
use PDO;

/**
 * Classe ARBlogs
 * Implémente le pattern Active Record pour gérer les entrées de la table "blogs".
 * 
 * @package Models
 */
class ARSpotify
{
    public $access_token;
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }


    public function SearchTrack($query)
    {
        // Initialiser une session cURL
        $ch = curl_init();

        // Encoder la requête
        $encoded_query = curl_escape($ch, $query);

        // Construire l'URL avec la requête encodée
        $url = "https://api.spotify.com/v1/search?q={$encoded_query}&type=track,playlist&limit=10";

        // Configuration de l'appel API avec cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' .  $this->access_token
        ));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Récupérer le code HTTP
        curl_close($ch);

        // Vérifier si la réponse est JSON valide
        $data = json_decode($response, true);

        // Vérifier si le token est invalide ou expiré
        if ($http_code == 401) {
            return ["error" => "Le token d'accès est invalide ou expiré. Veuillez le renouveler."];
        }

        if (isset($data['error'])) {
            return ["error" => "Erreur Spotify : " . $data['error']['message']];
        }

        return $data;
    }

    public function SearchPlaylist($query)
    {
        // Initialiser une session cURL
        $ch = curl_init();
    
        // Encoder la requête
        $encoded_query = curl_escape($ch, $query);
    
        // Construire l'URL de recherche
        $url = "https://api.spotify.com/v1/search?q={$encoded_query}&type=playlist&limit=5";
    
        // Configuration de l'appel API avec cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->access_token
        ));
    
        // Exécuter la requête
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Récupérer le code HTTP
        curl_close($ch);
    
        // Vérifier si la réponse est JSON valide
        $data = json_decode($response, true);
    
        // Gérer l'expiration du token
        if ($http_code == 401) {
            return ["error" => "Le token d'accès est invalide ou expiré. Veuillez le renouveler."];
        }
    
        // Gérer d'autres erreurs de l'API
        if (isset($data['error'])) {
            return ["error" => "Erreur Spotify : " . $data['error']['message']];
        }
    
        return $data;
    }
    
}
