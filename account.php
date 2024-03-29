<?php
    @require_once 'php/connect.php';
    @require_once 'php/backend/function.php';
    if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
    {
        @header("Location: index.php");
    }
    else:
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>智慧化環境監測管理系統</title>
        <meta name="keyword" content="智慧化'自動化'環境'監測'管理'系統'智慧化環境監測管理系統"><!--keyword讓搜索引擎容易找到此網頁-->
        <meta name="viewport" content="width=device-width, initial-scale=1" ><!--指定螢幕寬度為裝置寬度，畫面載入初始縮放比例 100%-->
        <link rel="icon" href="image/barrier.ico">
        <noscript>
            
        </noscript>
        <link rel="stylesheet" href="css/style.css" type="text/css" charset="utf8">
        <!--JQUERY-->
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <!--JQUERY-->

        <!--Popper.JS-->
        <script src="js/popper-1.14.3.min.js"></script>
        <!--Popper.JS-->

        <!--Bootstrap-->
        <script src="js/bootstrap-4.1.3.min.js"></script>
        <!--Bootstrap-->
        
        <!--Bootstrap CSS-->
        <link rel="stylesheet" href="css/bootstrap.css">
        <!--Bootstrap CSS-->

    </head>
    <body>
        <div class="background">
            <div class="account_topbar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <br>
                            <!--顯示登入中帳號的資訊與登出按鈕-->
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-info" onclick="location.href='monitor.php'">農場監測</button>
                                <button type="button" class="btn btn-info" onclick="location.href='php/logout.php'">登出</button>
                            </div>
                            <!--顯示登入中帳號的資訊與登出按鈕-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!--顯示LOGO與標題-->
                            <embed src="image/barrier.svg" style="display:inline; vertical-align:middle; width:70px; height:70px; margin:auto;">
                            <h2 style="display:inline; vertical-align:middle;">智慧化環境監測管理系統</h2>
                            <!--顯示LOGO與標題-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-5 ml-auto mr-auto jumbotronSet">
                            <h2 class="text-center">Account</h2>
                            <div class="jumbotron jumbotron-fluid border">
                                <div class="container" id="account_edit">
                                    <ul class="list-group account-list-group">
                                        <?php
                                            @get_user_information();
                                        ?>
                                        <li class="list-group-item list-group-item-action borderless" id="usernameList">
                                            Username&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="username"><?php echo $_SESSION["login_user_id"]; ?></strong>
                                        </li>
                                        <li class="list-group-item list-group-item-action borderless" id="passwordList">
                                            <div style="float:right;">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="17" viewBox="0 0 48 48" width="17">
                                                    <g>
                                                        <path d="M6 34.5v7.5h7.5l22.13-22.13-7.5-7.5-22.13 22.13zm35.41-20.41c.78-.78.78-2.05 0-2.83l-4.67-4.67c-.78-.78-2.05-.78-2.83 0l-3.66 3.66 7.5 7.5 3.66-3.66z"/>
                                                        <path d="M0 0h48v48h-48z" fill="none"/>
                                                        <rect class="btn" x="0" y="0" width="50" height="50" onclick="editClick('passwordEdit')" />
                                                    </g>
                                                </svg>
                                            </div>
                                            Password&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="password">***************</strong>
                                        </li>
                                        <li class="list-group-item list-group-item-action borderless" id="phoneList">
                                            <div style="float:right;">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="17" viewBox="0 0 48 48" width="17">
                                                    <g>
                                                        <path d="M6 34.5v7.5h7.5l22.13-22.13-7.5-7.5-22.13 22.13zm35.41-20.41c.78-.78.78-2.05 0-2.83l-4.67-4.67c-.78-.78-2.05-.78-2.83 0l-3.66 3.66 7.5 7.5 3.66-3.66z"/>
                                                        <path d="M0 0h48v48h-48z" fill="none"/>
                                                        <rect class="btn" x="0" y="0" width="50" height="50" onclick="editClick('phoneEdit')" />
                                                    </g>
                                                </svg>
                                            </div>
                                            Phone&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="phone"><?php echo $_SESSION["login_user_phone"]; ?></strong>
                                        </li>
                                        <li class="list-group-item list-group-item-action borderless" id="nameList">
                                            <div style="float:right;">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="17" viewBox="0 0 48 48" width="17">
                                                    <g>
                                                        <path d="M6 34.5v7.5h7.5l22.13-22.13-7.5-7.5-22.13 22.13zm35.41-20.41c.78-.78.78-2.05 0-2.83l-4.67-4.67c-.78-.78-2.05-.78-2.83 0l-3.66 3.66 7.5 7.5 3.66-3.66z"/>
                                                        <path d="M0 0h48v48h-48z" fill="none"/>
                                                        <rect class="btn" x="0" y="0" width="50" height="50" onclick="editClick('nameEdit')" />
                                                    </g>
                                                </svg>
                                            </div>
                                            Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="name"><?php echo $_SESSION["login_user_name"]; ?></strong>
                                        </li>
                                        <li class="list-group-item list-group-item-action borderless" id="emailList">
                                            <div style="float:right;">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="17" viewBox="0 0 48 48" width="17">
                                                    <g>
                                                        <path d="M6 34.5v7.5h7.5l22.13-22.13-7.5-7.5-22.13 22.13zm35.41-20.41c.78-.78.78-2.05 0-2.83l-4.67-4.67c-.78-.78-2.05-.78-2.83 0l-3.66 3.66 7.5 7.5 3.66-3.66z"/>
                                                        <path d="M0 0h48v48h-48z" fill="none"/>
                                                        <rect class="btn" x="0" y="0" width="50" height="50" onclick="editClick('emailEdit')" />
                                                    </g>
                                                </svg>
                                            </div>
                                            Email&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="email"><?php echo $_SESSION["login_user_email"]; ?></strong>
                                        </li>
                                        <li class="list-group-item list-group-item-action borderless" id="identityList">
                                            <div style="float:right;">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="17" viewBox="0 0 48 48" width="17">
                                                    <g>
                                                        <path d="M6 34.5v7.5h7.5l22.13-22.13-7.5-7.5-22.13 22.13zm35.41-20.41c.78-.78.78-2.05 0-2.83l-4.67-4.67c-.78-.78-2.05-.78-2.83 0l-3.66 3.66 7.5 7.5 3.66-3.66z"/>
                                                        <path d="M0 0h48v48h-48z" fill="none"/>
                                                        <rect class="btn" x="0" y="0" width="50" height="50" onclick="editClick('identityEdit')" />
                                                    </g>
                                                </svg>
                                            </div>
                                            Identity&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="identity">
                                                <?php
                                                    $i = 0; 
                                                    foreach($_SESSION["login_user_identity"] as $row)
                                                    {
                                                        if($i == 0)
                                                        {
                                                            echo $row[0]." ".$row[1];
                                                        }
                                                        else
                                                        {
                                                            echo "</br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$row[0]." ".$row[1];
                                                        }
                                                        $i++;
                                                    } 
                                                ?>
                                            </strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 ml-auto mr-auto jumbotronSet">
                            <h2 class="text-center">Arduino</h2>
                            <div class="jumbotron jumbotron-fluid border">
                                <div class="container" id="arduinoInfo_edit">
                                    <!--顯示選擇農場按鈕-->
                                    <?php
                                        @account_get_farm();
                                    ?>
                                    <!--顯示選擇農場按鈕-->
                                    <div id="choose_arduino"></div>
                                </div>
                            </div>
                        </div>
                        <?php 
                            //若身分為管理員，顯示權限管理區塊
                            $status=0;
                            foreach($_SESSION['login_user_identity'] as $row)
                            {
                                if($row[1] == "ADMIN" || $row[1] == "MIS")
                                {
                                    $status = 1;
                                    break;
                                }
                            }
                            if($status == 1):
                        ?>
                        <div class="col-sm-5 ml-auto mr-auto jumbotronSet">
                            <h2 class="text-center">PermissionAudit</h2>
                            <div class="jumbotron jumbotron-fluid border">
                                <div class="container" id="permission_admin">
                                    <p id="edit_status" class="text-center"></p>     
                                    <?php 
                                        @get_application_list();
                                    ?>
                                </div>
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-info" id="application_delete">刪除申請</button>
                                    <button class="btn btn-info" id="application_permit">允許權限</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 ml-auto mr-auto jumbotronSet">
                            <h2 class="text-center">PermissionList</h2>
                            <div class="jumbotron jumbotron-fluid border">
                                <div class="container" id="permission_list">
                                    <?php 
                                        @get_manage_list();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
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
        </div>

        <script>
            //點擊Account區塊編輯圖示觸發
            function editClick(editType)
            {
                if(editType=="usernameEdit")
                {

                }
                else if(editType=="passwordEdit")
                {
                    var data = {type:1};
                    $.ajax({
                        type : "post",
                        url : "php/backend/account_edit/password.php",
                        data : data
                    }).done(function(dates){
                        $("#account_edit").html(dates);//要刷新的div
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
                }
                else if(editType=="phoneEdit")
                {
                    var data = {type:1};
                    $.ajax({
                        type : "post",
                        url : "php/backend/account_edit/phone.php",
                        data : data
                    }).done(function(dates){
                        $("#account_edit").html(dates);//要刷新的div
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
                }
                else if(editType=="nameEdit")
                {
                    var data = {type:1};
                    $.ajax({
                        type : "post",
                        url : "php/backend/account_edit/name.php",
                        data : data
                    }).done(function(dates){
                        $("#account_edit").html(dates);//要刷新的div
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
                }
                else if(editType=="emailEdit")
                {
                    var data = {type:1};
                    $.ajax({
                        type : "post",
                        url : "php/backend/account_edit/email.php",
                        data : data
                    }).done(function(dates){
                        $("#account_edit").html(dates);//要刷新的div
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
                }
                else if(editType=="identityEdit")
                {
                    var data = {type:1};
                    $.ajax({
                        type : "post",
                        url : "php/backend/account_edit/identity.php",
                        data : data
                    }).done(function(dates){
                        $("#account_edit").html(dates);//要刷新的div
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
                }
                return false;
            }

            function arduinoEditClick(arduino)
            {
                var data = {type:1,oldarduino:arduino};
                    $.ajax({
                        type : "POST",
                        url : "php/backend/arduino_edit/arduino.php",
                        data : data
                    }).done(function(dates){
                        $("#choose_arduino").html(dates);//要刷新的div
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
            }

            function editPeopleClick(input)
            {
                var identity_array = new Array();

                identity_array = input.split(",");
                var data = {type:1,permissionInfo:identity_array};
                    $.ajax({
                        type : "POST",
                        url : "php/backend/permission_edit/permission_edit.php",
                        data : data
                    }).done(function(dates){
                        $("#permission_list").html(dates);//要刷新的div
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
            }

            $(document).ready(function(){
                
                //點擊Permission區塊觸發新增權限功能
                $('#application_permit').click(function() {
                    $.ajax({
                        type:"POST",//使用表單的方式傳送，同form的method
                        url:"php/backend/application_permit.php",
                        data:
                        {
                            'username':$('.carousel-inner div.active #application_username strong').text(),
                            'farm':$('.carousel-inner div.active #application_farm strong').text(),
                            'identity':$('.carousel-inner div.active #application_identity strong').text(),
                            'dateTime':$('.carousel-inner div.active #application_dateTime strong').text()
                        },
                        dataType:'html'
                    }).done(function(data){
                        //ajax執行成功(if HTTP return 200 OK)
                        if(data=='success')
                        {
                            //新增權限成功
                            document.getElementById("edit_status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>新增權限成功</div>';
                            setTimeout('window.location.href = "account.php";',5000);
                        }
                        else if(data=='applicationDataNotDelete')
                        {
                            //新增權限成功，申請資料尚未刪除
                            document.getElementById("edit_status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>新增權限成功，申請資料尚未刪除</div>';
                            setTimeout('window.location.href = "account.php";',5000);
                        }
                        else if(data=='duplicatePrimaryKey')
                        {
                            //語法執行失敗，權限已存在
                            document.getElementById("edit_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>權限已存在</div>';
                        }
                        else
                        {
                            document.getElementById("edit_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>新增權限失敗</div>';
                            console.log(data);
                        }
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //ajax執行失敗
                        //alert("有錯誤產生，請看console log");
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
                    return false;
                });
                
                //刪除權限申請資料功能
                $('#application_delete').click(function() {
                    $.ajax({
                        type:"POST",//使用表單的方式傳送，同form的method
                        url:"php/backend/application_delete.php",
                        data:
                        {
                            'username':$('.carousel-inner div.active #application_username strong').text(),
                            'farm':$('.carousel-inner div.active #application_farm strong').text(),
                            'identity':$('.carousel-inner div.active #application_identity strong').text()
                        },
                        dataType:'html'
                    }).done(function(data){
                        //ajax執行成功(if HTTP return 200 OK)
                        if(data=='applicationDataDeleteSuccess')
                        {
                            //刪除資料成功
                            document.getElementById("edit_status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>申請資料已刪除</div>';
                            setTimeout('window.location.href = "account.php";',5000);
                        }
                        else if(data=='applicationDataDeleteFail')
                        {
                            //刪除資料失敗
                            document.getElementById("edit_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>申請資料刪除失敗</div>';
                            setTimeout('window.location.href = "account.php";',5000);
                        }
                        else
                        {
                            console.log(data);
                        }
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //ajax執行失敗
                        //alert("有錯誤產生，請看console log");
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
                    return false;
                });
                
                //讓carousel不自動切換
                $('.carousel').carousel({
                    interval: false
                }); 

                //當觸發選擇農場下拉式選單時
                $("#arduinoChoose1stChild").on('click', 'a', function(e){
                    //console.log($(this).text().substring(0,10));
                    
                    //選擇農場後收合下拉式選單
                    $('#arduinoChoose').removeClass("show");
                    $('#arduinoChoose1stChild').removeClass("show");
                    
                    //將下拉式選單按鈕改為選擇的農場編號
                    $("#arduinoChoose:first-child").text($(this).text().substring(0,10));
                    $("#arduinoChoose:first-child").val($(this).text().substring(0,10));
                    

                    $.ajax({
                        type:"POST",//使用表單的方式傳送，同form的method
                        url:"php/backend/get_arduino.php",
                        async: true,
                        cache: false,
                        data:
                        {
                            'farm':$("#arduinoChoose:first-child").val()
                        },
                        dataType:'json'
                    }).done(function(data){
                        var html = "";
                        html=html+'<ul class="list-group arduino-list-group">';
                        for(var i=0;i<data.arduino.length;i++)
                        {
                            html=html+'<li class="list-group-item list-group-item-action borderless" id="'+data.arduino[i]['arduino#']+'">';
                            html=html+'<div style="float:right;">';
                            html=html+'<svg xmlns="http://www.w3.org/2000/svg" height="17" viewBox="0 0 48 48" width="17">';
                            html=html+'<g><path d="M6 34.5v7.5h7.5l22.13-22.13-7.5-7.5-22.13 22.13zm35.41-20.41c.78-.78.78-2.05 0-2.83l-4.67-4.67c-.78-.78-2.05-.78-2.83 0l-3.66 3.66 7.5 7.5 3.66-3.66z"/><path d="M0 0h48v48h-48z" fill="none"/><rect class="btn" x="0" y="0" width="50" height="50" onclick="arduinoEditClick(\''+data.arduino[i]['arduino#']+'\')" /></g>';
                            html=html+'</svg>';
                            html=html+'</div>';
                            html=html+data.arduino[i]['arduino#']+'&nbsp';
                            html=html+'<strong>'+data.arduino[i]['positionDescription']+'</strong>';
                            html=html+'</li>';
                        }
                        html=html+'<li class="list-group-item list-group-item-action borderless" id="newArduino">';
                        html=html+' + 加入新的Arduino'+'&nbsp';
                        html=html+'</li>';
                        html=html+'</ul>';
                        document.getElementById("choose_arduino").innerHTML = html;
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //ajax執行失敗
                        //alert("有錯誤產生，請看console log");
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });  
                    return false;  
                });
            });

            //當觸發變更Arduino列表時
            $(document).on("click",".arduino-list-group li",function(e){
                
                //若點選新增Arduino按鈕
                if(this.id == "newArduino")
                {
                    var data = {type:1,farm:$("#arduinoChoose:first-child").val()};
                    $.ajax({
                        type : "POST",
                        url : "php/backend/arduino_edit/arduino_add.php",
                        data : data
                    }).done(function(dates){
                        $("#choose_arduino").html(dates);//要刷新的div
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
                }
            }); 
        </script>

    </body>
</html>

<?php
    endif;
?>