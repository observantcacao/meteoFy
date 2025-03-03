<div class="container text-center mt-5 bg-dark">
    <h1 class="mb-4">Bienvenue sur les sons de votre météo</h1>
    <p class="lead">mettre contenu ici (remplacer le p)</p>
    <a href="/generate">generer un token</a>
    <h2>Conditions météo : <?= htmlspecialchars($weather) ?></h2>

<?php if (!empty($tracks)): ?>
    <?php foreach ($tracks as $track): ?>
        <div style='margin-bottom: 10px;'>
           
            <iframe
                title='Spotify Embed: Track'
                src='https://open.spotify.com/embed/track/<?= htmlspecialchars($track['id']) ?>?utm_source=generator&theme=0'
                width='100%'
                height='80'
                frameborder='0'
                style='border-radius: 8px;'
                allow='autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture'
                loading='lazy'>
            </iframe>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucune musique disponible pour cette météo.</p>
<?php endif; ?>




</div>