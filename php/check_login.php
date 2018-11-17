<?php
require_once 'connect.php';

//檢查帳號密碼是否正確傳送
if(isset($_POST['id']) && isset($_POST['password']))
{
    if(!empty($_POST['id']) && !empty($_POST['password']))
    {
        $input_username = $_POST['id'];
        $input_password = $_POST['password'];

        $sql="SELECT `password` FROM `users` WHERE `username` like '$input_username'";
        $result=mysqli_query($_SESSION['link'],$sql);
        $row = mysqli_fetch_array($result);

        //若mysqli_num_rows()的值不等於0，代表資料庫中已經存在該帳號，則將密碼指定給變數$db_password
        if(mysqli_num_rows($result)!=0)
        {
            $db_username=$input_username;
            $db_password=$row['password'];

            if($_POST['id']==$db_username && $_POST['password']==$db_password)
            {
                $_SESSION['is_login']=TRUE;
                header('Location: ../backend.php');
            }
            else
            {
                $_SESSION['is_login']=FALSE;
                header('Location: ../index.php?msg=IdOrPasswordFail');//帳號或密碼錯誤
            }
        }
        else
        {
            header('Location: ../index.php?msg=UsernameNotExists');//帳號不存在
        }
    }
    else
    {
        header('Location: ../index.php?msg=NoIdAndPassword');//帳號或密碼為空值
    }
}
else
{
    header('Location: ../index.php?msg=TransferFailed');//帳號密碼未正確傳送
}
mysqli_free_result($result);
 
mysqli_close($_SESSION['link']);
?>