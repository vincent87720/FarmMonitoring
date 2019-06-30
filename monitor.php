<?php
    @require_once 'php/connect.php';
    if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
    {
        @header("Location: index.php");
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

            <!--顯示網頁LOGO、管理及登出按鈕-->
            <div class="topbar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <br>
                            <!--顯示登入中帳號的資訊與登出按鈕-->
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-info" onclick="location.href='account.php'"><?php echo $_SESSION['login_user_name']?>&nbsp<span class="glyphicon glyphicon-cog"></span></button>
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

            <br/>

            <!--顯示選擇農場及感測種類按鈕-->
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <!--顯示選擇農場按鈕-->
                            <?php
                                @require_once 'php/backend/function.php';
                                @get_farm();
                                ?>
                            <!--顯示選擇農場按鈕-->

                            <!--顯示選擇Arduino按鈕-->
                            <div id="get_arduino" style="display:inline;"></div>
                            <!--顯示選擇Arduino按鈕-->
                            <button type="button" class="btn btn-warning" id="refreshChart"><span class="glyphicon glyphicon-refresh"></span></button>
                            <br/>
                            <br/>
                        </div>
                        <div class="col-sm-8 text-center">
                            <!--選擇要觀測數值種類的按鈕-->
                            <div class="btn-group btn-group-toggle" id="dataType" data-toggle="buttons">
                                <label class="btn btn-warning">
                                    <input type="radio" name="typeOfData" id="option2" value="溫度" autocomplete="off" checked>溫度
                                </label>
                                <label class="btn btn-warning">
                                    <input type="radio" name="typeOfData" id="option3" value="濕度" autocomplete="off">濕度
                                </label>
                                <label class="btn btn-warning">
                                    <input type="radio" name="typeOfData" id="option4" value="照度" autocomplete="off">照度
                                </label>
                                <label class="btn btn-warning">
                                    <input type="radio" name="typeOfData" id="option5" value="CO2" autocomplete="off">CO2
                                </label>
                            </div>
                            <!--選擇要觀測數值種類的按鈕-->
                        </div>
                        <!-- <div class="col-sm-3"></div> -->
                        
                    </div>
                </div>
            </div>

            <!--顯示圖表及日期時間選擇功能-->
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-9 text-center">
                            <div class="col-sm-12 ml-auto mr-auto">
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
                        <div class="col-md-3 text-center ml-auto mr-auto">
                            <!--預設開始與結束日期區間按鈕-->
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-warning" id="inThePastYear">年</button>
                                <button type="button" class="btn btn-warning" id="inThePastMonth">月</button>
                                <button type="button" class="btn btn-warning" id="inThreeDays">三天</button>
                                <button type="button" class="btn btn-warning" id="inADay">日</button>
                                <button type="button" class="btn btn-warning" id="inOneHour">時</button>
                            </div>
                            <!--預設開始與結束日期區間按鈕-->

                            <br/>
                            <br/>
                            <!--選擇開始與結束日期-->
                            <div class="form-group">
                                <div class="input-group date" id="startDateTime">
                                    <input type="text" class="form-control dateTimePicker" id="startText" readonly>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group date" id="endDateTime">
                                    <input type="text" class="form-control dateTimePicker" id="endText" readonly>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </span>
                                </div>
                            </div>
                            <!--選擇開始與結束日期-->
                            <div class="panel panel-custom">
                                <div class="panel-heading">
                                    <h3 class="panel-title">總平均Average</h3>
                                </div>
                                <div class="panel-body" id="average"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--頁底-->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            
                        </div>
                    </div>
                </div>
            </div>

            <script>
                //設定DateTimePicker相關參數
                $(function () { 
                    $('#startDateTime').datetimepicker({
                        format: 'yyyy-mm-dd hh:ii:ss',
                        defaultDate:new Date(),
                        todayHighlight: true,
                        autoclose: true

                    });

                    $('#endDateTime').datetimepicker({
                        format: 'yyyy-mm-dd hh:ii:ss',
                        defaultDate:new Date(),
                        todayHighlight: true,
                        autoclose: true
                    });

                    //預設日期時間為從十天前到目前
                    //$("#startDateTime").datetimepicker("setDate", new Date(new Date()-10*24*60*60*1000));
                    //預設日期時間為從一小時前到目前
                    $("#startDateTime").datetimepicker("setDate", new Date(new Date()-60*60*1000));
                    $("#endDateTime").datetimepicker("setDate", new Date());
                    
                });

                $(document).ready(function(){
                    
                    drawChart();
                    
                    //當觸發選擇農場下拉式選單時
                    $("#farmChoose1stChild").on('click', 'li a', function(){
                        //將下拉式選單按鈕改為選擇的農場編號
                        var farmChoose = $(this).text().substring(29,39);
                        $("#farmChoose:first-child").text(farmChoose);
                        $("#farmChoose:first-child").val(farmChoose);
                        
                        //在圖表下方顯示農場位置描述
                        //$('#showFarmDescription').val()
                        document.getElementById("showFarmDescription").innerHTML = '<div class="btn-group" role="group" aria-label="Basic example"><button type="button" class="btn btn-warning">'+$(this).text().substring(96,150)+'</button></div>';
                        
                        drawChart();
                    });

                    //當觸發重新整理按鈕時
                    $("#refreshChart").on('click', function(){
                        drawChart();
                    });

                    //點選按鈕選擇監測數值的種類
                    $('#dataType').on('change',function(){
                        //若用onclick會發生值還沒改變就先被傳送的狀況
                        //必須用onchange等值改變後再呼叫drawChart函式
                        
                        //呼叫drawChart()函式繪製圖表
                        drawChart();
                    });
                    
                    //當觸發datetimepicker的開始日期時
                    $('#startDateTime').datetimepicker().on('changeDate', function(ev){
                        //隱藏日期時間選擇器
                        $('#startDateTime').datetimepicker('hide');
                        
                        //呼叫drawChart()函式繪製圖表
                        drawChart();
                    });

                    //當觸發datetimepicker的結束日期時
                    $('#endDateTime').datetimepicker().on('changeDate', function(ev){
                        //隱藏日期時間選擇器
                        $('#endDateTime').datetimepicker('hide');
                        
                        //呼叫drawChart()函式繪製圖表
                        drawChart();
                    });

                    //當觸發過去一年內按鈕，把日期時間設定為從現在往前推一年
                    $("#inThePastYear").on('click', function(){
                        $("#startDateTime").datetimepicker("setDate", new Date(new Date()-365*24*60*60*1000));
                        $("#endDateTime").datetimepicker("setDate", new Date());
                        
                        //呼叫drawChart()函式繪製圖表
                        drawChart();
                    });

                    //當觸發過去一個月內按鈕，把日期時間設定為從現在往前推一個月
                    $("#inThePastMonth").on('click', function(){
                        $("#startDateTime").datetimepicker("setDate", new Date(new Date()-31*24*60*60*1000));
                        $("#endDateTime").datetimepicker("setDate", new Date());
                        
                        //呼叫drawChart()函式繪製圖表
                        drawChart();
                    });

                    //當觸發過去三天內按鈕，把日期時間設定為從現在往前推三天
                    $("#inThreeDays").on('click', function(){
                        $("#startDateTime").datetimepicker("setDate", new Date(new Date()-3*24*60*60*1000));
                        $("#endDateTime").datetimepicker("setDate", new Date());
                        
                        //呼叫drawChart()函式繪製圖表
                        drawChart();
                    });

                    //當觸發過去一天內按鈕，把日期時間設定為從現在往前推一天
                    $("#inADay").on('click', function(){
                        $("#startDateTime").datetimepicker("setDate", new Date(new Date()-1*24*60*60*1000));
                        $("#endDateTime").datetimepicker("setDate", new Date());
                        
                        //呼叫drawChart()函式繪製圖表
                        drawChart();
                    });

                    //當觸發過去一小時內按鈕，把日期時間設定為從現在往前推一小時
                    $("#inOneHour").on('click', function(){
                        $("#startDateTime").datetimepicker("setDate", new Date(new Date()-60*60*1000));
                        $("#endDateTime").datetimepicker("setDate", new Date());
                        
                        //呼叫drawChart()函式繪製圖表
                        drawChart();
                    });
                });

                //繪製已選擇種類的圖表
                function drawChart()
                {
                    //問題：使用新數據在canvas上繪圖時，之前查詢的圖表依然存在，滑鼠在圖表上移動時，兩張圖表會來回閃動
                    //解決方法：先將上次查詢的canvas移除掉，再加入新的canvas到他的父div中
                    //參考資料：https://zhidao.baidu.com/question/1754670090672222588.html
                    $('#Chart').remove(); // this is my <canvas> element
                    $('#ChartParent').append('<canvas id="Chart"></canvas>');

                    //判斷選擇農場的下拉式選單是否有值，若沒有，則指定第一個子標籤作為預設值
                    var farmChoose = null;
                    if($("#farmChoose:first-child").val().substring(0,10)=="")
                    {
                        farmChoose = $("#farmChoose1stChild li p").text().substring(0,10);
                    }
                    else
                    {
                        farmChoose = $("#farmChoose:first-child").val();
                    }

                    $.ajax({
                        type:"POST",//使用表單的方式傳送，同form的method
                        url:"php/backend/get_monitoring_data.php",
                        async: true,
                        cache: false,
                        data:
                        {
                            'farm':farmChoose,
                            'typeOfData':$('input[name=typeOfData]:checked').val(),
                            'startText':$("#startText").val(),
                            'endText':$("#endText").val()
                        },
                        dataType:'json'

                    }).done(function(data){
                        //console.log(JSON.stringify(data));
                        var typeOfData = $('input[name=typeOfData]:checked').val();
                        var arduinoNum = data.arduino.length;
                        var dateTime = [];
                        let arduino = [];//arduino[i][j]是二維陣列，i為第幾個arduino，j對應到日期時間

                        //初始化arduino二維陣列
                        for(var i=0;i<data.arduino.length;i++)
                            arduino[i] = [];

                        //將日期時間放入dateTime陣列
                        for(var i=0;i<data.data.length;i++)
                        {
                            if(dateTime.indexOf(data.data[i]["dateTime"].substring(5,7)+'/'+data.data[i]["dateTime"].substring(8,19)) === -1)
                            {
                                dateTime.push(data.data[i]["dateTime"].substring(5,7)+'/'+data.data[i]["dateTime"].substring(8,19));
                            }
                        }

                        //            0  1  2  3  4  5  6  7  8  9 10 11 12
                        //          +--+--+--+--+--+--+--+--+--+--+--+--+--+
                        //dateTime[]|  |  |  |  |  |  |  |  |  |  |  |  |  |
                        //          +--+--+--+--+--+--+--+--+--+--+--+--+--+
                        //arduino[0]|  |  |  |  |  |  |  |  |  |  |  |  |  |
                        //          +--+--+--+--+--+--+--+--+--+--+--+--+--+
                        //arduino[1]|  |  |  |  |  |  |  |  |  |  |  |  |  |
                        //          +--+--+--+--+--+--+--+--+--+--+--+--+--+

                        //比對該筆數值對應到的arduino和日期時間是在二維陣列中的哪個，比對相同後將數值填入二維陣列中
                        //從data.data的第一筆資料開始比對
                        for(var i=0;i<data.data.length;i++)
                        {
                            for(var j=0;j<data.arduino.length;j++)
                            {
                                //比對該筆資料的arduino#跟哪個arduino相同，相同則放入對應陣列
                                if(data.data[i]["arduino#"] == data.arduino[j]["arduino#"])
                                {
                                    for(var k=0;k<dateTime.length;k++)
                                    {
                                        //若日期時間跟dateTime陣列的值相同
                                        if(data.data[i]["dateTime"].substring(5,7)+'/'+data.data[i]["dateTime"].substring(8,19) == dateTime[k])
                                        {
                                            //把數值放入對應的arduino陣列裡
                                            arduino[j][k] = data.data[i]["data"];
                                        }
                                    }
                                }
                            }
                        }

                        //計算單一時間點所有Arduino的平均
                        // var averageArray = [];
                        // var maxLength = 0;//紀錄最多筆資料的Arduino的筆數

                        // //找尋最多筆資料的Arduino的筆數
                        // for(let i=0;i<arduino.length;i++)
                        // {
                        //     if(arduino[i].length>maxLength)
                        //         maxLength = arduino[i].length;
                        // }

                        // //從0到最多筆資料的Arduino的筆數
                        // for(let i=0;i<maxLength;i++)
                        // {
                        //     var total = 0;
                        //     var num = 0;
                        //     //走訪所有該農場的arduino
                        //     for(let j=0;j<arduino.length;j++)
                        //     {
                        //         //若該時間點的arduino的數值是數字
                        //         if(!isNaN(parseInt(arduino[j][i])))
                        //         {
                        //             //則將該時間點的所有arduino的值加起來
                        //             total = total + parseInt(arduino[j][i]);
                        //             num++;
                        //         }
                                
                        //     }
                        //     //取平均
                        //     averageArray[i] = total/num;
                        // }
                        
                        //計算時間範圍內所有點的總平均
                        var totalValue = 0;
                        var num = 0;
                        var averageValue = 0;
                        for(let i=0;i<arduino.length;i++)
                        {
                            for(let j=0;j<arduino[i].length;j++)
                            {
                                //若該時間點的arduino的數值是數字
                                if(!isNaN(parseInt(arduino[i][j])))
                                {
                                    totalValue = totalValue+parseInt(arduino[i][j]);
                                    num++;
                                }
                            }
                        }
                        averageValue = totalValue/num;

                        if(typeOfData=="溫度")
                        {
                            var typeString = "溫度(℃)";
                            document.getElementById("average").innerHTML = averageValue+"(℃)";
                            var colorset = ["#F96C41","#CE1D24","#9C1E23","#F11C24","#F12422","#F12422","#CA131F","#AA1018","#E91223","#EF4137"];
                        }
                        else if(typeOfData=="濕度")
                        {
                            var typeString = "濕度(%RH)";
                            document.getElementById("average").innerHTML = averageValue+"(%RH)";
                            var colorset = ["rgb(54, 162, 235)","#5F9EA0","#2A9F9F","#2B3C46","#64A6A4","#598E8A","#7FBEB9","#96C9C4","#468DA3","#679A9A"];
                        }
                        else if(typeOfData=="照度")
                        {
                            var typeString = "照度(lm)";
                            document.getElementById("average").innerHTML = averageValue+"(lm)";
                            var colorset = ["rgb(255, 205, 86)","#FBD255","#FAAA2D","#F06C0F","#FCB619","#FEB718","#F7A731","#F2A749","#FAA524","#FFB228"];
                        }
                        else if(typeOfData=="CO2")
                        {
                            var typeString = "CO2濃度(ppm)";
                            document.getElementById("average").innerHTML = averageValue+"(ppm)";
                            var colorset = ["#A7A59C","#D5D0C9","#EAE0D8","#C1CFC8","#F4EADC","#9E8E87","#FAF6F3","#EAE7DC","#F2F2F4","#BABBBD"];
                        }

                        //將各個arduino加入dataset裡
                        var dataset = [];
                        for(var i=0;i<arduinoNum;i++)
                        {
                            dataset[i] = {
                                label: data.arduino[i]["positionDescription"],
                                fill:false,
                                spanGaps:true,//如果為true，則將在沒有數據或空數據的點之間繪製線條，若為false則中斷線條
                                lineTension: 0.1,
                                backgroundColor: colorset[i],//標示屬性的方格的背景顏色
                                borderColor:colorset[i],//線條顏色
                                borderCapStyle: 'round',//線條端點處風格為圓形
                                borderJoinStyle: 'round',//線段連接處風格為圓形
                                pointBorderColor: colorset[i],//端點外圈顏色
                                pointBackgroundColor: colorset[i],//端點內圈顏色
                                pointBorderWidth: 3,//端點外圈大小
                                pointHoverRadius: 4,//端點放大程度
                                pointHoverBorderColor: colorset[i],//端點放後大外圈顏色
                                pointHoverBackgroundColor: colorset[i],//端點放大後內圈顏色
                                pointHoverBorderWidth: 2,//端點放大後外圈大小
                                pointRadius: 2,//端點大小
                                pointHitRadius: 10,
                                data: arduino[i]
                            };
                        }

                        //加入平均圖表
                        // dataset[arduinoNum] = {
                        //     label: '平均',
                        //     fill:false,
                        //     spanGaps:true,//如果為true，則將在沒有數據或空數據的點之間繪製線條，若為false則中斷線條
                        //     lineTension: 0.1,
                        //     backgroundColor: "rgba(153, 153, 153, 1)",//標示屬性的方格的背景顏色
                        //     borderColor:"rgba(153, 153, 153, 1)",//線條顏色
                        //     borderCapStyle: 'round',//線條端點處風格為圓形
                        //     borderJoinStyle: 'round',//線段連接處風格為圓形
                        //     pointBorderColor: "rgba(153, 153, 153, 1)",//端點外圈顏色
                        //     pointBackgroundColor: "rgba(153, 153, 153, 1)",//端點內圈顏色
                        //     pointBorderWidth: 1,//端點外圈大小
                        //     pointHoverRadius: 1,//端點放大程度
                        //     pointHoverBorderColor: "rgba(153, 153, 153, 1)",//端點放後大外圈顏色
                        //     pointHoverBackgroundColor: "rgba(153, 153, 153, 1)",//端點放大後內圈顏色
                        //     pointHoverBorderWidth: 1,//端點放大後外圈大小
                        //     pointRadius: 1,//端點大小
                        //     pointHitRadius: 10,
                        //     data: averageArray
                        // };
                    
                    
                        Chart.defaults.global.defaultFontSize = 14;
                        Chart.defaults.global.defaultFontFamily = "'setofont'";
                        var ctx = document.getElementById("Chart");
                        var theChart = new Chart(ctx, {
                            type: 'line',
                            data:{
                                labels:dateTime,
                                datasets:dataset
                            },
                            options: 
                            {
                                scales: 
                                {
                                    xAxes: 
                                    [{
                                        display: true,
                                        scaleLabel: 
                                        {
                                            display: true,
                                            labelString: '日期時間'
                                        }
                                    }],
                                    yAxes: 
                                    [{
                                        display: true,
                                        scaleLabel: 
                                        {
                                            display: true,
                                            labelString: typeString
                                        }
                                    }]
                                }
                            }
                        });
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //ajax執行失敗
                        //alert("有錯誤產生，請看console log");
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });  
                    return false;  
                }

                //繪製無數據基本圖表
                function drawChart_Basic()
                {
                    var ctx = document.getElementById("Chart");
                    var theChart = new Chart(ctx, {
                        type: 'line',
                        
                        data:{
                            labels:[1,2,3,4,5,6],
                            datasets: [{
                                label: 'DataType',
                                fill:false,
                                lineTension: 0.1,
                                backgroundColor: "#F96C41",//標示屬性的方格的背景顏色
                                borderColor:"#F96C41",//線條顏色
                                borderCapStyle: 'round',//線條端點處風格為圓形
                                borderJoinStyle: 'round',//線段連接處風格為圓形
                                pointBorderColor: "#F96C41",//端點外圈顏色
                                pointBackgroundColor: "#F96C41",//端點內圈顏色
                                pointBorderWidth: 3,//端點外圈大小
                                pointHoverRadius: 4,//端點放大程度
                                pointHoverBorderColor: "#F96C41",//端點放後大外圈顏色
                                pointHoverBackgroundColor: "#F96C41",//端點放大後內圈顏色
                                pointHoverBorderWidth: 2,//端點放大後外圈大小
                                pointRadius: 2,//端點大小
                                pointHitRadius: 10,
                                data: [0,1,4,5,8,9]
                            }]
                        }
                    });
                }
            </script>
        </div>
    </body>
</html>

<?php
    endif;
?>