<?php
    require_once 'php/connect.php';
    if(isset($_SESSION['is_login']) && $_SESSION['is_login']):
    {
        header("Location: backend/backend.php");
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
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <!--JQUERY-->

        <!--JavaScript-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--JavaScript-->
    </head>
    <body>
        <div class="topbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <br>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary" onclick="location.href='register.php'">註冊</button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='index.php'">登入</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <embed src="./image/barrier.svg" style="display:block; width:70px; height:70px; margin:auto;"/>
                        <br>
                        <h2 class="text-center">自動化農場監測</h2>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-4 ml-auto mr-auto">
                            <p id="login_status" class="text-center"></p>
                            <form method="POST" id="login-form" action="php/check_login.php">
                                <div class="form-group">
                                    <label for="id">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="帳號">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="密碼">
                                </div>
                                <div class="col-sm-12 text-center">
                                    <button type="submit" id="submit" class="btn btn-default">Login</button>                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
        </div>

        <script>
        $(document).ready(function(){
            $('#login-form').on("submit",function(){
                $.ajax({
                    type:"POST",//使用表單的方式傳送，同form的method
                    url:"php/check_login.php",
                    data:
                    {
                        'id':$('#username').val(),
                        'pw':$('#password').val()
                    },
                    dataType:'html'
                }).done(function(data){
                    //console.log(data);
                    //ajax執行成功(if HTTP return 200 OK)
                    if(data=='success')
                    {
                        window.location.href = "backend/backend.php";
                    }
                    else if(data.indexOf("IdOrPasswordFail")!=-1)//若沒找到字串則會回傳-1
                    {
                        document.getElementById("login_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>帳號或密碼錯誤，請檢查欄位是否正確</div>'
                    }
                    else if(data.indexOf("UsernameNotExists")!=-1)
                    {
                        document.getElementById("login_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>使用者帳號不存在，請註冊新帳號</div>'
                    }
                    else if(data.indexOf("NoIdAndPassword")!=-1)
                    {
                        document.getElementById("login_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>帳號或密碼不可為空值</div>'
                    }
                    else if(data.indexOf("TransferFailed")!=-1)
                    {
                        document.getElementById("login_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>帳號或密碼未正確傳送</div>'
                    }
                    else
                    {
                        console.log(data);
                    }
                }).fail(function(jqXHR,textStatus,errorThrown){
                    //ajax執行失敗
                    //alert("有錯誤產生，請看console log");
                    console.log(jqXHR,responseText);
                });
            return false;
            });
        });
        
        </script>
        


    </body>
</html>

<?php
    endif;
?>