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
                        <a class="nav-link active" aria-current="page" href="/teams">Teams</a>
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

          <div class="container">
            <div class="col-md-6">
                <form action="/teams">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <select name="filter" class="form-control">
                                    <option value="">Default</option>
                                    @php
                                        $arr = array();
                                        $i = 0;
                                    @endphp
                                    @foreach ($all as $teams)
                                        @if (!in_array($teams->country, $arr))
                                            <option value='{{ $teams->country }}'>{{ $teams->country }}</option>
                                            @php
                                                $arr[$i] = "$teams->country";
                                                $i = $i + 1;
                                            @endphp
                                        @endif
                                    @endforeach
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
                <h2>TEAMS</h2>
                <table class="table" id="teamTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Founded</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $teams)
                            <tr>
                                <td>{{ $teams->id }}</td>
                                <td>{{ $teams->name }}</td>
                                <td>{{ $teams->country }}</td>
                                <td>{{ $teams->founded }}</td>
                                <td><a class="nav-link" href="/teamStats/{{ $teams->name }}">More</a></td>
                                {{-- <td><a class="btn btn-danger" href="{{ url('delete-user/'.$users->id) }}">Delete</a></td> --}}
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
    $('#teamTable').DataTable({
        lengthMenu: [
            [8, 10, 25, 50, -1],
            [8, 10, 25, 50, 'All'],
        ],
    });
});
</script><br>
