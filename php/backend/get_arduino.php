<?php
require_once '../connect.php';
@require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE)
{
    @header("Location: ../../index.php");
}
else
{
    $check = @get_admin_arduino($_POST['farm']);
    
    if($check)
    {
        echo $check;
    }
    else
    {
        echo "執行查詢失敗";
    }
}
?>