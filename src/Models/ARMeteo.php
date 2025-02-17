<?php
namespace Models;

/**
 * Classe ARMeteo
 * Implémente le pattern Active Record pour gérer les entrées de la table "météo".
 * 
 * @package Models
 */
class ARMeteo
{
    private $api_key;

    public function __construct()
    {
        $this->api_key = "c85050cc4360d3e4158207c9065b0219";
    }

    /**
     * Recherche la météo pour une ville donnée
     * 
     * @param string $query Nom de la ville
     * @return array|null Données de la météo ou null en cas d'erreur
     */
    public function searchWeather($query)
    {
        $ch = curl_init();

        $encoded_query = curl_escape($ch, $query);

        $url = "https://api.openweathermap.org/data/2.5/weather?q=$encoded_query&units=metric&lang=fr&appid=".$this->api_key;

        // Configuration de l'appel API avec curl
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Exécution de la requête
        $response = curl_exec($ch);

        // Vérification des erreurs cURL
        if ($response === false) {
            error_log("Erreur cURL : " . curl_error($ch));
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        // Décoder la réponse JSON
        $data = json_decode($response, true);

        // Vérifier si la réponse JSON est valide
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Erreur JSON : " . json_last_error_msg());
            return null;
        }

        return $data;
    }
}
?>
