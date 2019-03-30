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
                <form id="arduino_change_form">
                <div class="form-group">
                    <label for="arduinoNum">Arduino編號</label>
                    <input type="text" class="form-control" id="arduinoNum" placeholder="ARDUINO000" value="" required>
                    <div class="invalid-feedback">
                        ARDUINO編號不得超過10個字元
                    </div>
                </div>
                <div class="form-group">
                    <label for="positionDescription">Arduino名稱</label>
                    <input type="text" class="form-control" id="positionDescription" placeholder="培養皿" required>
                    <div class="invalid-feedback">
                        ARDUINO名稱不得超過40個字元
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="GPS">GPS</label>
                    <input type="text" class="form-control" id="GPS" placeholder="24.000531, 120.598504" required>
                    <div class="invalid-feedback">
                        GPS名稱不得超過30個字元
                    </div>
                </div> -->
                <div class="col-sm-12 text-center">
                    <a href="../../../account.php" class="btn btn-info" role="button" aria-pressed="true" id="backbutton">返回</a>
                    <button type="submit" class="btn btn-info">確認修改</button>
                </div>
                </form>
            </div>
        </div>
        <script>

            $(document).ready(function(){
                
                $('#arduinoNum').val("<?php echo $_POST['oldarduino'];?>");
                //檢查Arduino編號是否超過指定字數
                $('#arduinoNum').keyup(function(){
                    var length = $(this).val().length;
                    if(length>10)
                    {
                        $("#arduinoNum").addClass("is-invalid");
                        $("#arduino_change_form button").attr('disabled',true);
                        return false;
                    }
                    else
                    {
                        $("#arduinoNum").removeClass("is-invalid");
                        $("#arduino_change_form button").attr('disabled',false);
                        return true;
                    }
                });

                //檢查Arduino名稱是否超過指定字數
                $('#positionDescription').keyup(function(){
                    var length = $(this).val().length;
                    if(length>40)
                    {
                        $("#positionDescription").addClass("is-invalid");
                        $("#arduino_change_form button").attr('disabled',true);
                        return false;
                    }
                    else
                    {
                        $("#positionDescription").removeClass("is-invalid");
                        $("#arduino_change_form button").attr('disabled',false);
                        return true;
                    }
                });

                //檢查Arduino GPS是否超過指定字數
                $('#GPS').keyup(function(){
                    var length = $(this).val().length;
                    if(length>30)
                    {
                        $("#GPS").addClass("is-invalid");
                        $("#arduino_change_form button").attr('disabled',true);
                        return false;
                    }
                    else
                    {
                        $("#GPS").removeClass("is-invalid");
                        $("#arduino_change_form button").attr('disabled',false);
                        return true;
                    }
                });


                $('#arduino_change_form').on("submit",function(){
                    if(!$('.form-control').hasClass("is-invalid")&&
                        $('#arduinoNum').val()!=''&&
                        $('#positionDescription').val()!=''&&
                        $('#GPS').val()!='')
                    {
                        $.ajax({
                            type:"POST",//使用表單的方式傳送，同form的method
                            url:"php/backend/change_arduino.php",
                            data:
                            {
                                'oldarduino':"<?php echo $_POST['oldarduino'];?>",
                                'arduino':$('#arduinoNum').val(),
                                'positionDescription':$('#positionDescription').val(),
                                'gps':$('#GPS').val()
                            },
                            dataType:'html'
                        }).done(function(data){
                            //ajax執行成功(if HTTP return 200 OK)
                            if(data=='ArduinoChangedSuccessfully')
                            {
                                //Arduino變更成功 
                                document.getElementById("edit_status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Arduino變更成功</div>';
                                setTimeout('window.location.href = "account.php";',5000);
                            }
                            else if(data=='ArduinoChangedFailed')
                            {
                                //Arduino變更錯誤 
                                document.getElementById("edit_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Arduino變更失敗</div>';
                            }
                            else
                            {
                                //console.log(data);
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