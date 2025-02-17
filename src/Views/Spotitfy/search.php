<?php 
echo '<h2 style="text-align: center;margin-top:5vh;">Résultats de la recherche :</h2>';

// Conteneur principal pour les pistes et playlists
echo '<div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;">';

// Colonne des pistes (à gauche)
echo '<div style="width: 50%; box-sizing: border-box;">';
if (isset($data['tracks']['items']) && !empty($data['tracks']['items'])) {
    echo '<h3 style="margin-bottom: 10px;">Pistes :</h3>';
    foreach ($data['tracks']['items'] as $index => $track) {
        $track_id = $track['id'];
        echo "<div style='margin-bottom: 10px;'>
            <iframe
                title='Spotify Embed: Track'
                src='https://open.spotify.com/embed/track/{$track_id}?utm_source=generator&theme=0'
                width='100%'
                height='80'
                frameborder='0'
                style='border-radius: 8px;'
                allow='autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture'
                loading='lazy'
                data-player-id='track-$index'>
            </iframe>";
        $track_name = $track['name'];
        $artist_name = $track['artists'][0]['name'];
        echo "
        </div>";
    }
} else {
    echo "<p>Aucune piste trouvée pour la recherche '$query'.</p>";
}
echo '</div>'; // Fin de la colonne des pistes

// Colonne des playlists (à droite)
echo '<div style="width: 50%; box-sizing: border-box;">';
$count = 0;
if (isset($data['playlists']['items']) && !empty($data['playlists']['items'])) {
    echo '<h3 style="margin-bottom: 15px;">Playlists :</h3>';
    foreach ($data['playlists']['items'] as $index => $playlist) {
        if($count <= 2){
            if (isset($playlist['id'])) {
                $playlist_id = $playlist['id'];
                echo "<div style='margin-bottom: 20px;'>
                    <iframe
                        title='Spotify Embed: Playlist'
                        src='https://open.spotify.com/embed/playlist/{$playlist_id}?utm_source=generator&theme=0'
                        width='100%'
                        height='500'
                        frameborder='0'
                        style='border-radius: 8px;'
                        allow='autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture'
                        loading='lazy'
                        data-player-id='playlist-$index'>
                    </iframe>";
                $playlist_name = $playlist['name'];
                $owner_name = $playlist['owner']['display_name'];
                echo "<p style='margin: 5px 0 0 0;'><strong>$playlist_name</strong> par $owner_name</p>
                </div>";
                $count ++;
            } else {
              
            }
        }
        
    }
} else {
    echo "<p>Aucune playlist trouvée pour la recherche '$query'.</p>";
}
echo '</div>'; // Fin de la colonne des playlists

echo '</div>'; // Fin du conteneur principal
?>
