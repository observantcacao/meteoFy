<?php
// Paramètres Spotify
$clientId = '4de97f0d1f7c43c08cd74d482bf00dee';  // Remplace par ton Client ID
$clientSecret = '134f9146d040440bbdbc561ccde31e35';  // Remplace par ton Client Secret
$redirectUri = 'http://meteoFy/';  // URI de redirection que tu as définie dans l'application Spotify

// URL d'autorisation
$authUrl = 'https://accounts.spotify.com/authorize?' . http_build_query([
    'client_id' => $clientId,
    'response_type' => 'code',
    'redirect_uri' => $redirectUri,
    'scope' => 'user-library-read user-read-playback-state user-read-private playlist-modify-public playlist-modify-private',
]);

// Si le code est passé dans l'URL, échange-le contre un token
if (isset($_GET['code'])) {
    $code = $_GET['code'];
   
    // Échange du code pour obtenir le token
    $tokenUrl = 'https://accounts.spotify.com/api/token';
    $data = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirectUri,
    ];

    $headers = [
        'Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret),
    ];

    // Envoi de la requête cURL pour obtenir le token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    // Décodage de la réponse JSON
    $responseData = json_decode($response, true);
    if (isset($responseData['access_token'])) {
        $accessToken = $responseData['access_token'];
        echo "Token d'accès : " . $accessToken;
        // Tu peux maintenant utiliser ce token pour effectuer des appels API Spotify
    } else {
        echo "Erreur lors de l'obtention du token.";
    }
} else {
    // Rediriger vers Spotify pour obtenir le code d'autorisation
    header('Location: ' . $authUrl);
    exit;
}
?>
