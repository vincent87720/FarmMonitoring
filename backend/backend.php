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
<<<<<<< HEAD
=======
                            
>>>>>>> backend-datepick
                        </div>
                    </div>
                </div>
            </div>

            <script>
<<<<<<< HEAD
                var datetime = null;
                var datas = null;
                $(document).on("ready",function(){  
                    $('#endDateTime').datetimepicker().on('changeDate', function(ev){
                        $.ajax({
                            type:"POST",//使用表單的方式傳送，同form的method
                            url:"../php/get_monitoring_data.php",
                            //data:$('#register_form').serializeArray(),
                            data:
                            {
                                'startText':$('#startText').val(),
                                'endText':$('#endText').val()
                            },
                            dataType:'html'

                        }).done(function(data){
                            datetime = data['datetime'];
                            datas = data['data'];
                        }).false(function(jqXHR,textStatus,errorThrown){
                            //ajax執行失敗
                            //alert("有錯誤產生，請看console log");
                            console.log(jqXHR,responseText);
                        });    
                    });

                });

=======
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
                
>>>>>>> backend-datepick
                var ctx = document.getElementById("Chart");
                var theChart = new Chart(ctx, {
                    type: 'line',
                    
                    data:{
                        labels:[datetime],
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
                            data: [datas]
                            
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