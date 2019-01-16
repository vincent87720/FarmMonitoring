<?php
@require_once '../connect.php';
@require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE)
{
    @header("Location: /index.php");
}
else
{
    $check = @application_delete($_POST['username'],$_POST['farm'],$_POST['identity'],$_POST['dateTime']);
    if($check=='1')
    {
        //申請資料刪除成功
        echo 'applicationDataDeleteSuccess';
    }
    else if($check=='0')
    {
        //申請資料刪除失敗
        echo 'applicationDataDeleteFail';
    }
    else
    {
        //例外
        echo 'Exception';
    }
}
?>