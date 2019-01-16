<?php
@require_once 'connect.php';
@require_once 'function.php';
//print_r($_POST['n']);
$check=@check_has_username($_POST['n']);

if($check)
{
    //有相同帳號
    echo 1;
}
else
{
    //無相同帳號
    echo 0;
}
?>  