<?php
session_start();

// Spotify App credentials
$clientId = '4de97f0d1f7c43c08cd74d482bf00dee';
$clientSecret = '134f9146d040440bbdbc561ccde31e35';
$redirectUri = 'http://meteofy/';

$authUrl = 'https://accounts.spotify.com/authorize?' . http_build_query([
    'client_id' => $clientId,
    'response_type' => 'code',
    'redirect_uri' => $redirectUri,
    'scope' => 'user-library-read user-read-playback-state user-read-private playlist-modify-public playlist-modify-private',
    'show_dialog' => 'true',
]);


if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Token exchange
    $tokenUrl = 'https://accounts.spotify.com/api/token';
    $data = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirectUri,
    ];

    $headers = [
        'Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret),
    ];

    // cURL request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    }

    curl_close($ch);

    // Debug the API response
    $responseData = json_decode($response, true);
    if (isset($responseData['access_token'])) {
        $_SESSION['token'] = $responseData['access_token'];
        echo "Token successfully obtained!";
    } else {
        echo "Erreur lors de l'obtention du token.<br>";
        echo "Réponse API : " . print_r($responseData, true);  // Show full response
    }
} else {
    // Redirect for authorization
    header('Location: ' . $authUrl);
    exit;
}
?>
