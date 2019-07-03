<?php
@require_once '../connect.php';
@require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE)
{
    @header("Location: ../../index.php");
}
else
{
    $result = @delete_permission($_POST['manage_farm'],$_POST['manage_identity'],$_POST['manage_username']);
    
    if($result=='1')
    {
        //刪除權限成功
        echo 'deletePermissionSuccess';
    }
    else if($result=='0')
    {
        //刪除權限失敗
        echo 'deletePermissionFail';
    }
    else
    {
        //例外
        echo 'Exception';
    }
}
?>