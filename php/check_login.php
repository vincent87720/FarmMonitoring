<?php
require_once 'connect.php';
require_once 'function.php';

//檢查帳號密碼是否正確傳送
if(isset($_POST['id']) && isset($_POST['pw']))
{
    if(!empty($_POST['id']) && !empty($_POST['pw']))
    {
        $check = verify_user($_POST['id'],$_POST['pw']);

        if($check==1)
        {
            $_SESSION['is_login']=TRUE;
            echo "success";
        }
        else if($check==0)
        {
            $_SESSION['is_login']=FALSE;
            echo "IdOrPasswordFail";//帳號或密碼錯誤
        }
        else if($check==2)
        {
            $_SESSION['is_login']=FALSE;
            echo "UsernameNotExists";//帳號不存在
        }
        else
        {
            $_SESSION['is_login']=FALSE;
            echo $check;//例外
        }
    }
    else
    {
        $_SESSION['is_login']=FALSE;
        echo "NoIdAndPassword";//帳號或密碼為空值
    }
}
else
{
    $_SESSION['is_login']=FALSE;
    echo "TransferFailed";//帳號密碼未正確傳送
}
// mysqli_free_result($result);
 
// mysqli_close($_SESSION['link']);
?>