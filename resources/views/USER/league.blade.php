<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>FAS</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
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
            <div class="col-md-6">
                <form action="/leagues">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <select name="filter" class="form-control">
                                    <option value="">Default</option>
                                    <optgroup label="Type">
                                        <option value="League">League</option>
                                        <option value="Cup">Cup</option>
                                    </optgroup>
                                    <optgroup label="Country">
                                        @php
                                            $arr = array();
                                            $i = 0;
                                        @endphp
                                        @foreach ($all as $leagues)
                                            @if (!in_array($leagues->country, $arr))
                                                <option value='{{ $leagues->country }}'>{{ $leagues->country }}</option>
                                                @php
                                                    $arr[$i] = "$leagues->country";
                                                    $i = $i + 1;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </optgroup>
                                    {{-- <optgroup label="Season">
                                        @php
                                            $ar = array();
                                            $l = 0;
                                        @endphp
                                        @foreach ($all as $leagues)
                                            @if (!in_array($leagues->season, $ar))
                                                <option value='{{ $leagues->season }}'>{{ $leagues->season }}</option>
                                                @php
                                                    $ar[$l] = $leagues->season;
                                                    $l = $l + 1;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </optgroup> --}}

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary py-2">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <h2>LEAGUES</h2>
                <table class="table" id="leagueTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Country</th>
                            <th>Season</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $leagues)
                            <tr>
                                <td>{{ $leagues->name }}</td>
                                <td>{{ $leagues->type }}</td>
                                <td>{{ $leagues->country }}</td>
                                <td>{{ $leagues->season }}</td>
                                <td>{{ $leagues->start }}</td>
                                <td>{{ $leagues->end }}</td>
                                <td><a class="btn btn-outline-light" href="/standings/{{ $leagues->name }}" style="height: 30px; width: 85px; padding: 0; text-align: center;">Standings</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="overlay"></div>
    </body>
</html>
<script src="//code.jquery.com/jquery-3.5.1.js"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>$(document).ready(function () {
    $('#leagueTable').DataTable({
        lengthMenu: [
            [8, 10, 25, 50, -1],
            [8, 10, 25, 50, 'All'],
        ],
    });
});
</script>
