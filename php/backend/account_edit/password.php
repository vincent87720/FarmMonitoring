<?php 
require_once '../../connect.php';
require_once '../function.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-10 ml-auto mr-auto">
                <p id="varify_status" class="text-center"></p>
                <form id="password_change_form">
                <div class="form-group">
                    <label for="current-password">Current</label>
                    <input type="password" class="form-control" id="current_password" placeholder="目前的密碼">
                    <div class="invalid-feedback">
                        密碼不得超過20個字元
                    </div>
                </div>
                <div class="form-group">
                    <label for="new-password">New Password</label>
                    <input type="password" class="form-control" id="new_password" placeholder="新密碼">
                    <div class="invalid-feedback">
                        密碼不得超過20個字元
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm-password</label>
                    <input type="password" class="form-control" id="confirm_password" placeholder="確認密碼">
                    <div class="invalid-feedback">
                        請輸入與New Password相符的確認密碼
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-info">取消</button>
                    <button type="submit" class="btn btn-info">確認修改</button>
                </div>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                //當表單送出去的時候，檢查密碼與確認密碼是否相符
                $("#password_change_form").keyup(function(){
                    
                    if($("#new_password").val()!=$("#confirm_password").val())
                    {
                        //若不相符，則在confirm-password的上一層增加上is-invalid
                        $("#confirm_password").addClass("is-invalid");
                        $("#password_change_form button").attr('disabled',true);
                        return false;
                    }
                    else
                    {
                        $("#confirm_password").removeClass("is-invalid");
                        $("#password_change_form button").attr('disabled',false);
                        return true;
                    }
                });

                //檢查新密碼是否超過指定字數
                $('#new_password').keyup(function(){
                    var length = $(this).val().length;
                    if(length>20)
                    {
                        $("#new_password").addClass("is-invalid");
                        $("#password_change_form button").attr('disabled',true);
                        return false;
                    }
                    else
                    {
                        $("#new_password").removeClass("is-invalid");
                        $("#password_change_form button").attr('disabled',false);
                        return true;
                    }
                });

                //檢查目前碼是否超過指定字數
                $('#current_password').keyup(function(){
                    var length = $(this).val().length;
                    if(length>20)
                    {
                        $("#current_password").addClass("is-invalid");
                        $("#password_change_form button").attr('disabled',true);
                        return false;
                    }
                    else
                    {
                        $("#current_password").removeClass("is-invalid");
                        $("#password_change_form button").attr('disabled',false);
                        return true;
                    }
                });

                $('#password_change_form').on("submit",function(){
                    if(!$('.form-control').hasClass("is-invalid")&&
                        $('#current_password').val()!=''&&
                        $('#new_password').val()!=''&&
                        $('#confirm_password').val()!='')
                    {
                        $.ajax({
                            type:"POST",//使用表單的方式傳送，同form的method
                            url:"../change_password.php",
                            data:
                            {
                                'pw':$("#current_password").val(),
                                'nupw':$("#new_password").val()
                            },
                            dataType:'html'
                        }).done(function(data){
                            console.log(data);
                            // //ajax執行成功(if HTTP return 200 OK)
                            // if(data==1)
                            // {
                            //     document.getElementById("register_status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>修改密碼成功!!</div>';
                            //     //setTimeout('window.location.href = "account.php";',5000);
                            //     return false;
                            // }
                            // else if(data==2)
                            // {
                            //     //密碼錯誤 PasswordFail
                            //     document.getElementById("varify_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>密碼錯誤，請檢查欄位是否正確</div>';
                            //     return false;
                            // }
                            // else if(data==4)
                            // {
                            //     //密碼為空值 NoPassword
                            //     document.getElementById("varify_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>密碼不可為空值</div>';
                            //     return false;
                            // }
                            // else if(data==5)
                            // {
                            //     //密碼未正確傳送 TransferFailed
                            //     document.getElementById("varify_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>密碼未正確傳送</div>';
                            //     return false;
                            // }
                            // else
                            // {
                            //     console.log(data);
                            //     return false;
                            // }
                            // return false;
                        }).fail(function(jqXHR,textStatus,errorThrown){
                            // //ajax執行失敗
                            // //alert("有錯誤產生，請看console log");
                            // console.log(jqXHR,responseText);
                            // return false;
                        });
                    //return false;
                    }
                    else
                    {
                        document.getElementById("varify_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>欄位未依格式填寫，請檢查</div>';
                    }
                    return false;
                });
            });
        </script>
    </body>
</html>