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
<<<<<<< HEAD
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
                <div id="flot-placeholder"></div>
            </div>
=======
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <embed src="../image/barrier.svg" style="display:inline; vertical-align:middle; width:70px; height:70px; margin:auto;">
                            <h2 style="display:inline; vertical-align:middle;">自動化農場監測</h2>
                        </div>
                    </div>
                </div>
<<<<<<< Updated upstream
                <div class="row">
                    <div class="col-sm-12 align-middle">
                        <embed src="./image/barrier.svg" style="display:inline; vertical-align:middle; width:70px; height:70px; margin:auto;"/>
                        <h2 style="display:inline; vertical-align:middle;">自動化農場監測</h2>
=======
            </div>
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="chart-container" style="position: relative; height:40vh; width:75vw">
                                <canvas id="Chart"></canvas>
                            </div>
                        </div>
>>>>>>> Stashed changes
                    </div>
                </div>
            </div>
>>>>>>> backend
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
<<<<<<< HEAD

=======
                            
>>>>>>> backend
                        </div>
                    </div>
                </div>
            </div>

            <script>
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