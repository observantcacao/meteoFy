<?php
//session_start();

// Spotify App credentials
$clientId = '4de97f0d1f7c43c08cd74d482bf00dee';
$clientSecret = '134f9146d040440bbdbc561ccde31e35';
$redirectUri = 'http://meteofy/';

// URL d'authentification
$authUrl = 'https://accounts.spotify.com/authorize?' . http_build_query([
    'client_id' => $clientId,
    'response_type' => 'code',
    'redirect_uri' => $redirectUri,
    'scope' => 'user-library-read user-read-playback-state user-read-private playlist-modify-public playlist-modify-private',
    'show_dialog' => 'true',
]);

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Échange du code contre un token
    $tokenUrl = 'https://accounts.spotify.com/api/token';
    $data = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirectUri,
        'client_id' => $clientId,
        'client_secret' => $clientSecret
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['access_token'])) {
        $_SESSION['token'] = $responseData['access_token'];
        $_SESSION['refresh_token'] = $responseData['refresh_token'];
        $_SESSION['token_time'] = time();

        echo "Token obtenu avec succès!";
    } else {
        echo "Erreur lors de l'obtention du token.<br>";
        echo "Réponse API : " . print_r($responseData, true);
    }
} else {
    // Redirection pour l'authentification
    header('Location: ' . $authUrl);
    exit;
}
