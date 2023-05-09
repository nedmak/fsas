<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>FAS</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/users.css">

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
                      <a class="nav-link" href="/">Main</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/teams">Teams</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/leagues">Leagues</a>
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
        <div class="container">
            <div class="row">
                <h2>LEAGUES STATS</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>This</th>
                            <th>IS</th>
                            <th>for</th>
                            <th>Lreague</th>
                            <th>Stats</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($data as $leagues)
                            <tr>
                                <td>{{ $leagues->id }}</td>
                                <td>{{ $leagues->name }}</td>
                                <td>{{ $leagues->type }}</td>
                                <td>{{ $leagues->country }}</td>
                                <td>{{ $leagues->season }}</td>
                                <td>{{ $leagues->start }}</td>
                                <td>{{ $leagues->end }}</td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
