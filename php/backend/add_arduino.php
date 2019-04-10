<?php
@require_once '../connect.php';
@require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    @header("Location: /index.php");
}
else:

$check = @add_arduino($_POST['arduino'],$_POST['positionDescription'],$_POST['farm#']);
if($check=='0')
{
    //新增Arduino失敗
    echo 'ArduinoAddFailed';
}
else if($check=='1')
{
    //新增Arduino成功
    echo 'ArduinoAddedSuccessfully';
}
else
{
    //例外
    echo 'Exception';
}

endif;
?>