<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>FAS</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
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
                        <a class="nav-link" href="/admPlayer">Player</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admFixture">Fixture</a>
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
                    <a class="btn btn-primary" href="/addFixture">Add fixture</a>
                </div>
                <div class="col">
                    {{-- <form action="/importFixture" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file">
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form> --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Import fixture stats
                      </button>
                </div>
            </div>
            <div class="row">
                <h2>Fixtures</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Home team</th>
                            <th>Away team</th>
                            <th>Function</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $fixture)
                            <tr>
                                <td>{{ $fixture->id }}</td>
                                <td>{{ $fixture->date }}</td>
                                @foreach ($team as $t)
                                    @if ($fixture->h_team == $t->id)
                                        <td>{{ $t->name }}</td>
                                    @endif
                                @endforeach
                                @foreach ($team as $t)
                                    @if ($fixture->a_team == $t->id)
                                        <td>{{ $t->name }}</td>
                                    @endif
                                @endforeach
                                <td><a href="/exportFixture/{{ $fixture->id }}" class="btn btn-primary">Export template</a> |
                                    <a href="/admFixtureStats/{{ $fixture->id }}" class="btn btn-info">See results</a></td>
                                <td><a href="/editFixture/{{ $fixture->id }}" class="btn btn-light">Edit</a> |
                                    <a href="/deleteFixture/{{ $fixture->id }}" class="btn btn-danger">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Modal -->
        <form action="/importFixture" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Import stats</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="fixture">Select fixture</label><br>
                            <select name="fixture" id="fixture">
                                @foreach ($data as $fixture)
                                    @foreach ($team as $t)
                                        @if ($fixture->h_team == $t->id)
                                            @php
                                                $home = $t->name
                                            @endphp
                                        @endif
                                        @if ($fixture->a_team == $t->id)
                                            @php
                                                $away = $t->name
                                            @endphp
                                        @endif
                                    @endforeach
                                    <option value="{{ $fixture->id }}">@php echo $home @endphp vs @php echo $away @endphp {{ $fixture->date }}</option>
                                @endforeach
                            </select><br>
                            <label for="file">Select file</label><br>
                            <input type="file" name="file">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="overlay"></div>
    </body>
</html>


