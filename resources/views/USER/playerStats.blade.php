<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>FAS</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/main.css">

        <style>
            #chartdiv {
              width: 85%;
              height: 500px;
              margin-left: 75px;
              margin-bottom: 25px;
              margin-top: 25px;
              color: white;

              /* background-color: lightgray; */
              z-index: 2;
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
              $app = 0;
              $min = 0;
              $rating = 0;
              $sh = 0;
              $on = 0;
              $goals = 0;
              $assists = 0;
              $passes = 0;
              $key = 0;
              $drb_a = 0;
              $drb_succ = 0;
              $yellow = 0;
              $red = 0;
            @endphp
            @foreach ($all as $a)
            {
                @php
                    $app = $app + $a->app;
                    $min = $min + $a->min;
                    $rating = $rating + $a->rating;
                    $sh = $sh + $a->sh_total;
                    $on = $on + $a->sh_on_goal;
                    $goals = $goals + $a->goals;
                    $assists = $assists + $a->assists;
                    $passes = $passes + $a->passes;
                    $key = $key + $a->key;
                    $drb_a = $drb_a + $a->drb_a;
                    $drb_succ = $drb_succ + $a->drb_succ;
                    $yellow = $yellow + $a->yellow;
                    $red = $red + $a->red;
                @endphp
            }

            @endforeach

            // Data
            var data = [
                {
                Category: "Appearences",
                '@php echo $id @endphp': -@php echo $data->app @endphp,
                'League average': @php echo $app/$number @endphp
              },
            //   {
            //   Category: "Minutes",
            //     '@php echo $id @endphp': -@php echo $data->min @endphp,
            //     'League average': @php echo $min/$number @endphp
            //   },
              {
              Category: "Rating",
                '@php echo $id @endphp': -@php echo $data->rating @endphp,
                'League average': @php echo $rating/$number @endphp
              },
              {
              Category: "Shots",
                '@php echo $id @endphp': -@php echo $data->sh_total @endphp,
                'League average': @php echo $sh/$number @endphp
              },
              {
              Category: "Shots on goal",
                '@php echo $id @endphp': -@php echo $data->sh_on_goal @endphp,
                'League average': @php echo $on/$number @endphp
              },
              {
              Category: "Goals",
                '@php echo $id @endphp': -@php echo $data->goals @endphp,
                'League average': @php echo $goals/$number @endphp
              },
              {
              Category: "Assists",
                '@php echo $id @endphp': -@php echo $data->assists @endphp,
                'League average': @php echo $assists/$number @endphp
              },
            //   {
            //   Category: "Passes",
            //     '@php echo $id @endphp': -@php echo $data->passes @endphp,
            //     'League average': @php echo $passes/$number @endphp
            //   },
              {
              Category: "Key passes",
                '@php echo $id @endphp': -@php echo $data->key @endphp,
                'League average': @php echo $key/$number @endphp
              },
              {
              Category: "Dribble atempts",
                '@php echo $id @endphp': -@php echo $data->drb_a @endphp,
                'League average': @php echo $drb_a/$number @endphp
              },
              {
              Category: "Dribble succsesful",
                '@php echo $id @endphp': -@php echo $data->drb_succ @endphp,
                'League average': @php echo $drb_succ/$number @endphp
              },
              {
              Category: "Yellow cards",
                '@php echo $id @endphp': -@php echo $data->yellow @endphp,
                'League average': @php echo $yellow/$number @endphp
              },
              {
              Category: "Red cards",
                '@php echo $id @endphp': -@php echo $data->red @endphp,
                'League average': @php echo $red/$number @endphp
              },
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

            createSeries('@php echo $id @endphp', am5.p100, "right", -5);
            createSeries('League average', 0, "left", 5);

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
                        <a class="nav-link active" aria-current="page" href="/players">Players</a>
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
                <div class="col">
                    <h2>@php echo $id; @endphp statistics in @php echo $data->league @endphp</h2>
                </div>
                <div class="col">
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-danger" href="{{ url()->previous() }}">Back</a>
                    </div>
                </div>
            </div>
          </div>
          <div id="chartdiv"></div>
          <div class="overlay"></div>
    </body>
</html>
