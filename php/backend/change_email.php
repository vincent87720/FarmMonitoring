<?php
@require_once '../connect.php';
@require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    @header("Location: /index.php");
}
else:

$check = @change_email($_POST['nuemail']);
if($check=='0')
{
    //舊密碼驗證失敗
    echo 'EmailChangedFailed';
}
else if($check=='1')
{
    //變更密碼成功
    echo 'EmailChangedSuccessfully';
}
else
{
    //例外
    echo 'Exception';
}

endif;
?>