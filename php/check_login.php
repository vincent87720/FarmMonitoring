<?php
@require_once 'connect.php';
@require_once 'function.php';

//檢查帳號密碼是否正確傳送
if(isset($_POST['id']) && isset($_POST['pw']))
{
    if(!empty($_POST['id']) && !empty($_POST['pw']))
    {
        $check = @verify_user($_POST['id'],$_POST['pw']);

        if($check=='1')
        {
            $_SESSION['is_login']=TRUE;
            echo 1;//success
        }
        else if($check=='0')
        {
            $_SESSION['is_login']=FALSE;
            echo 2;//帳號或密碼錯誤 IdOrPasswordFail
        }
        else if($check=='2')
        {
            $_SESSION['is_login']=FALSE;
            echo 3;//帳號不存在 UsernameNotExists
        }
        else
        {
            $_SESSION['is_login']=FALSE;
            echo "Exception";//例外
        }
    }
    else
    {
        $_SESSION['is_login']=FALSE;
        echo 4;//帳號或密碼為空值 NoIdAndPassword
    }
}
else
{
    $_SESSION['is_login']=FALSE;
    echo 5;//帳號密碼未正確傳送 TransferFailed
}
?>