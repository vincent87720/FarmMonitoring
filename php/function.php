<?php
@session_start();
function check_has_username($input)
{

    $result=null;
    $sql = "SELECT * FROM `users` WHERE `username` LIKE '{$input}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    
    if($query)
    {
        //若SQL成功執行
        if(mysqli_num_rows($query)>=1)
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
        echo "check_has_username()語法請求失敗:".mysqli_error($_SESSION['link']);
    }
    return $result;
}

function add_user($id,$pw,$name,$phone,$email)
{

    $result=null;
    $pw = md5($pw);
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
        echo "add_user()語法請求失敗:".mysqli_error($_SESSION['link']);
    }
    return $result;
}

function verify_user($id,$pw)
{

    $result=null;
    $pw = md5($pw);
    $sql="SELECT `password` FROM `users` WHERE `username` like '{$id}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    $row = mysqli_fetch_array($query);
    
    //若mysqli_num_rows()的值不等於0，代表資料庫中已經存在該帳號，則將密碼指定給變數$db_password
    if ($query)
    {
        if(mysqli_num_rows($query)==1)
        {
            if(stristr($pw,$row['password']))
            {
                $_SESSION['is_login'] = TRUE;
                $_SESSION['login_user_id'] = $id;
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
    }
    else
    {
        echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }
    return $result;
}

function get_data($start,$end)
{
    $datetime=null;
    $data=null;
    $sql="SELECT `DateTime`,`Sensor value` FROM `data` WHERE `Datetime` >= '{$start}' AND `Datetime` <= '{$end}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    $row = mysqli_fetch_array($query);

    $i=0;
    while( $row = mysqli_fetch_array($query))
    {
        if($i==0)//第一圈，要先輸出一個數字
        {
            $data = $row['Sensor value'];
            $datetime = $row['DateTime'];
        }
        else
        {
            $data = $data.','.$row['Sensor value'];
            $datetime = $datetime.','.$row['DateTime'];
        }
        $i++;
    }
    $ary=array("datetime"=>$datetime,"data"=>$data);
    return $ary;

}
?>