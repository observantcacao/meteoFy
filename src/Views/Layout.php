<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MeteoFy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">MeteoFy</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Navigations</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link" href="/">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/login">ce connecter</a>
          </li>
          
          <!-- ADMIN ONLY -->
          <li class="nav-item">
            <a class="nav-link" href="/admin">admin</a>
          </li>
          <!-- /ADMIN ONLY -->

        </ul>
        <form class="d-flex mt-3" role="search" action="/searchTrack" method="get">
          <input class="form-control me-2" name="search" type="search" placeholder="rechercher un titre" aria-label="Search">
          <button class="btn btn-info" type="submit">chercher</button>
        </form>
      </div>
    </div>
  </div>
</nav>

    <div class="container">
        <div class="row my-3">
            <div class="col">
            <?= /*\Models\Alert::displayHtml()*/"" ?>
            </div>
        </div>

        <?= $content ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>