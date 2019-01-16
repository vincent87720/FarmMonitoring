<?php
@require_once '../connect.php';
@require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE)
{
    @header("Location: /index.php");
}
else
{
    $check = @application_permit($_POST['username'],$_POST['farm'],$_POST['identity'],$_POST['dateTime']);
    if($check=='1')
    {
        //新增權限成功
        echo 'success';
    }
    else if($check=='2')
    {
        //新增權限成功，申請資料尚未刪除
        echo 'applicationDataNotDelete';
    }
    else if($check=='1062')
    {
        //語法執行失敗，權限已存在
        echo 'duplicatePrimaryKey';
    }
    else
    {
        //例外
        echo 'Exception';
    }
}
?>