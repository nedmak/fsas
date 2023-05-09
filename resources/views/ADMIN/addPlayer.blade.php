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
                <div class="col-md-6">
                    <h2>Add Player</h2>
                    <form action="/savePlayer" method="post">
                        @csrf
                        <div class="md-3">
                            <label for="name" style="color: white">Enter player name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                        </div>
                        <div class="md-3">
                            <label for="lastname" style="color: white">Enter player last name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Lastname">
                        </div>
                        <div class="md-3">
                            <label for="age" style="color: white">Enter player age</label>
                            <input type="text" class="form-control" name="age" id="age" placeholder="Age">
                        </div>
                        <div class="md-3">
                            <label for="number" style="color: white">Enter player number</label>
                            <input type="text" class="form-control" name="number" id="number" placeholder="Number">
                        </div>
                        <div class="md-3">
                            <label for="position" style="color: white">Select player position</label>
                            <select name="position" id="position" class="form-control">
                                <option value="Goalkeeper">Goalkeeper</option>
                                <option value="Defender">Defender</option>
                                <option value="Midfielder">Midfielder</option>
                                <option value="Attacker">Attacker</option>
                            </select>
                        </div>
                        <div class="md-3">
                            <label for="team" style="color: white">Select team</label>
                            <select name="team" id="team" class="form-control">
                                @foreach ($data as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md-3">
                            <label for="email" style="color: white">Enter player email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="md-3">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 20px">Save</button>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex justify-content-end">
                                    <a href="/admPlayer" class="btn btn-danger"style="margin-top: 20px">Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
    </body>
</html>
