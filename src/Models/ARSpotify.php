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
    private $access_token;
    public function __construct()
    {
        $this->access_token = "BQDAC1RejSKMe_S0w4WMJc91sDRdre7ar-NqtwA67UBpPFJhV2fhQxqvwYFgs2ARDc2HGTDRl5eYW-Oy4omtztA3khSJty6P4gRJbH7rHxeJvQF5fHBCfH-wzS1NZJOM_9nViSOfpGzmKldbT8301forqfkK7uY4XqY2ynB90v4Njys3sj_IngWWHMXQlwi3KU8xJmDPyqMmTGxN59dZ1sKi3GvrR_dxjjB0MAwRwoUkdiSX2m0VqOPt8VKyDkYOPXD8ISyA074GQPGtkxWQiUbOlB752WVV1l_nnquqy2li2jk38BSyXgT6DUFkhyCJ3A";
    }

    /**
     * Crée une nouvelle entrée dans la table "blogs".
     * Initialise l'identifiant de l'objet après insertion.
     * 
     * @return void
     */
    public function SearchTrack($query)
    {
        // Initialiser une session cURL
        $ch = curl_init();
    
        // Encoder la requête
        $encoded_query = curl_escape($ch, $query);
    
        // Construire l'URL avec la requête encodée
        $url = "https://api.spotify.com/v1/search?q={$encoded_query}&type=track,playlist&limit=5";
    
        // Configuration de l'appel API avec cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' .  $this->access_token
        ));
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        // Décoder la réponse JSON
        $data = json_decode($response, true);
        return $data;
    }
    
    public function SearchPlaylist($query) {}
}
