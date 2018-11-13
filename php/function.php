<?php
require 'connect.php';
function check_has_username($input)
{

    $result=null;
    $sql = "SELECT * FROM `users` WHERE `username` LIKE '{$input}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    
    if($query)
    {
        //若SQL成功執行
        if(mysqli_num_rows($query)>=1)
        {
            //有一筆以上相同的資料
            $result=true;
        }
    }
    else
    {
        //若SQL執行失敗
        echo "{$sql}語法請求失敗:<br/>".mysqli_error($_SESSION['link']);
    }
    return $result;
}
?>