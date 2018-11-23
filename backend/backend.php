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
        <link rel="stylesheet" href="../css/bootstrap.css">
        <!--Bootstrap CSS-->
        
        <!--JQUERY-->
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <!--JQUERY-->

        <!--JavaScript-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--JavaScript-->

        <!--Chart.js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <!--Chart.js-->    
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
                        <div class="col-sm-12">
                            <embed src="../image/barrier.svg" style="display:inline; vertical-align:middle; width:70px; height:70px; margin:auto;">
                            <h2 style="display:inline; vertical-align:middle;">自動化農場監測</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="chart-container" style="position: relative; height:40vh; width:75vw">
                                <canvas id="Chart"></canvas>
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
                var ctx = document.getElementById("Chart");
                var theChart = new Chart(ctx, {
                    type: 'line',
                    
                    data:{
                        labels:["00:00","03:00","06:00","09:00","12:00","03:00","06:00","09:00","12:00","12:00","03:00","06:00","09:00","12:00","12:00","03:00","06:00","09:00","12:00","12:00","03:00","06:00","09:00","12:00","12:00","03:00","06:00","09:00","12:00","12:00","03:00","06:00","09:00","12:00","12:00","03:00","06:00","09:00","12:00","12:00","03:00","06:00","09:00","12:00","12:00","03:00","06:00","09:00","12:00","12:00"],
                        datasets: [{
                            label: '日期',
                            fill:false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75, 192, 192, 1)",//標示屬性的方格的背景顏色
                            borderColor:"rgba(75, 192, 192, 1)",//線條顏色
                            borderCapStyle: 'round',//線條端點處風格為圓形
                            borderJoinStyle: 'round',//線段連接處風格為圓形
                            pointBorderColor: "rgba(75, 192, 192, 1)",//端點外圈顏色
                            pointBackgroundColor: "rgba(75, 192, 192, 1)",//端點內圈顏色
                            pointBorderWidth: 3,//端點外圈大小
                            pointHoverRadius: 4,//端點放大程度
                            pointHoverBorderColor: "rgba(75, 192, 192, 1)",//端點放後大外圈顏色
                            pointHoverBackgroundColor: "rgba(75, 192, 192, 1)",//端點放大後內圈顏色
                            pointHoverBorderWidth: 2,//端點放大後外圈大小
                            pointRadius: 2,//端點大小
                            pointHitRadius: 10,
                            data: [4, 13, 10, 19, 2]
                            
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