<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 100vh;
        margin: 0;
    }
    .weather {
        text-align: center;
        background: white;
        color: black;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    .weather h1 {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    .weather p {
        font-size: 1.2rem;
    }
    .error {
        color: red;
        font-weight: bold;
    }
    .button-33 {
        background-color: #dfdfe2;
        border-radius: 100px;
        box-shadow: rgba(0, 0, 0, 0.2) 0 -25px 18px -14px inset,
                    rgba(0, 0, 0, 0.2) 0 1px 2px,
                    rgba(0, 0, 0, 0.2) 0 2px 4px,
                    rgba(0, 0, 0, 0.2) 0 4px 8px,
                    rgba(0, 0, 0, 0.2) 0 8px 16px,
                    rgba(0, 0, 0, 0.2) 0 16px 32px;
        color: rgb(255, 255, 255);
        cursor: pointer;
        display: inline-block;
        font-family: CerebriSans-Regular, -apple-system, system-ui, Roboto, sans-serif;
        padding: 7px 20px;
        text-align: center;
        text-decoration: none;
        transition: all 250ms;
        border: 0;
        font-size: 16px;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
    }
    .button-33:hover {
        box-shadow: rgb(192, 192, 192) 0 -25px 18px -14px inset,
                    rgba(192, 192, 192) 0 1px 2px,
                    rgba(192, 192, 192) 0 2px 4px,
                    rgba(192, 192, 192) 0 4px 8px,
                    rgba(192, 192, 192) 0 8px 16px,
                    rgba(192, 192, 192) 0 16px 32px;
        transform: scale(1.05) rotate(-1deg);
    }
</style>

<div class="weather">
    <h1>Météo</h1>

    <?php  if (!empty($weatherData)): ?>
        <?php if (isset($weatherData['error'])): ?>
            <p class="error"><?= $weatherData['error']; ?></p>
        <?php else: ?>
            <p><strong>Ville :</strong> <?= htmlspecialchars($weatherData['name']); ?></p>
            <p><strong>Température :</strong> <?= round($weatherData['main']['temp']); ?>°C</p>
            <p><strong>Temps :</strong> <?= ucfirst(htmlspecialchars($weatherData['weather'][0]['description'])); ?></p>
        <?php endif; ?>
    <?php else: ?>
        <p>Aucune donnée disponible.</p>
    <?php endif; ?>
</div>

<form method="GET" action="/meteo">
    <input type="text" name="ville" placeholder="Entrez une ville" required>
    <button class="button-33" type="submit">Rechercher</button>
</form>
