<?php
    require_once 'connect.php';
    $input=$_POST["u"];
    $result = false;
    $sql = "SELECT * FROM `USER` WHERE `username` = '".$_POST['u']."'";
    $query = mysqli_query($link,$sql);
    
    //若sql執行成功
    if($query)
    {
        //若抓到一筆資料
        if(mysqli_num_rows($query)==1)
        {
            $result=true;
        }
    }
    else//若執行失敗
    {
        echo "{$sql}語法請求失敗:<br/>".mysqli_error($_SESSION['link']);
    }

    if($result)
    {
        echo 'yes';
    }
    else
    {
        echo 'no';
    }
?>  