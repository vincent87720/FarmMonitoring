<?php
    require_once 'php/connect.php';
    if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
    {
        header("Location: index.php");
    }
    else:
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>自動化農場監測</title>
        <meta name="keyword" content="農場'自動化農場'農場數據監測'"><!--keyword讓搜索引擎容易找到此網頁-->
        <meta name="viewport" content="width=device-width, initial-scale=1" ><!--指定螢幕寬度為裝置寬度，畫面載入初始縮放比例 100%-->
        <link rel="icon" href="image/barrier.ico">
        <noscript>
            
        </noscript>
        <link rel="stylesheet" href="css/style.css" type="text/css" charset="utf8">
        <!--Bootstrap CSS-->
        <link rel="stylesheet" href="css/bootstrap-3.3.7.css">
        <!--Bootstrap CSS-->
        
        <!--JQUERY-->
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <!--JQUERY-->

        <!--JavaScript-->
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <!--JavaScript-->

        <!--Chart.js-->
        <!-- Version 2.7.3 -->
        <script src="js/Chart.min.js"></script>
        <!--Chart.js-->

        <!--DatePicker-->
        <script type="text/javascript" src="js/moment.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.css">   
        <!-- <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script> -->
        <!--<script type="text/javascript" src="js/bootstrap.min.js"></script> -->
        <!--DatePicker-->

        
    </head>
    <body>
        <div class="background">
            <div class="topbar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <br>
                            <!--顯示登入中帳號的資訊與登出按鈕-->
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-info" onclick="location.href='account.php'"><?php echo $_SESSION['login_user_id']?></button>
                                <button type="button" class="btn btn-info" onclick="location.href='php/logout.php'">登出</button>
                            </div>
                            <!--顯示登入中帳號的資訊與登出按鈕-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!--顯示LOGO與標題-->
                            <embed src="image/barrier.svg" style="display:inline; vertical-align:middle; width:70px; height:70px; margin:auto;">
                            <h2 style="display:inline; vertical-align:middle;">自動化農場監測</h2>
                            <!--顯示LOGO與標題-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="chartOnXs col-xs-12">
                                <!--繪製圖表-->
                                <div class="chart-container" id="ChartParent" style="position: relative; height:100%; width:100%">
                                    <canvas id="Chart"></canvas>
                                </div>
                                <!--繪製圖表-->

                                <!--顯示農場位置描述-->
                                <p id="showFarmDescription" class="text-center"></p>
                                <!--顯示農場位置描述-->
                            </div>
                        </div>
                        <div class="col-sm-3 text-center ml-auto mr-auto">
                            <!--顯示選擇農場按鈕-->
                            <?php
                                require_once 'php/function.php';
                                get_farm();
                            ?>
                            <!--顯示選擇農場按鈕-->

                            <!--選擇要觀測數值種類的按鈕-->
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-warning">溫度</button>
                                <button type="button" class="btn btn-warning">濕度</button>
                                <button type="button" class="btn btn-warning">日照</button>
                            </div>
                            <!--選擇要觀測數值種類的按鈕-->
                            <br />
                            <br />
                            <!--選擇開始與結束日期-->
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
                            <!--選擇開始與結束日期-->
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
                $(document).ready(function(){
                    //當觸發datetimepicker的開始日期時
                    $('#startDateTime').datetimepicker().on('changeDate', function(ev){
                        //呼叫drawChart()函式取得資料
                        drawChart();
                    });

                    //當觸發datetimepicker的結束日期時
                    $('#endDateTime').datetimepicker().on('changeDate', function(ev){
                        //呼叫drawChart()函式取得資料
                        drawChart();
                    });

                    //當觸發選擇農場下拉式選單時
                    $(".dropdown-menu").on('click', 'li a', function(){
                        //將下拉式選單按鈕改為選擇的農場編號
                        $("#farmChoose:first-child").text($(this).text().substring(17,28));
                        $("#farmChoose:first-child").val($(this).text().substring(17,28));
                        
                        //在圖表下方顯示農場位置描述
                        $('#showFarmDescription').val()
                        document.getElementById("showFarmDescription").innerHTML = '<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-warning">'+$(this).text().substring(96,150)+'</button></div>';
                        
                        //呼叫drawChart()函式取得資料
                        drawChart();
                        
                    });
                    
                    function drawChart()
                    {
                        //乾他媽的下面這兩行方法我找超久
                        //問題：使用新數據在canvas上繪圖時，之前查詢的圖表依然存在，滑鼠在圖表上移動時，兩張圖表會來回閃動
                        //解決方法：先將上次查詢的canvas移除掉，再加入新的canvas到他的父div中
                        //參考資料：https://zhidao.baidu.com/question/1754670090672222588.html
                        $('#Chart').remove(); // this is my <canvas> element
                        $('#ChartParent').append('<canvas id="Chart"></canvas>');
                        $.ajax({
                            type:"POST",//使用表單的方式傳送，同form的method
                            url:"php/get_monitoring_data.php",
                            async: true,
                            data:
                            {
                                'farm':$("#farmChoose:first-child").val().substring(0,10),//因為是取整個<a>所以前面會空18格
                                'startText':$("#startText").val(),
                                'endText':$("#endText").val()
                            },
                            dataType:'json'

                        }).done(function(data){
                            //console.log(JSON.stringify(data));
                            var dateTime = [];
                            var sensorValue = [];

                            for(var i=0;i<data.length;i++)
                            {
                                dateTime.push(data[i]["dateTime"].substring(5,7)+'/'+data[i]["dateTime"].substring(8,16));
                                sensorValue.push(data[i]["sensorValue"].substring(0,2));
                            }
                            var ctx = document.getElementById("Chart");
                            var theChart = new Chart(ctx, {
                                type: 'line',
                                data:{
                                    labels:dateTime,
                                    datasets: [{
                                        label: '溫度',
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
                                        data: sensorValue
                                    }]
                                }
                            });
                        }).fail(function(jqXHR,textStatus,errorThrown){
                            //ajax執行失敗
                            //alert("有錯誤產生，請看console log");
                            console.log(jqXHR,responseText);
                        });    
                    }
                });
        
                

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
                        labels:[1,2,3,4,5,6],
                        datasets: [{
                            label: 'DataType',
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
                            data: [0,1,4,5,8,9]
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