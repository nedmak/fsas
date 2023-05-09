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
            <div class="row">
                <h2>@php echo $name @endphp standings</h2>
                <table class="table" id="standingsTable">
                    <thead>
                        <tr>
                            <th>Team</th>
                            <th>Form</th>
                            <th>Wins</th>
                            <th>Ties</th>
                            <th>Loses</th>
                            <th>Points</th>
                            <th>Function</th>
                            {{-- <th>Players</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $team)
                            <tr>
                                <td>{{ $team->team }}</td>
                                <td>{{ $team->form }}</td>
                                <td>{{ $team->wins }}</td>
                                <td>{{ $team->ties }}</td>
                                <td>{{ $team->loses }}</td>
                                @foreach ($results as $r)
                                    @if ($team->team == $r['team'])
                                        <th>@php echo $r['points'] @endphp</th>
                                    @endif
                                @endforeach
                                <td><a class="btn btn-outline-light" href="/teamStats/{{ $team->team }}" style="height: 30px; width: 65px; padding: 0; text-align: center;">Stats</a> |
                                    <a class="btn btn-outline-light" href="/teamPlayer/{{ $team->team }}" style="height: 30px; width: 65px; padding: 0; text-align: center;">Players</a></td>
                                {{-- <td><a class="btn btn-outline-light" href="" style="height: 30px; width: 65px; padding: 0; text-align: center;">Players</a></td> --}}
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
    $('#standingsTable').DataTable({
        order: [[5, 'desc']],
        paging: false,
    });
});
</script>
