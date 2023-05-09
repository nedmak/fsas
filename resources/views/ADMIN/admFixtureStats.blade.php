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

        {{-- COMP CHART --}}
        <style>
            #chartdiv {
              width: 85%;
              height: 500px;
              margin-left: 75px;
              margin-bottom: 25px;
              margin-top: 25px;
                background-color: lightgray;
            }
            </style>

            <!-- Resources -->
            <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
            <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
            <script src="https://cdn.amcharts.com/lib/5/themes/Dataviz.js"></script>

            <!-- Chart code -->
            <script>
            am5.ready(function() {

            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartdiv");

            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
              am5themes_Dataviz.new(root)
            ]);

            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            var chart = root.container.children.push(
              am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "panX",
                wheelY: "zoomX",
                layout: root.verticalLayout,
                arrangeTooltips: false
              })
            );

            // Use only absolute numbers
            chart.getNumberFormatter().set("numberFormat", "#.#s");

            // Add legend
            // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
            var legend = chart.children.push(
              am5.Legend.new(root, {
                centerX: am5.p50,
                x: am5.p50
              })
            );

            @php
                $h_shots = 0;
                $h_onTarget = 0;
                $h_assists = 0;
                $h_yellow = 0;
                $h_red = 0;

                $a_shots = 0;
                $a_onTarget = 0;
                $a_assists = 0;
                $a_yellow = 0;
                $a_red = 0;
            @endphp
            @foreach ($fixture as $f)
                @foreach ($team as $t)
                    @if ($f->h_team == $t->id)
                        @php
                            $h_team = $t->name
                        @endphp
                    @endif
                    @if ($f->a_team == $t->id)
                        @php
                            $a_team = $t->name
                        @endphp
                    @endif
                @endforeach
                @foreach ($stats as $s)
                    @if ($f->h_team == $s->teamID)
                        @php
                            $h_shots = $h_shots + $s->shots;
                            $h_onTarget = $h_onTarget + $s->shots_on_goal;
                            $h_assists = $h_assists + $s->assists;
                            $h_yellow = $h_yellow + $s->yellow;
                            $h_red = $h_red + $s->red;
                        @endphp
                    @endif
                    @if ($f->a_team == $s->teamID)
                        @php
                            $a_shots = $a_shots + $s->shots;
                            $a_onTarget = $a_onTarget + $s->shots_on_goal;
                            $a_assists = $a_assists + $s->assists;
                            $a_yellow = $a_yellow + $s->yellow;
                            $a_red = $a_red + $s->red;
                        @endphp
                    @endif
                @endforeach
            @endforeach

            // Data
            var data = [
                {
                Category: "Total shots",
                @php echo $h_team @endphp: -@php echo $h_shots @endphp,
                @php echo $a_team @endphp: @php echo $a_shots @endphp
              },
                {
                Category: "Shots on goal",
                @php echo $h_team @endphp: -@php echo $h_onTarget @endphp,
                @php echo $a_team @endphp: @php echo $a_onTarget @endphp
              },
                {
                Category: "Assists",
                @php echo $h_team @endphp: -@php echo $h_assists @endphp,
                @php echo $a_team @endphp: @php echo $a_assists @endphp
              },
                {
                Category: "Yellow cards",
                @php echo $h_team @endphp: -@php echo $h_yellow @endphp,
                @php echo $a_team @endphp: @php echo $a_yellow @endphp
              },
              {
                Category: "Red cards",
                @php echo $h_team @endphp: -@php echo $h_red @endphp,
                @php echo $a_team @endphp: @php echo $a_red @endphp
              }
            ];

            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var yAxis = chart.yAxes.push(
              am5xy.CategoryAxis.new(root, {
                categoryField: "Category",
                renderer: am5xy.AxisRendererY.new(root, {
                  inversed: true,
                  cellStartLocation: 0.1,
                  cellEndLocation: 0.9
                })
              })
            );

            yAxis.data.setAll(data);

            var xAxis = chart.xAxes.push(
              am5xy.ValueAxis.new(root, {
                renderer: am5xy.AxisRendererX.new(root, {
                  strokeOpacity: 0.1
                })
              })
            );

            // Add series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            function createSeries(field, labelCenterX, pointerOrientation, rangeValue) {
              var series = chart.series.push(
                am5xy.ColumnSeries.new(root, {
                  xAxis: xAxis,
                  yAxis: yAxis,
                  valueXField: field,
                  categoryYField: "Category",
                  sequencedInterpolation: true,
                  clustered: false,
                  tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: pointerOrientation,
                    labelText: "{categoryY}: {valueX}"
                  })
                })
              );

              series.columns.template.setAll({
                height: am5.p100,
                strokeOpacity: 0,
                fillOpacity: 0.8
              });

              series.bullets.push(function() {
                return am5.Bullet.new(root, {
                  locationX: 1,
                  locationY: 0.5,
                  sprite: am5.Label.new(root, {
                    centerY: am5.p50,
                    text: "{valueX}",
                    populateText: true,
                    centerX: labelCenterX
                  })
                });
              });

              series.data.setAll(data);
              series.appear();

              var rangeDataItem = xAxis.makeDataItem({
                value: rangeValue
              });
              xAxis.createAxisRange(rangeDataItem);
              rangeDataItem.get("grid").setAll({
                strokeOpacity: 1,
                stroke: series.get("stroke")
              });

              var label = rangeDataItem.get("label");
              label.setAll({
                text: field.toUpperCase(),
                fontSize: "1.1em",
                fill: series.get("stroke"),
                paddingTop: -15,
                isMeasured: false,
                centerX: labelCenterX
              });
              label.adapters.add("dy", function() {
                return -chart.plotContainer.height();
              });

              return series;
            }

            createSeries('@php echo $h_team @endphp', am5.p100, "right", -5);
            createSeries('@php echo $a_team @endphp', 0, "left", 5);

            // Add cursor
            // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
              behavior: "zoomY"
            }));
            cursor.lineY.set("forceHidden", true);
            cursor.lineX.set("forceHidden", true);

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            chart.appear(1000, 100);

            }); // end am5.ready()
            </script>

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

        {{-- Counting score --}}
        @php
            $h_score = 0;
            $a_score = 0;
        @endphp
        @foreach ($fixture as $f)
            @foreach ($team as $t)
                @if ($f->h_team == $t->id)
                    @php
                        $h_team = $t->name
                    @endphp
                @endif
                @if ($f->a_team == $t->id)
                    @php
                        $a_team = $t->name
                    @endphp
                @endif
            @endforeach
            @foreach ($stats as $s)
                @if ($f->h_team == $s->teamID)
                    @php
                        $h_score = $h_score + $s->goals
                    @endphp
                @endif
                @if ($f->a_team == $s->teamID)
                    @php
                        $a_score = $a_score + $s->goals
                    @endphp
                @endif
            @endforeach
        @endforeach

        <div class="container" style="margin-top: 30px">
            <div class="d-flex justify-content-center">
                <h1 style="font-size: 60px; font-weight:600;" >@php echo $h_team @endphp @php echo $h_score @endphp -
                    @php echo $a_score @endphp @php echo $a_team @endphp</h1>
            </div>
        </div>

        <div id="chartdiv"></div>

        <div class="container" style="margin-top: 20px">
            <div class="row">
                {{-- Home team --}}
                <table class="table">
                    <thead>
                        @foreach ($fixture as $f)
                            @foreach ($team as $t)
                                @if ($f->h_team == $t->id)
                                    <h3>{{ $t->name }} players individual stats</h3>
                                @endif
                            @endforeach
                        @endforeach
                        <tr>
                            <th>Name</th>
                            <th>Last name</th>
                            <th>Minutes played</th>
                            <th>Shots</th>
                            <th>Shots on goal</th>
                            <th>Goals</th>
                            <th>Assists</th>
                            <th>Yellow cards</th>
                            <th>Red cards</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fixture as $f)
                            @foreach ($stats as $s)
                                @if ($f->h_team == $s->teamID)
                                    <tr>
                                        <td>{{ $s->name }}</td>
                                        <td>{{ $s->lastname }}</td>
                                        <td>{{ $s->min }}</td>
                                        <td>{{ $s->shots }}</td>
                                        <td>{{ $s->shots_on_goal }}</td>
                                        <td>{{ $s->goals }}</td>
                                        <td>{{ $s->assists }}</td>
                                        <td>{{ $s->yellow }}</td>
                                        <td>{{ $s->red }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table><br><br>

                {{-- Away team --}}
                <table class="table">
                    <thead>
                        @foreach ($fixture as $f)
                            @foreach ($team as $t)
                                @if ($f->a_team == $t->id)
                                    <h3>{{ $t->name }} players individual stats</h3>
                                @endif
                            @endforeach
                        @endforeach
                        <tr>
                            <th>Name</th>
                            <th>Last name</th>
                            <th>Minutes played</th>
                            <th>Shots</th>
                            <th>Shots on goal</th>
                            <th>Goals</th>
                            <th>Assists</th>
                            <th>Yellow cards</th>
                            <th>Red cards</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fixture as $f)
                            @foreach ($stats as $s)
                                @if ($f->a_team == $s->teamID)
                                    <tr>
                                        <td>{{ $s->name }}</td>
                                        <td>{{ $s->lastname }}</td>
                                        <td>{{ $s->min }}</td>
                                        <td>{{ $s->shots }}</td>
                                        <td>{{ $s->shots_on_goal }}</td>
                                        <td>{{ $s->goals }}</td>
                                        <td>{{ $s->assists }}</td>
                                        <td>{{ $s->yellow }}</td>
                                        <td>{{ $s->red }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col">
                    @foreach ($fixture as $f)
                        <a href="/email/{{ $f->id }}" class="button btn btn-primary" style="margin-bottom: 50px; margin-top: 30px;">Send results via Email</a>
                    @endforeach
                </div>
                <div class="col">
                    <div class="d-flex justify-content-end">
                        <a href="/admFixture" class="button btn btn-danger" style="margin-bottom: 50px; margin-top: 30px;">Back</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="overlay"></div>
    </body>
</html>
