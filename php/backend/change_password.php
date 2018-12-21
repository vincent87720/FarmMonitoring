<?php
require_once '../connect.php';
require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    header("Location: ../../index.php");
}
else:

$check = change_password($_POST['pw'],$_POST['nupw']);
if($check=='0')
{
    //舊密碼驗證失敗
    echo 'VarificationFailed';
}
else if($check=='1')
{
    //變更密碼成功
    echo 'PasswordChangedSuccessfully';
}
else if($check=='2')
{
    //變更密碼失敗
    echo 'PasswordChangedFailed';
}
else
{
    //例外
    echo 'Exception';
}

endif;
?>