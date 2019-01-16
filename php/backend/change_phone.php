<?php
@require_once '../connect.php';
@require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    @header("Location: /index.php");
}
else:

$check = @change_phone($_POST['nuphone']);
if($check=='0')
{
    //舊密碼驗證失敗
    echo 'PhoneChangedFailed';
}
else if($check=='1')
{
    //變更密碼成功
    echo 'PhoneChangedSuccessfully';
}
else
{
    //例外
    echo 'Exception';
}

endif;
?>