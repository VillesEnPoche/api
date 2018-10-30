<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-circular-gauge.min.js"></script>
    <link rel="stylesheet" href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" />
    <link rel="stylesheet" href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" />
    <style>
        html, body, #container {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<div id="container"></div>
<script type="text/javascript">
    var names = [
        @foreach($data as $pollutant_history)
"{{ $pollutant_history->pollutant()->first()->name }}",
        @endforeach
    ];
    var data = [
        @foreach($data as $pollutant_history)
        {{ $pollutant_history->value }},
        @endforeach
        @foreach($data as $pollutant_history)
        {{ $pollutant_history->pollutant()->first()->getMax() }},
        @endforeach
    ];
    var translate = [
        @foreach($data as $pollutant_history)
        "{{ __('pollutants.levels')[$pollutant_history->alert] }}",
        @endforeach
    ];
    var dataSet = anychart.data.set(data);
    var palette = anychart.palettes.distinctColors().items([
        @foreach($data as $pollutant_history)
        "{{ $pollutant_history->pollutant()->first()->getColor($pollutant_history->alert) }}",
        @endforeach
    ]);

    var makeBarWithBar = function(gauge, radius, i, width, without_stroke) {
        var stroke = '1 #e5e4e4';
        if (without_stroke) {
            stroke = null;
            gauge.label(i)
                .fontColor("#000000")
                .fontSize(16)
                .text(names[i] + ' : <span style="">' + data[i] + ' µg/m³</span><br>(' + translate[i] + ')') // color: #7c868e
                .useHtml(true);
            gauge.label(i)
                .hAlign('center')
                .vAlign('middle')
                .anchor('right-center')
                .padding(0, 10)
                .height(width / 2 + '%')
                .offsetY(radius + '%')
                .offsetX(0);
        }

        gauge.bar(i).dataIndex(i)
            .radius(radius)
            .width(width)
            .fill(palette.itemAt(i))
            .stroke(null)
            .zIndex(4);
        gauge.bar(i + 100).dataIndex(i + 4)
            .radius(radius)
            .width(width)
            .fill('#F5F4F4')
            .stroke(stroke)
            .zIndex(3);

        return gauge.bar(i)
    };

    anychart.onDocumentReady(function() {
        var gauge = anychart.gauges.circular();
        gauge.data(dataSet);
        gauge.fill('none')
            .stroke(null)
            .background('none')
            .padding(0)
            .margin(100)
            .startAngle(0)
            .sweepAngle(270);

        var axis = gauge.axis().radius(100).width(1).fill(null);
        axis.scale()
            .minimum(0)
            .maximum(100)
            .ticks({
                interval: 1
            })
            .minorTicks({
                interval: 1
            });
        axis.labels().enabled(false);
        axis.ticks().enabled(false);
        axis.minorTicks().enabled(false);
        makeBarWithBar(gauge, 100, 0, 22, true);
        makeBarWithBar(gauge, 75, 1, 22, true);
        makeBarWithBar(gauge, 50, 2, 22, true);
        makeBarWithBar(gauge, 25, 3, 22, true);

        gauge.margin(50);
        gauge.title()
            .enabled(false)
            .hAlign('center')
            .padding(0)
            .margin([0, 0, 20, 0]);

        gauge.container('container');
        gauge.draw();
    });
</script>
</body>
</html>