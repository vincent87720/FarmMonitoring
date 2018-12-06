<?php
    require_once 'php/connect.php';
    require_once 'php/backend/function.php';
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
        <link rel="stylesheet" href="css/bootstrap.css">
        <!--Bootstrap CSS-->
        
        <!--JQUERY-->
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <!--JQUERY-->

        <!--JavaScript-->
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <!--JavaScript-->
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
                            <h2 style="display:inline; vertical-align:middle;">自動化農場監測</h2>
                            <!--顯示LOGO與標題-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-5 ml-auto">
                            <h2 class="text-center">Account</h2>
                            <div class="jumbotron jumbotron-fluid border">
                                <div class="container">
                                    <ul class="list-group">
                                        <?php
                                            get_user_information();
                                        ?>
                                        <li class="list-group-item list-group-item-action borderless">
                                            Username&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="username"><?php echo $_SESSION["login_user_id"]; ?></strong>
                                        </li>
                                        <li class="list-group-item list-group-item-action borderless">
                                            <div style="float:right;"><embed src="image/edit.svg" style="display:inline; vertical-align:middle; width:17px; height:17px; margin:right;"></div>
                                            Password&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="password">***************</strong>
                                        </li>
                                        <li class="list-group-item list-group-item-action borderless">
                                            <div style="float:right;"><embed src="image/edit.svg" style="display:inline; vertical-align:middle; width:17px; height:17px; margin:right;"></div>                                            Phone&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="phone"><?php echo $_SESSION["login_user_phone"]; ?></strong>
                                        </li>
                                        <li class="list-group-item list-group-item-action borderless">
                                            <div style="float:right;"><embed src="image/edit.svg" style="display:inline; vertical-align:middle; width:17px; height:17px; margin:right;"></div>                                            Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="name"><?php echo $_SESSION["login_user_name"]; ?></strong>
                                        </li>
                                        <li class="list-group-item list-group-item-action borderless">
                                            <div style="float:right;"><embed src="image/edit.svg" style="display:inline; vertical-align:middle; width:17px; height:17px; margin:right;"></div>                                            Email&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="email"><?php echo $_SESSION["login_user_email"]; ?></strong>
                                        </li>
                                        <li class="list-group-item list-group-item-action borderless">
                                            Identity&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <strong id="identity"><?php echo $_SESSION["login_user_identity"]; ?></strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php 
                            //若身分為管理員，顯示權限管理區塊
                            if($_SESSION['login_user_identity']=='admin'):
                        ?>
                        <div class="col-sm-5 mr-auto">
                            <h2 class="text-center">Permission</h2>
                            <div class="jumbotron jumbotron-fluid border">
                                <div class="container">                                                           
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
            $(document).on("ready",function(){
                $.ajax({
                    type:"POST",//使用表單的方式傳送，同form的method
                    url:"php/backend/get_user_information.php",
                    dataType:'json'
                }).done(function(data){
                    var phone=null,name=null,email=null,identity=null;
                    console.log(data[0]["phone"]);

                    phone.push(data[0]["phone"]);
                    name=data[0]["name"];
                    email=data[0]["email"];
                    identity=data[0]["identity"];
                    document.getElementById("phone").innerHTML = $_SESSION["login_user_id"];
                    document.getElementById("phone").innerHTML = phone;
                    document.getElementById("name").innerHTML = name;
                    document.getElementById("email").innerHTML = email;
                    document.getElementById("identity").innerHTML = identity;

                }).fail(function(jqXHR,textStatus,errorThrown){
                    //ajax執行失敗
                    //alert("有錯誤產生，請看console log");
                    console.log(jqXHR,responseText);
                });
            });
        </script>

    </body>
</html>

<?php
    endif;
?>