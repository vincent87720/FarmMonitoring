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
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <!--JQUERY-->
    </head>
    <body>
        <div class="topbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <br>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary" onclick="location.href='register.php'">註冊</button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='index.php'">登入</button>                        </div>
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
                            <form method="post" name="register" id="register_form" action="php/add_user.php">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="帳號" required>
                                    <div class="invalid-feedback">
                                        帳號不得超過20個字元
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="密碼" required>
                                    <div class="invalid-feedback">
                                        密碼不得超過20個字元
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm-password">Confirm-password</label>
                                    <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="確認密碼" required>
                                    <div class="invalid-feedback">
                                        請輸入與password相符的確認密碼
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="姓名" required>
                                    <div class="invalid-feedback">
                                        姓名不得超過10個字元
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="電話/手機" required>
                                    <div class="invalid-feedback">
                                        電話不得超過20個字元
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="E-mail" required>
                                    <div class="invalid-feedback">
                                        Email不得超過30個字元
                                    </div>
                                </div>

                                <div class="col-sm-12 text-center">
                                    <button type="submit" name="submit" class="btn btn-default">Submit</button>                                    
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
                //當表單送出去的時候，檢查密碼與確認密碼是否相符
                $("#register_form").on("submit",function(){
                    
                    if($('input[name="password"]').val()!=$('input[name="confirm-password"]').val())
                    {
                        //若不相符，則在confirm-password的上一層增加上is-invalid
                        $("#confirm-password").addClass("is-invalid");
                        return false;
                    }
                });

                //檢查帳號是否超過指定字數
                $('input[name="username"]').keyup(function(){
                    var length = $(this).val().length;
                    if(length>20)
                    {
                        $('input[name="username"]').addClass("is-invalid");
                        return false;
                    }
                    else
                    {
                        $('input[name="username"]').removeClass("is-invalid");
                        return true;
                    }
                });

                //檢查密碼是否超過指定字數
                $('input[name="password"]').keyup(function(){
                    var length = $(this).val().length;
                    if(length>20)
                    {
                        $('input[name="password"]').addClass("is-invalid");
                        return false;
                    }
                    else
                    {
                        $('input[name="password"]').removeClass("is-invalid");
                        return true;
                    }
                });

                //檢查姓名是否超過指定字數
                $('input[name="name"]').keyup(function(){
                    var length = $(this).val().length;
                    if(length>10)
                    {
                        $('input[name="name"]').addClass("is-invalid");
                        return false;
                    }
                    else
                    {
                        $('input[name="name"]').removeClass("is-invalid");
                        return true;
                    }
                });

                //檢查電話是否超過指定字數
                $('input[name="phone"]').keyup(function(){
                    var length = $(this).val().length;
                    if(length>20)
                    {
                        $('input[name="phone"]').addClass("is-invalid");
                        return false;
                    }
                    else
                    {
                        $('input[name="phone"]').removeClass("is-invalid");
                        return true;
                    }
                });

                //檢查email是否超過指定字數
                $('input[name="email"]').keyup(function(){
                    var length = $(this).val().length;
                    if(length>30)
                    {
                        $('input[name="email"]').addClass("is-invalid");
                        return false;
                    }
                    else
                    {
                        $('input[name="email"]').removeClass("is-invalid");
                        return true;
                    }
                });
            });
        </script>
    </body>
</html>