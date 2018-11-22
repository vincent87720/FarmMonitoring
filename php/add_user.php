<?php
    require_once 'connect.php';
    require_once 'function.php';

    $check = add_user($_POST['username'],$_POST['password'],$_POST['name'],$_POST['phone'],$_POST['email']);
    if($check)
    {
        //新增資料成功
        
        //檢查資料庫內是否已存在該資料
        if(check_has_username($_POST['username']))
        {
            //有相同帳號
            echo 1;
        }
        else
        {
            //無相同帳號
            echo 0;
        }
    }
    else
    {
        //新增資料失敗
        echo 2;
    }
    
    
    
    
    
?>