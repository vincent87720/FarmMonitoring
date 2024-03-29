<!DOCTYPE HTML>
<html>
    <head>
        <title>智慧化環境監測管理系統</title>
        <meta name="keyword" content="智慧化'自動化'環境'監測'管理'系統'智慧化環境監測管理系統"><!--keyword讓搜索引擎容易找到此網頁-->
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

        <!--JavaScript-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--JavaScript-->
    </head>
    <body>
        <div class="background">
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
                            <h2 class="text-center">智慧化環境監測管理系統</h2>
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
                                <form method="post" name="register" id="register_form">
                                    <p id="register_status" class="text-center"></p>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="帳號" required>
                                        <div class="invalid-feedback">
                                        <p id="demo"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="密碼" required>
                                        <div class="invalid-feedback">
                                            密碼不得超過30個字元
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
                                            姓名不得超過30個字元
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="電話/手機" required>
                                        <div class="invalid-feedback">
                                            電話不得超過30個字元
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="E-mail" required>
                                        <div class="invalid-feedback">
                                            Email不得超過40個字元
                                        </div>
                                    </div>

                                    <div class="col-sm-12 text-center">
                                        <button type="submit" name="submit" id="submit" class="btn btn-secondary">Submit</button>                                    
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

            var status = true;
                $(document).ready(function(){
                    
                    //檢查欄位是否超過30個字元，以及檢查輸入的帳號是否已被註冊
                    $('input[name="username"]').keyup(function(){
                        //若欄位有輸入字元，則檢查該帳號是否已經被使用
                        var input = $(this).val();
                        if($(this).val()!='')
                        {
                            $.ajax({
                                type:"POST",//使用表單的方式傳送，同form的method
                                url:"php/check_username.php",
                                data://要傳過去的資料，使用物件方式呈現
                                {
                                    'n':$(this).val()//代表要傳遞這個變數n，裡面為username文字方塊裡的值
                                },
                                dataType:'html'
                            }).done(function(data){
                                //檢查帳號是否超過指定字數
                                if(input.length<=30)
                                {
                                    $('input[name="username"]').removeClass("is-invalid");
                                    //檢查帳號是否已被註冊
                                    if(data==1)
                                    {
                                        $('input[name="username"]').addClass("is-invalid");
                                        document.getElementById("demo").innerHTML = "帳號已被註冊";
                                        $("#register_form button").attr('disabled',true);
                                    }
                                    else if(data==0)
                                    {
                                        $('input[name="username"]').removeClass("is-invalid");
                                        $("#register_form button").attr('disabled',false);

                                    }
                                    else
                                    {
                                        console.log("Exception");
                                        return false;
                                    }
                                }
                                else
                                {
                                    $('input[name="username"]').addClass("is-invalid");
                                    $("#register_form button").attr('disabled',true);
                                    document.getElementById("demo").innerHTML = "帳號不得超過30個字元";
                                }
                            }).fail(function(jqXHR,textStatus,errorThrown){
                                //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                            });
                        }
                        else
                        {
                            $('input[name="username"]').removeClass("is-invalid");
                            $("#register_form button").attr('disabled',false);
                        }
                    });



                    //當表單送出去的時候，檢查密碼與確認密碼是否相符
                    $("#register_form").keyup(function(){
                        
                        if($('input[name="password"]').val()!=$('input[name="confirm-password"]').val())
                        {
                            //若不相符，則在confirm-password的上一層增加上is-invalid
                            $("#confirm-password").addClass("is-invalid");
                            $("#register_form button").attr('disabled',true);
                            return false;
                        }
                        else
                        {
                            $("#confirm-password").removeClass("is-invalid");
                            $("#register_form button").attr('disabled',false);
                            return true;
                        }
                    });

                    //檢查密碼是否超過指定字數
                    $('#password').keyup(function(){
                        var length = $(this).val().length;
                        if(length>30)
                        {
                            $("#password").addClass("is-invalid");
                            $("#register_form button").attr('disabled',true);
                            return false;
                        }
                        else
                        {
                            $("#password").removeClass("is-invalid");
                            $("#register_form button").attr('disabled',false);
                            return true;
                        }
                    });

                    //檢查姓名是否超過指定字數
                    $('#name').keyup(function(){
                        var length = $(this).val().length;
                        if(length>30)
                        {
                            $('#name').addClass("is-invalid");
                            $("#register_form button").attr('disabled',true);
                            return false;
                        }
                        else
                        {
                            $('#name').removeClass("is-invalid");
                            $("#register_form button").attr('disabled',false);
                            return true;
                        }
                    });

                    //檢查電話是否超過指定字數
                    $('#phone').keyup(function(){
                        var length = $(this).val().length;
                        if(length>30)
                        {
                            $('#phone').addClass("is-invalid");
                            $("#register_form button").attr('disabled',true);
                            return false;
                        }
                        else
                        {
                            $('#phone').removeClass("is-invalid");
                            $("#register_form button").attr('disabled',false);
                            return true;
                        }
                    });

                    //檢查email是否超過指定字數
                    $('#email').keyup(function(){
                        var length = $(this).val().length;
                        if(length>40)
                        {
                            $('#email').addClass("is-invalid");
                            $("#register_form button").attr('disabled',true);
                            return false;
                        }
                        else
                        {
                            $('#email').removeClass("is-invalid");
                            $("#register_form button").attr('disabled',false);
                            return true;
                        }
                    });


                    //若class:"form-control" not has class:"is-invalid" ，且每個欄位都不為空值，代表無誤，可送出表單
                    $('#register_form').on("submit",function(){
                        if(!$('.form-control').hasClass("is-invalid")&&
                            $('input[name="username"]').val()!=''&&
                            $('input[name="password"]').val()!=''&&
                            $('input[name="confirm-password"]').val()!=''&&
                            $('input[name="name"]').val()!=''&&
                            $('input[name="phone"]').val()!=''&&
                            $('input[name="email"]').val()!='')
                        {
                            //document.getElementById("register_status").innerHTML = '<div class="alert alert-success text-center" role="alert">註冊成功! 頁面將在5秒後跳轉</div>';
                            $.ajax({
                                type:"POST",//使用表單的方式傳送，同form的method
                                url:"php/add_user.php",
                                //data:$('#register_form').serializeArray(),
                                data:
                                {
                                    'username':$('input[name="username"]').val(),
                                    'password':$('input[name="password"]').val(),
                                    'name':$('input[name="name"]').val(),
                                    'phone':$('input[name="phone"]').val(),
                                    'email':$('input[name="email"]').val()
                                },
                                dataType:'html'
                            }).done(function(data){
                                //console.log(data);
                                //ajax執行成功(if HTTP return 200 OK)
                                if(data==1)
                                {
                                    //五秒鐘後跳轉
                                    document.getElementById("register_status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>註冊成功!! 五秒後跳轉登入頁面</div>';
                                    setTimeout('window.location.href = "index.php";',5000);

                                    //不跳轉，提供一個連結按鈕
                                    //document.getElementById("register_status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>註冊成功!! 按<a href="index.php" class="alert-link">這裡</a>或右上方按鈕登入</div>';
                                                                    
                                }
                                else if(data==0)
                                {
                                    document.getElementById("register_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>註冊失敗</div>';
                                }
                                else
                                {
                                    //console.log(data);
                                }
                            }).fail(function(jqXHR,textStatus,errorThrown){
                                //ajax執行失敗
                                //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                            });    
                        }
                        else
                        {
                            document.getElementById("register_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>欄位未依格式填寫，請檢查</div>';
                        }
                    return false;
                    });
                });
            </script>
        </div>
    </body>
</html>