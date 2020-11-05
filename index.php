<html>
<head>
<!-- Loading in highcharts libraries and indicators-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/data.js"></script>
<script src="https://code.highcharts.com/stock/indicators/indicators.js"></script>
<script src="https://code.highcharts.com/stock/indicators/acceleration-bands.js"></script>
<script src="https://code.highcharts.com/stock/indicators/bollinger-bands.js"></script>
<script src="https://code.highcharts.com/stock/indicators/ema.js"></script>
<script src="https://code.highcharts.com/stock/indicators/atr.js"></script>
<script src="https://code.highcharts.com/stock/indicators/keltner-channels.js"></script>
<script src="https://code.highcharts.com/stock/indicators/stochastic.js"></script>
<script src="https://code.highcharts.com/stock/indicators/rsi.js"></script>
<script src="https://code.highcharts.com/stock/indicators/macd.js"></script>
<script src="https://code.highcharts.com/stock/indicators/roc.js"></script>
<script src="https://code.highcharts.com/stock/indicators/williams-r.js"></script>

<!-- setting title of the page-->
<title>ODDS Online</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<!-- when page is first loaded -->
<div id="topbar">
    <input type="text" id="ticker" value="AAPL">
    <!-- <input type="date" id="calendar"> -->
    <span id="price"></span>
    <span id="issuer"></span>
</div>
<div id="container" style="height: 90%; width: 100%"></div>

<!-- selecting indicators for chart 1 drop down -->
<select id="chart1" class="indicatorSelect">
    <option value="none">None</option>
    <option value="abands">Acceleration Bands</option>
    <option value="bb">BB</option>
    <option value="ema">EMA</option>
    <option value="keltnerchannels">Keltner Channels</option>
    <option value="sma">SMA</option>
</select>
<!-- selecting indicators for chart 2 drop down -->
<select id="chart2" class="indicatorSelect">
    <option value="atr">ATR</option>
    <option value="macd">MACD</option>
    <option value="roc">Rate of Change</option>
    <option value="rsi">RSI</option>
    <option value="stochastic">Stochastic</option>
    <option value="williamsr">Williams %R</option>
    <option value="vratio">Volume Ratio</option>
    <option value="oiratio">Open Interest Ratio</option>
</select>
<!-- possible slider values for indicators -->
<div class="slidecontainer" style="display: none">
  <p>MACD Short Period</p>
  <input type="range" min="1" max="52" value="9" class="slider" id="ShortPeriod">
  <p>Value: <span id="ShortOutput"></span></p>
  
  <p>MACD Long Period</p>
  <input type="range" min="1" max="52" value="26" class="slider" id="LongS">
  <p>Value: <span id="LongOutput"></span></p>
  
  <p>MACD Signal Period</p>
  <input type="range" min="1" max="52" value="9" class="slider" id="Signal">
  <p>Value: <span id="SignalOutput"></span></p>
  
  
  
  <p>Williams-R Period</p>
  <input type="range" min="1" max="52" value="14" class="slider" id="Period">
  <p>Value: <span id="PeriodOutput"></span></p>
</div>

<!-- sliders to determine indicator periods -->
<script>
var ShortSlider = document.getElementById("ShortPeriod");
var shortH = document.getElementById("ShortOutput");
shortH.innerHTML = ShortSlider.value;

var LongSlider = document.getElementById("LongS");
var longO = document.getElementById("LongOutput");
longO.innerHTML = LongSlider.value;

var SignalSlider = document.getElementById("Signal");
var signal = document.getElementById("SignalOutput");
signal.innerHTML = SignalSlider.value;

var PeriodSlider = document.getElementById("Period");
var period = document.getElementById("PeriodOutput");
period.innerHTML = PeriodSlider.value;
</script>

<!-- graphs the indicators -->
<script>
    var chartOptions = {
        rangeSelector: {
            floating: true,
            selected: 1
        },

        navigator: {
            enabled: false
        },

        legend: {
            enabled: false
        },

        plotOptions: {
            series: {
                showInLegend: true,
                visible: false,
                marker: {
                    enabled: false
                }
            }
        },

        yAxis: [{height: '70%'}, {top: '70%', height: '30%'}],

        series: [
        {
            type: 'ohlc',
            id: 'price',
            name: 'Stock Price',
            tooltip: {
                valueDecimals: 2
            },
            visible: true,
            color: 'red',
            upColor: 'green'
        }, 
        {
            yAxis: 1,
            type: 'line',
            id: 'vratio',
            name:'Volume Ratio',  
            tooltip:{
                valueDecimals: 6
            },
        
        },
        {
            yAxis: 1,
            type: 'line',
            id: 'oiratio',
            name:'Open Intrest Ratio',  
            tooltip:{
                valueDecimals: 6
            },
        
        },
        {
            type: 'abands',
            id: 'abands',
            linkedTo: 'price'
        },
        {
            type: 'bb',
            id: 'bb',
            linkedTo: 'price'
        },
        {
            type: 'ema',
            id: 'ema',
            linkedTo: 'price'
        },
        {
            type: 'keltnerchannels',
            id: 'keltnerchannels',
            linkedTo: 'price'
        },
        {
            type: 'sma',
            id: 'sma',
            linkedTo: 'price'
        },
        {
            yAxis: 1,
            type: 'atr',
            id: 'atr',
            linkedTo: 'price',
            visible: true
        },
        {
            yAxis: 1,
            type: 'macd',
            id: 'macd',
            linkedTo: 'price',
            params: {
                shortPeriod: 12,
                longPeriod: 26,
                signalPeriod: 9,
                period: 26
            }
        },
        {
            yAxis:1,
            type: 'roc',
            id: 'roc',
            linkedTo: 'price'
        },
        {
            yAxis: 1,
            type: 'rsi',
            id: 'rsi',
            linkedTo: 'price'
        },
        {
            yAxis: 1,
            type: 'stochastic',
            id: 'stochastic',
            linkedTo: 'price'
        },
        {
            yAxis: 1,
            type: 'williamsr',
            id: 'williamsr',
            linkedTo: 'price',
            color: 'green',
            lineWidth: 1.5,
            marker: {
                enabled: false
            },
            params: {
                period: 14
            },
            zones: [{
                value: -80,
                color: 'green'
            }, {
                value: -20,
                color: '#bbb'
            }]
        }]
            
    }

    var indicator1 = "none";
    var indicator2 = "atr";
    // Calls the makechart function that uses the highcharts graphs in a variable 
    function makeChart(json) {
        chartOptions.series[0].data = json.ohlc;
        chartOptions.series[1].data = json.vratio;
        chartOptions.series[2].data = json.oiratio;
        Highcharts.stockChart('container', chartOptions);
    }

    //Update the chart and the elements at the top
    function updatePage(json) {
        console.log(json);
        $("#ticker").val(json.ticker);
        //$("#calendar").val(new Date(json.ohlc[json.ohlc.length - 1][0]).toDateString);
        $("#price").text("$" + json.ohlc[json.ohlc.length - 1][4].toFixed(2));
        $("#issuer").text(json.issuer);
        makeChart(json);
    }

    //Initial page load
    $(document).ready(function() {
        //Set default vals on drop down menus
        $("#chart1").val("none");
        $("#chart2").val("atr");

        //Load chart
        $.getJSON('getData.php', {ticker: $("#ticker").val()}, function(json) {
            updatePage(json)
        })
    })
    
    //Update page when enter is pressed in ticker text
    $("#ticker").keypress(function(e) {
        if(e.which == 13) {
            $.getJSON('getData.php', {ticker: $(this).val()}, function(json) {
                updatePage(json)
            })
        }
    })

    //Show or hide indicators on upper chart
    $("#chart1").change(function() {
        var val = $(this).val();
        chartOptions.series.forEach(function(item) {
            if(item.id == val) {
                item.visible = true;
            }
            else if(item.id == indicator1) {
                item.visible = false;
            }
        })
        indicator1 = val;
        Highcharts.stockChart('container', chartOptions);
    })

    //Show or hide indicators on lower chart
    $("#chart2").change(function() {
        var val = $(this).val();
        chartOptions.series.forEach(function(item) {
            if(item.id == val) {
                item.visible = true;
            }
            else if(item.id == indicator2) {
                item.visible = false;
            }
        })
        indicator2 = val;
        Highcharts.stockChart('container', chartOptions);

        if(val == "macd") {
            $(".slidecontainer").show();
        }
        else
        {
            $(".slidecontainer").hide();
        }
    })
    // Updates page on slider value change
    ShortSlider.oninput = function() {
	  shortH.innerHTML = this.value;	
	  $.getJSON('getData.php', {ticker: $("#ticker").val()}, function(json) {updatePage(json)})
	}
	LongSlider.oninput = function() {
	  longO.innerHTML = this.value;
	  $.getJSON('getData.php', {ticker: $("#ticker").val()}, function(json) {updatePage(json)})
	}
	SignalSlider.oninput = function() {
	  signal.innerHTML = this.value;
	  $.getJSON('getData.php', {ticker: $("#ticker").val()}, function(json) {updatePage(json)})
	}
	PeriodSlider.oninput = function() {
		period.innerHTML = this.value;
		$.getJSON('getData.php', {ticker: $("#ticker").val()}, function(json) {updatePage(json)})
	}

    
</script>

</body>
</html>
