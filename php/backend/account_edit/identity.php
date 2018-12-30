<?php 
require_once '../../connect.php';
require_once '../function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    header("Location: ../../../index.php");
}
else:
?>
<!DOCTYPE HTML>
<html>
    <head>
        
    </head>
    <body>
        <div class="row">
            <div class="col-sm-10 text-center ml-auto mr-auto">
                <p id="edit_status" class="text-center"></p>

                <!--顯示選擇農場按鈕-->
                <?php
                    application_get_farm();
                ?>
                <!--顯示選擇農場按鈕-->

                <!--顯示選擇職位選單-->
                <div id="choose_identity"></div>
                <!--顯示選擇職位選單-->
                <br/>

                <a href="../../../account.php" class="btn btn-info" role="button" aria-pressed="true" id="backbutton">返回</a>
                <button type="submit" class="btn btn-info" id="submit">申請</button>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                //當觸發選擇農場下拉式選單時
                $("#farmChoose1stChild").on('click', 'a', function(e){
                    //console.log($(this).text().substring(0,10));
                    
                    //將下拉式選單按鈕改為選擇的農場編號
                    $("#farmChoose:first-child").text($(this).text().substring(0,10));
                    $("#farmChoose:first-child").val($(this).text().substring(0,10));
                    

                    if($("#farmChoose:first-child").val()=='FARM000000')
                    {
                        document.getElementById("choose_identity").innerHTML = 
                        '<div class="dropdown">'+
                            '<button class="btn btn-secondary dropdown-toggle" type="button" id="identityChoose" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'+
                                '身份'+
                                '<span class="caret"></span>'+
                            '</button>'+
                            '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="identityChooseChild">'+
                                '<a class="dropdown-item" href="#" onclick="identityChoose('+'\'ADMIN\','+'\'管理員\''+');">ADMIN&nbsp管理員</a>'+
                                '<div class="dropdown-divider"></div>'+
                                '<a class="dropdown-item" href="#" onclick="identityChoose('+'\'MIS\','+'\'網路管理員\''+');">MIS&nbsp網路管理員</a>'+
                            '</div>'+
                        '</div>';
                    }
                    else
                    {
                        document.getElementById("choose_identity").innerHTML = 
                        '<div class="dropdown">'+
                            '<button class="btn btn-secondary dropdown-toggle" type="button" id="identityChoose" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'+
                                '身份'+
                                '<span class="caret"></span>'+
                            '</button>'+
                            '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="identityChooseChild">'+
                                '<a class="dropdown-item" href="#" onclick="identityChoose('+'\'FARMADMIN\','+'\'農場管理員\''+');">FARMADMIN&nbsp農場管理員</a>'+
                                '<div class="dropdown-divider"></div>'+
                                '<a class="dropdown-item" href="#" onclick="identityChoose('+'\'FARMSTAFF\','+'\'農場員工\''+');">FARMSTAFF&nbsp農場員工</a>'+
                            '</div>'+
                        '</div>';
                    }
                });
                
                //送出表單
                $("#submit").on('click',function(){
                    if($("#farmChoose:first-child").val()==""||$("#identityChoose:first-child").val()=="")
                    {
                        //欄位不可為空值
                        document.getElementById("edit_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>請選擇欲申請的農場及權限</div>';
                        return false;
                    }
                    $.ajax({
                        type:"POST",//使用表單的方式傳送，同form的method
                        url:"php/backend/application_identity.php",
                        data:
                        {
                            'farm':$("#farmChoose:first-child").val(),
                            'identity':$("#identityChoose:first-child").val()
                        },
                        dataType:'html'
                    }).done(function(data){
                        //console.log(data);
                        //ajax執行成功(if HTTP return 200 OK)
                        if(data=='identityApplicationSuccessfully')
                        {
                            //identity申請成功
                            document.getElementById("edit_status").innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>申請成功，請等待管理員審核</div>';
                            setTimeout('window.location.href = "account.php";',5000);
                        }
                        else if(data=='identityApplicationFailed')
                        {
                            //identity申請失敗
                            document.getElementById("edit_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Identity申請失敗</div>';
                        }
                        else if(data=='duplicatePrimaryKey')
                        {
                            //申請資料已存在
                            document.getElementById("edit_status").innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Identity申請資料已存在，請靜候管理員審核</div>';
                        }
                        else
                        {
                            console.log(data);
                        }
                    }).fail(function(jqXHR,textStatus,errorThrown){
                        console.log(jqXHR);console.log(textStatus);console.log(errorThrown);
                    });
                    return false;
                });
            });
            
            //當選擇欲申請的身分時，改變下拉式選單顯示的值
            function identityChoose(en,ch)
            {
                $("#identityChoose:first-child").text(en.concat(' ',ch));
                $("#identityChoose:first-child").val(en);
            }
        </script>
    </body>
</html>

<?php
endif;
?>