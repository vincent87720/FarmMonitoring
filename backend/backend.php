<?php
    require_once '../php/connect.php';
    if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
    {
        header("Location: ../index.php");
    }
    else:
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>自動化農場監測</title>
        <meta name="keyword" content="農場'自動化農場'農場數據監測'"><!--keyword讓搜索引擎容易找到此網頁-->
        <meta name="viewport" content="width=device-width, initial-scale=1" ><!--指定螢幕寬度為裝置寬度，畫面載入初始縮放比例 100%-->
        <link rel="icon" href="../image/barrier.ico">
        <noscript>
            
        </noscript>
        <link rel="stylesheet" href="../css/style.css" type="text/css" charset="utf8">
        <!--Bootstrap CSS-->
        <link rel="stylesheet" href="../css/bootstrap-3.3.7.css">
        <!--Bootstrap CSS-->
        
        <!--JQUERY-->
        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <!--JQUERY-->

        <!--JavaScript-->
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <!--JavaScript-->

        <!--Chart.js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <!--Chart.js-->

        <!--DatePicker-->
        <script type="text/javascript" src="../js/moment.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="../css/bootstrap-datetimepicker.css">   
        <!-- <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script> -->
        <!--<script type="text/javascript" src="../js/bootstrap.min.js"></script> -->
        <!--DatePicker-->

        
    </head>
    <body>
        <div class="background">
            <div class="topbar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <br>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-secondary" onclick="location.href='logout.php'">登出</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 align-middle">
                            <embed src="../image/barrier.svg" style="display:inline; vertical-align:middle; width:70px; height:70px; margin:auto;"/>
                            <h2 style="display:inline; vertical-align:middle;">自動化農場監測</h2>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="chart-container" style="position: relative; height:100%; width:95%">
                                <canvas id="Chart"></canvas>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="input-group date" id="startDateTime">
                                    <input type="text" class="form-control" id="startText" value="" readonly>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group date" id="endDateTime">
                                    <input type="text" class="form-control" id="endText" value="" readonly>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(function () { 
                    $('#startDateTime').datetimepicker({
                        format: 'yyyy-mm-dd hh:ii',
                        defaultDate:new Date(),
                        todayHighlight: true

                    });

                    $('#endDateTime').datetimepicker({
                        format: 'yyyy-mm-dd hh:ii',
                        defaultDate:new Date(),
                        todayHighlight: true
                    });
                });
                
                var ctx = document.getElementById("Chart");
                var theChart = new Chart(ctx, {
                    type: 'line',
                    
                    data:{
                        labels:["00:00","03:00","06:00","09:00","12:00","15:00","18:00"],
                        datasets: [{
                            label: '日期',
                            data: [4, 13, 10, 19, 2],
                            fill:false,
                            borderColor:"rgb(75, 192, 192)",
                            lineTension:0.1
                        }]
                    }
                });

            </script>

        </div>
    </body>
</html>

<?php
    endif;
?>