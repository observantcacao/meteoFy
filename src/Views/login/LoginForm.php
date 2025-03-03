<?php

?>
<div class="container text-center mt-5 bg-dark">
        <h3 class="text-center mb-4">Connexion</h3>
        <form action="/loginPost" method="post">
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" name="pseudo" class="form-control" id="pseudo" placeholder="Entrez votre pseudonyme" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
        <div class="text-center mt-3">
          
        </div>
</div>