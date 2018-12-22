<?php
require_once '../connect.php';
require_once 'function.php';

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    header("Location: ../../index.php");
}
else:
    //print_r($_POST);
$check = get_all_data($_POST['farm'],$_POST['startText'],$_POST['endText']);
//$check = get_all_data('FARM000001',$_POST['startText'],$_POST['endText']);
//$check = get_all_data('FARM000001','2018-12-20 00:00:00','2018-12-23 12:00:00');
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