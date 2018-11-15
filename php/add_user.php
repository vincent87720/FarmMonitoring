<?php
    require_once 'connect.php';
    require_once 'function.php';

    $id=$_POST['username'];
    $pw=$_POST['password'];
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];

    //新增資料到資料庫
    $sql="INSERT INTO `users` (`username`,`password`,`name`,`phone`,`email`,`identity`) VALUES('$id','$pw','$name','$phone','$email','default')";
    mysqli_query($_SESSION['link'],$sql);


    //檢查資料庫內是否已存在該資料
    if(check_has_username($id))
    {
        //若回傳為TRUE代表資料已被新增，跳轉燈入頁
        sleep(5);
        header('Location:../index.php');
    }
    else
    {
        //若回傳為FALSE代表資料未被新增，返回上一頁
        header('Location:.getenv("HTTP_REFERER")');
    }
    
    
?>