<?php
    require_once 'connect.php';

    $id=$_POST['username'];
    $pw=$_POST['password'];
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    
    $sql="INSERT INTO `users` (`username`,`password`,`name`,`phone`,`email`) VALUES('$id','$pw','$name','$phone','$email')";
    mysqli_query($link,$sql);
    header('Location:../index.php');
?>