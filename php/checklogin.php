<?php
session_start();
require_once 'connect.php';


$sql="SELECT `密碼` FROM `user` WHERE `帳號` LIKE "."'".$_POST["customer"]."'";
$result=mysqli_query($link,$sql);


if(mysqli_num_rows($result)!=0)
{
    //若mysqli_num_rows()的值不等於0，代表資料庫中已經存在該帳號，則將密碼指定給變數$db_password
    $db_username=$_POST['username'];
    $db_password=mysqli_fetch_array($result);
}
else
{
    header('Location: ../index.php?msg=帳號不存在，請核對您的帳號是否正確');
}

if(isset($_POST['username']) && isset($_POST['password']))
{
    if($_POST['username']==$db_username && $_POST['password']==$db_password)
    {
        $_SESSION['is_login']=true;
        header('Location: ../backend.php');
    }
    else
    {
        $_SESSION['is_login']=FALSE;
        header('Location: ../index.php?msg=登入失敗，請核對您的帳號或密碼是否正確');
    }
}
else
{
    header('Location: ../index.php?msg=請輸入使用者帳號及密碼');
}
?>