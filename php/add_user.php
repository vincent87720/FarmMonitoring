<?php
    //require_once 'connect.php';
$host='localhost';
$username='vincent';
$password='iamvincent';
$database='testdb';

//宣告一個Link變數，連結結果會帶入link中
$link=mysqli_connect($host,$username,$password,$database);
if($link)
{
    //若傳回True，代表已建立連線
    //設定編碼為UTF-8
    mysqli_query($link,"SET NAMES utf8");
}
else
{
    //連線失敗，mysql_connect_error()顯示錯誤訊息
    echo '無法連線mysql資料庫:<br/>'.mysql_connect_error();
}
    $id=$_POST['username'];
    $pw=$_POST['password'];
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    
    $sql="INSERT INTO `users` (`username`,`password`,`name`,`phone`,`email`) VALUES('$id','$pw','$name','$phone','$email')";
    mysqli_query($link,$sql);
    header('Location:../index.php');
?>