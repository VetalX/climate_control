<!doctype html>
<html>

<head>
    <title>Weather station</title>
    <script src="/static/js/jquery-3.2.1.min.js"></script>
    <script src="/static/js/Chart.bundle.js"></script>
    <script src="/static/js/utils.js"></script>
    
    <link rel="stylesheet" href="/static/css/jquery-ui.css">
    <script src="/static/js/jquery-ui.js"></script>
    
    <style>
    canvas{
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    
    #datepicker{
        width: 74px;
    }
    </style>
</head>

<body>
    <input type="button" id="refresh_btn" value="Обновить" />
    <input type="text" id="datepicker">
    <h2>
        Температура: <span id="temperature"></span>&deg;<br>
        Влажность: <span id="humidity"></span>%
    </h2>
    <div style="width:75%;">
        <canvas id="canvas"></canvas>
    </div>
    <script>
        $(document).ready(function() {
            function get_data(){
                var dt = $("#datepicker").val();
                $.get("/?c=welcome&m=get_data&dt="+dt, function(data){
                    var config = {
                        type: 'line',
                        data: {
                            labels: [

                            ],
                            datasets: [{
                                label: "Температура",
                                backgroundColor: window.chartColors.red,
                                borderColor: window.chartColors.red,
                                data: [

                                ],
                                fill: false,
                                pointRadius: 0,
                            }, {
                                label: "Влажность",
                                fill: false,
                                backgroundColor: window.chartColors.blue,
                                borderColor: window.chartColors.blue,
                                data: [

                                ],
                                pointRadius: 0,
                            }]
                        },
                        options: {
                            responsive: true,
                            title:{
                                display:true,
                                text:'Температура и влажность'
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: false,
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Время'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Значение'
                                    }
                                }]
                            }
                        }
                    };


                    var data_js = JSON.parse(data);
                    
                    $("#temperature").html(data_js[data_js.length-1].temperature),
                    $("#humidity").html(data_js[data_js.length-1].humidity),
                    
                    $(data_js).each(function(i, item){
                        config.data.labels.push(item.time);
                        config.data.datasets[0].data.push(item.temperature);
                        config.data.datasets[1].data.push(item.humidity);
                    });

                    var ctx = document.getElementById("canvas").getContext("2d");
                    if(typeof(window.myLine) == 'object'){
                        window.myLine.destroy();
                    }
                    window.myLine = new Chart(ctx, config);
                });
            }
            get_data();
            
            $("#refresh_btn").click(function(){
                get_data();
            });
            
            $( "#datepicker" ).datepicker({"dateFormat": "yy-mm-dd"});
            $( "#datepicker" ).datepicker("setDate", '<?=date("Y-m-d")?>');
        });
    </script>
</body>

</html>