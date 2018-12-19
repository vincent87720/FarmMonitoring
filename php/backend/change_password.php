<?php
require_once '../connect.php';
require_once 'function.php';

$changepw = change_password($_POST['pw'],$_POST['nupw']);
if($changepw=='1')
{
    echo 1;//變更密碼成功
}
else
{
    echo 0;//變更密碼失敗
}
?>