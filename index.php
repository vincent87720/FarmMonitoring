<!DOCTYPE HTML>
<html>
    <head>
        <title>自動化農場監測</title>
        <meta name="keyword" content="農場'自動化農場'農場數據監測'"><!--keyword讓搜索引擎容易找到此網頁-->
        <meta name="viewport" content="width=device-width, initial-scale=1" ><!--指定螢幕寬度為裝置寬度，畫面載入初始縮放比例 100%-->
        <link rel="icon" href="./image/barrier.ico">
        <noscript>
            
        </noscript>
        <link rel="stylesheet" href="css/style.css" type="text/css" charset="utf8">
        <!--Bootstrap CSS-->
        <link rel="stylesheet" href="css/bootstrap.css">
        <!--Bootstrap CSS-->

        <!--JQUERY-->
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <!--JQUERY-->

    </head>
    <body>
        <!-- CheckLogin -->
        <?php
            if(isset($_SESSION['is_login']) && $_SESSION['is_login']==TRUE):
                header('Location: backend.php');
            else:
        ?>
        <!-- CheckLogin -->

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
                            <form method="POST" id="login-form" action="php/check_login.php">
                                <!--顯示錯誤訊息-->
                                <?php
								if(isset($_GET['msg']))
								{
                                    if(!strcmp($_GET['msg'],"IdOrPasswordFail"))
                                    {
                                        echo '<div class="alert alert-danger text-center" role="alert">帳號或密碼錯誤，請檢查欄位是否正確</div>';
                                    }
                                    else if(!strcmp($_GET['msg'],"UsernameNotExists"))
                                    {
                                        echo '<div class="alert alert-danger text-center" role="alert">使用者帳號不存在，請註冊新帳號</div>';
                                    }
                                    else if(!strcmp($_GET['msg'],"NoIdAndPassword"))
                                    {
                                        echo '<div class="alert alert-danger text-center" role="alert">帳號或密碼不可為空值</div>';
                                    }
                                    else if(!strcmp($_GET['msg'],"TransferFailed"))
                                    {
                                        echo '<div class="alert alert-danger text-center" role="alert">帳號或密碼未正確傳送</div>';
                                    }
                                    else
                                    {
                                        echo "<p class='error'>{$_GET['msg']}</p>";
                                    }
								}
								?>
                                <!--顯示錯誤訊息-->
                                <div class="form-group">
                                    <label for="id">Username</label>
                                    <input type="text" class="form-control" name="id" id="id" placeholder="帳號">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="密碼">
                                </div>
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-default">Login</button>                                    
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
            $('input[name="id"]').on("submit",function(){
                
            });

            $('input[name="password"]').on("submit",function(){
                
            });
        });
        
        </script>
        
        <!-- CheckLogin -->
        <?php endif;?>
        <!-- CheckLogin -->

    </body>
</html>