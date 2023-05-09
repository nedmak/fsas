<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>FAS</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/fixture.css">

        {{-- SHOT COLUMN TABLE  --}}
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart()
        {
            var data = google.visualization.arrayToDataTable([
            ['Team', 'Shots on Goal', 'Shots off Goal', 'Bloked shots', 'Total shots'],
            @foreach ($data as $fixtures)
                ['{{ $fixtures->team }}', {{ $fixtures->sh_on_goal }}, {{ $fixtures->sh_off_goal }}, {{ $fixtures->sh_bloked }}, {{ $fixtures->sh_total }}],
            @endforeach
            ]);

            var options = {
            chart: {
                title: 'Shot Performance',
                subtitle: 'Shot statistics by the team',
            }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
        </script>


        {{-- SHOT PLACE TABLE --}}
        @foreach ($data as $fixtures)
            <script type="text/javascript">
            google.charts.load("current", {packages:["corechart"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Place', 'Shots'],
                @if(!$fixtures->sh_out_box)
                    ['Shots Outside box', 0],
                @else
                    ['Shots Outside box', {{ $fixtures->sh_out_box }}],
                @endif
                @if(!$fixtures->sh_in_box)
                    ['Shots Inside box', 0]
                @else
                    ['Shots Inside box', {{ $fixtures->sh_in_box }}]
                @endif
                ]);

                var options = {
                title: '{{ $fixtures->team }} shot placement',
                is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('{{ $fixtures->team }}'));
                chart.draw(data, options);
            }
            </script>
        @endforeach


        {{-- COMP CHART --}}
        <style>
            #chartdiv {
              width: 85%;
              height: 500px;
              margin-left: 75px;
              margin-bottom: 25px;
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

            @foreach ($data as $fixtures)
              @if ($loop->last)
                $team2 = "{{ $fixtures->team }}";

                @if (!$fixtures->fouls)
                $fauls2 = 0;
                @else
                $fauls2 = {{ $fixtures->fouls }};
                @endif

                @if (!$fixtures->corners)
                $corners2 = 0;
                @else
                $corners2 = {{ $fixtures->corners }};
                @endif

                @if (!$fixtures->offsides)
                $offsides2 = 0;
                @else
                $offsides2 = {{ $fixtures->offsides }};
                @endif

                @if (!$fixtures->yellow)
                $yellow2 = 0;
                @else
                $yellow2 = {{ $fixtures->yellow }};
                @endif

                @if (!$fixtures->red)
                $red2 = 0;
                @else
                $red2 = {{ $fixtures->red }};
                @endif

                @if (!$fixtures->saves)
                $saves2 = 0;
                @else
                $saves2 = {{ $fixtures->saves }};
                @endif
              @else
                $team1 = "{{ $fixtures->team }}";

                @if (!$fixtures->fouls)
                $fauls1 = 0;
                @else
                $fauls1 = {{ $fixtures->fouls }};
                @endif

                @if (!$fixtures->corners)
                $corners1 = 0;
                @else
                $corners1 = {{ $fixtures->corners }};
                @endif

                @if (!$fixtures->offsides)
                $offsides1 = 0;
                @else
                $offsides1 = {{ $fixtures->offsides }};
                @endif

                @if (!$fixtures->yellow)
                $yellow1 = 0;
                @else
                $yellow1 = {{ $fixtures->yellow }};
                @endif

                @if (!$fixtures->red)
                $red1 = 0;
                @else
                $red1 = {{ $fixtures->red }};
                @endif

                @if (!$fixtures->saves)
                $saves1 = 0;
                @else
                $saves1 = {{ $fixtures->saves }};
                @endif
              @endif
            @endforeach
            // Data
            var data = [
                {
                Category: "Red cards",
                $team1: -$red1,
                $team2: $red2
              },
                {
                Category: "Saves",
                $team1: -$saves1,
                $team2: $saves2
              },
                {
                Category: "Yellow cards",
                $team1: -$yellow1,
                $team2: $yellow2
              },
                {
                Category: "Offsides",
                $team1: -$offsides1,
                $team2: $offsides2
              },
            {
                Category: "Corners",
                $team1: -$corners1,
                $team2: $corners2
              },
              {
                Category: "Fouls",
                $team1: -$fauls1,
                $team2: $fauls2
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
                paddingTop: 10,
                isMeasured: false,
                centerX: labelCenterX
              });
              label.adapters.add("dy", function() {
                return -chart.plotContainer.height();
              });

              return series;
            }

            createSeries('$team1', am5.p100, "right", -5);
            createSeries('$team2', 0, "left", 5);

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
                        <a class="nav-link" href="/leagues">Leagues</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/players">Players</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/fixtures">Fixtures</a>
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
                <div class="col-sm-9" id="columnchart_material" style="width: 50%; height: 500px; margin-top:15px;">
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        @foreach ($data as $fixtures)
                            <div class="col-9" id="{{ $fixtures->team }}"></div>
                        @endforeach
                    </div>
                </div>
                {{-- @foreach ($data as $fixtures)
                    <div class="col" id="{{ $fixtures->team }}"></div>
                @endforeach --}}
            </div>
          </div>


            {{-- <div id="columnchart_material" style="width: 600px; height: 500px; margin-left:5%; margin-top:15px;"></div>
            @foreach ($data as $fixtures)
                <div class="row" id="{{ $fixtures->team }}"></div>
            @endforeach --}}

          <div id="chartdiv"></div>
    </body>
</html>
