<?php
require_once 'connect.php';
require_once 'function.php';

$check = get_data($_POST['startText'],$_POST['endText']);
//$check = get_data('2018-11-11 00:00:00','2018-11-11 12:00:00');
if($check)
{
   echo $check;
}
else
{
    echo "執行查詢失敗";
}
?>