<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>FAS</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/adm.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="/"><img src="/images/VS.png" alt="FootBall" width="140" height="70"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link" aria-current="page" href="/admin">Main</a>
                    </li>
                      <li class="nav-item">
                        <a class="nav-link" href="/admTeam">Team</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="/admPlayer">Player</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="/admFixture">Fixture</a>
                    </li>
                </ul>
              </div>
              <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link me-2" href="/logout">Sign out</a>
                    </li>
                </ul>
              </div>
            </div>
        </nav>

        <div class="container" style="margin-top: 20px">
            <div class="row">
                <div class="col">
                    <a class="btn btn-primary" href="/addPlayer">Add new Player</a>
                </div>
                <div class="col">
                    <a class="btn btn-primary" href="/export">Excel template</a>
                </div>
                <div class="col">
                    <form action="/importPlayer" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file">
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <h2>PLAYERS</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Last name</th>
                            <th>Age</th>
                            <th>Number</th>
                            <th>Position</th>
                            <th>Team</th>
                            <th>Function</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $players)
                            <tr>
                                <td>{{ $players->id }}</td>
                                <td>{{ $players->name }}</td>
                                <td>{{ $players->lastname }}</td>
                                <td>{{ $players->age }}</td>
                                <td>{{ $players->number }}</td>
                                <td>{{ $players->position }}</td>
                                @foreach ($team as $t)
                                    @if ($players->teamID == $t->id)
                                        <td>{{ $t->name }}</td>
                                    @endif
                                @endforeach
                                <td><a class="btn btn-primary" href="/editPlayer/{{ $players->id }}">Edit</a>|
                                    <a class="btn btn-danger" href="/deletePlayer/{{ $players->id }}">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="overlay"></div>
    </body>
</html>
