<?php
require_once '../connect.php';
require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    header("Location: ../../index.php");
}
else:
    
$check = get_data($_POST['farm'],$_POST['typeOfData'],$_POST['startText'],$_POST['endText']);
//$check = get_data('2018-11-11 00:00:00','2018-11-11 12:00:00');
if($check)
{
   echo $check;
}
else
{
    echo "執行查詢失敗";
}

endif;
?>