<?php 
@require_once '../../connect.php';
@require_once '../function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    @header("Location: /index.php");
}
else:
?>
<!DOCTYPE HTML>
<html>
    <head>
    </head>
    <body>
        <div class="row">
            <div class="col-sm-10 ml-auto mr-auto">
                <p id="edit_status" class="text-center"></p>
                <form id="phone_change_form">
                <div class="form-group">
                    <label for="current_phone">Current</label>
                    <input type="text" class="form-control" id="current_phone" placeholder="目前的電話號碼" value="<?php echo $_SESSION["login_user_phone"]; ?>" readonly="readonly" required>
                    <div class="invalid-feedback">
                        電話號碼不得超過20個字元
                    </div>
                </div>
                <div class="form-group">
                    <label for="new_phone">New Phone</label>
                    <input type="text" class="form-control" id="new_phone" placeholder="新電話號碼" required>
                    <div class="invalid-feedback">
                        電話號碼不得超過20個字元
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <a href="../../../account.php" class="btn btn-info" role="button" aria-pressed="true" id="backbutton">返回</a>
                    <button type="submit" class="btn btn-info">確認修改</button>
                </div>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                //檢查目前電話號碼是否超過指定字數
                $('#current_phone').keyup(function(){
                    var length = $(this).val().length;
                    if(length>20)
                    {
                        $("#current_phone").addClass("is-invalid");
                        $("#phone_change_form button").attr('disabled',true);
                        return false;
                    }
                    else
                    {
                        $("#current_phone").removeClass("is-invalid");
                        $("#phone_change_form button").attr('disabled',false);
                        return true;
                    }
                });

                //檢查新電話號碼是否超過指定字數
                $('#new_phone').keyup(function(){
                    var length = $(this).val().length;
                    if(length>20)
                    {
                        $("#new_phone").addClass("is-invalid");
                        $("#phone_change_form button").attr('disabled',true);
                        return false;
                    }
                    else
                    {
                        $("#new_phone").removeClass("is-invalid");
                        $("#phone_change_form button").attr('disabled',false);
                        return true;
                    }
                });

                //表單送出時，驗證使用者目前的密碼，驗證成功後更改密碼
                $('#phone_change_form').on("submit",function(){
                    if(!$('.form-control').hasClass("is-invalid")&&
                        $('#current_phone').val()!=''&&
                        $('#new_phone').val()!='')
                    {
                        $.ajax({
                            type:"POST",//使用表單的方式傳送，同form的method
                            url:"php/backend/change_phone.php",
                            data:
                            {
                                'nuphone':$("#new_phone").val()
                            },
                            dataType:'html'
                        }).done(function(data){
                            //ajax執行成功(if HTTP return 200 OK)
                            if(data=='PhoneChangedSuccessfully')
                            {
                                //密碼變更成功 
                                document.getElementById("edit_status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>電話號碼變更成功</div>';
                                setTimeout('window.location.href = "account.php";',5000);
                            }
                            else if(data=='PhoneChangedFailed')
                            {
                                //密碼錯誤 
                                document.getElementById("edit_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>電話號碼變更失敗</div>';
                            }
                            else
                            {
                                console.log(data);
                            }
                            return false;
                        }).fail(function(jqXHR,textStatus,errorThrown){
                            //ajax執行失敗
                            //alert("有錯誤產生，請看console log");
                            //console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                        });
                    }
                    else
                    {
                        document.getElementById("edit_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>欄位未依格式填寫，請檢查</div>';
                    }
                    return false;
                });
            });
        </script>
    </body>
</html>

<?php
endif;
?>