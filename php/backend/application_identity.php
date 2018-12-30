<?php
require_once '../connect.php';
require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE)
{
    header("Location: ../../index.php");
}
else
{
    $check = application_identity($_POST['farm'],$_POST['identity']);
    if($check=='0')
    {
        //identity申請失敗
        echo 'identityApplicationFailed';
    }
    else if($check=='1')
    {
        //identity申請成功
        echo 'identityApplicationSuccessfully';
    }
    else if($check=='1062')
    {
        //申請資料已存在
        echo 'duplicatePrimaryKey';
    }
    else
    {
        //例外
        echo 'Exception';
    }
}
?>