<div class="container text-center mt-5 bg-dark">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb text-white">
            <li class="breadcrumb-item"><a href="/admin">Retour</a></li>
            <li class="breadcrumb-item active" aria-current="page">logs</li>
        </ol>
    </nav>
    <h1 class="mb-4">Status des Api</h1>

    <div class="container mt-5 d-flex justify-content-center gap-3">
        <!-- Carte Verte -->
         <?php
         use Models\ARSpotify;
         use Models\ARMeteo;
         use Models\ActLogger;
         try {
             $spotify = new ARSpotify($_SESSION['token']);
             $testResponse = $spotify->SearchTrack("test");
             if (isset($testResponse['error'])) {
                echo '<div class="card text-white bg-danger" style="max-width: 18rem;">
            <div class="card-header">Spotify API</div>
            <div class="card-body">
                <p class="card-text">Erreur veuillez vérifier les informations depuis le site du fournisseur</p>
            </div>
        </div>'; 
        ActLogger::log('CRITIQUE : API Spotify ne répond pas','critical'); 
             }else{
                echo '<div class="card text-white bg-success" style="max-width: 18rem;">
            <div class="card-header">Spotify API</div>
            <div class="card-body">
                <p class="card-text">L\'Api n\'a aucun soucis</p>
            </div>
        </div>';
        ActLogger::log('Information : L\'Api Spotify n\'a aucun soucis','info');
             }
         } catch (\Throwable $th) {
            echo '<div class="card text-white bg-danger" style="max-width: 18rem;">
            <div class="card-header">Spotify API</div>
            <div class="card-body">
                <p class="card-text">Erreur veuillez vérifier les informations depuis le site du fournisseur</p>
            </div>
        </div>';
        ActLogger::log('CRITIQUE : API Spotify ne répond pas','critical');   
         }

         try {
            $meteo = new ARMeteo();
            $weatherData = null;

            $weatherData = $meteo->searchWeather("Genève");

            // Vérification des erreurs de l'API OpenWeatherMap
            if (isset($weatherData['cod']) && $weatherData['cod'] != 200) {
                echo '<div class="card text-white bg-danger" style="max-width: 18rem;">
            <div class="card-header">Meteo API</div>
            <div class="card-body">
                <p class="card-text">Erreur veuillez vérifier les informations depuis le site du fournisseur</p>
            </div>
        </div>';
        ActLogger::log('CRITIQUE : API Meteo ne répond pas','critical');
            }else{
                echo '<div class="card text-white bg-success" style="max-width: 18rem;">
            <div class="card-header">Meteo API</div>
            <div class="card-body">
                <p class="card-text">L\'Api n\'a aucun soucis</p>
            </div>
        </div>';
        ActLogger::log('Information : L\'Api Meteo n\'a aucun soucis','info');
            }
         } catch (\Throwable $th) {
            echo '<div class="card text-white bg-danger" style="max-width: 18rem;">
            <div class="card-header">Meteo API</div>
            <div class="card-body">
                <p class="card-text">Erreur veuillez vérifier les informations depuis le site du fournisseur</p>
            </div>
        </div>';  
        ActLogger::log('CRITIQUE : API Meteo ne répond pas','critical'); 
         }
         ?>
        

    </div>
</div>