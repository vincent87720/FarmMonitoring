<?php
@require_once '../connect.php';
@require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE)
{
    @header("Location: ../../index.php");
}
else
{
    $result = @delete_arduino($_POST['arduino_id']);
    
    if($result=='1')
    {
        //刪除權限成功
        echo 'deleteArduinoSuccess';
    }
    else if($result=='0')
    {
        //刪除權限失敗
        echo 'deleteArduinoFail';
    }
    else
    {
        //例外
        echo 'Exception';
    }
}
?>