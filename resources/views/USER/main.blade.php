<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>FAS</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/main.css">

    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="/"><img src="/images/logo.png" alt="FootBall" width="70" height="70"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Main</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/teams">Teams</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/leagues">Leagues</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/players">Players</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/fixtures">Fixtures</a>
                </li>
                </ul>
              </div>
              <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Sign in</a>
                    </li>
                </ul>
              </div>
            </div>
          </nav>
          {{-- <div id="wg-api-football-standings"
                data-host="v3.football.api-sports.io"
                data-key="d2254d5e6d2984b3e9176c33abd175d9"
                data-league="39"
                data-team=""
                data-season="2022"
                data-theme=""
                data-show-errors="false"
                data-show-logos="true"
                class="wg_loader">
            </div> --}}
            {{-- <div id="wg-api-football-games"
                data-host="v3.football.api-sports.io"
                data-key="d2254d5e6d2984b3e9176c33abd175d9"
                data-date=""
                data-league=""
                data-season=""
                data-theme=""
                data-refresh="15"
                data-show-toolbar="true"
                data-show-errors="false"
                data-show-logos="false"
                data-modal-game="true"
                data-modal-standings="true"
                data-modal-show-logos="true">
            </div> --}}
            <div class="overlay"></div>
    </body>
</html>
{{-- <script
    type="module"
    src="https://widgets.api-sports.io/2.0.3/widgets.js">
</script> --}}
