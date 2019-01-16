<?php
@require_once 'PasswordHash.php';
@session_start();
function check_has_username($input)
{

    $result=null;
    $sql = "SELECT * FROM `users` WHERE `username` LIKE '{$input}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    
    if($query)
    {
        //若SQL成功執行
        if(@mysqli_num_rows($query)>=1)
        {
            //有一筆以上相同的資料
            $result=true;
        }
        else
        {
            //無相同帳號
            $result=false;
        }
    }
    else
    {
        //若SQL執行失敗
        //echo "check_has_username()語法請求失敗:".mysqli_error($_SESSION['link']);
        $result=false;
    }
    return $result;
}

function add_user($id,$pw,$name,$phone,$email)
{
    $result=null;
    $pw = create_hash($pw);
    $sql="INSERT INTO `users` (`username`,`password`,`name`,`phone`,`email`,`identity`) VALUES('{$id}','{$pw}','{$name}','{$phone}','{$email}','default')";
    $query = mysqli_query($_SESSION['link'],$sql);
    
    if($query)
    {
        //若更動的資料等於一筆
        if(mysqli_affected_rows($_SESSION['link'])==1)
        {
            //新增資料成功
            $result=true;
        }
        else
        {
            //新增資料失敗
            $result=false;
        }
    }
    else
    {
        //若SQL執行失敗
        //echo "add_user()語法請求失敗:".mysqli_error($_SESSION['link']);
        $result=false;
    }
    return $result;
}

function verify_user($id,$pw)
{
    $checkhasuser = @check_has_username($id);
    $result=null;

    //SQL參數化查詢---較能防止SQL injection攻擊
    $sql="SELECT `password`,`identity`,`name` FROM `users` WHERE `username` = ?";

    $stmt = $_SESSION['link']->stmt_init();
    if ($stmt->prepare($sql)) 
    {
        //綁定變數到參數
        $stmt->bind_param("s",$id);
        
        //執行SQL指令
        $stmt->execute();


        if($checkhasuser)
        {
            //綁定查詢結果到變數
            $stmt->bind_result($loginUserPassword,$loginUserIdentity,$loginUserName);
            
            //把取得的數值fetch進去
            $stmt->fetch();
            if(validate_password($pw,$loginUserPassword))
            {
                $_SESSION['is_login'] = TRUE;
                $_SESSION['login_user_id'] = $id;
                $_SESSION['login_user_name'] = $loginUserName;
                $_SESSION['login_user_identity'] = $loginUserIdentity;
                $result = '1';//VerifySuccess
            }
            else
            {
                $result = '0';//VerifyFailed
            }
        }
        else
        {
            $result = '2';//UsernameNotExists
        }

        ////Debug用--顯示查詢到的$password,$identity和$name
        // while($stmt->fetch()) 
        // {
        //     printf ("%s : %s : %s\n",$password,$identity,$name);
        // }
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        $result = '0';//VerifyFailed
    }
    $stmt->close();


    //變數帶入查詢法---較不安全，可能引發SQL injection
    // $sql="SELECT `password`,`identity`,`name` FROM `users` WHERE `username` LIKE '{$id}'";
    // $query = mysqli_query($_SESSION['link'],$sql);
    // $row = mysqli_fetch_array($query);
    
    // //若mysqli_num_rows()的值不等於0，代表資料庫中已經存在該帳號，則將密碼指定給變數$db_password
    // if ($query)
    // {
    //     if(mysqli_num_rows($query)==1)
    //     {
    //         if(validate_password($pw,$row['password']))
    //         {
    //             $_SESSION['is_login'] = TRUE;
    //             $_SESSION['login_user_id'] = $id;
    //             $_SESSION['login_user_name'] = $row['name'];
    //             $_SESSION['login_user_identity'] = $row['identity'];
    //             $result = '1';//VerifySuccess
    //         }
    //         else
    //         {
    //             $result = '0';//VerifyFailed
    //         }
    //     }
    //     else
    //     {
    //         $result = '2';//UsernameNotExists
    //     }
    // }
    // else
    // {
    //     echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    // }

    //改變SESSION ID的值
    session_regenerate_id();
    return $result;
}
?>