<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) .'/php/PasswordHash.php');
@session_start();

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    header("Location: ../../index.php");
}
else:

//取得單一種類感測器資料
function get_data($farm,$typeOfData,$start,$end)
{

    $sql="SELECT d.`dateTime`,d.`data` 
          FROM (`data` d INNER JOIN `arduino` a ON d.`arduino#` = a.`arduino#`) INNER JOIN `farm` f ON a.`farm#` = f.`farm#`
          WHERE f.`farm#` = '{$farm}'
          AND d.`dataType` = '{$typeOfData}'
          AND d.`dateTime` >= '{$start}'
          AND d.`dateTime` <= '{$end}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    $json_array = array();
    
    if ($query)
    {
        while($row = mysqli_fetch_assoc($query))
        {
            $json_array[] = $row;
        }
        
        return json_encode($json_array);
    }
    else
    {
        echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
}

//取得所有種類感測器資料
function get_all_data($farm,$start,$end)
{
    $sql="SELECT d.`dateTime`,d.`data`,d.`dataType`
          FROM (`data` d INNER JOIN `arduino` a ON d.`arduino#` = a.`arduino#`) INNER JOIN `farm` f ON a.`farm#` = f.`farm#`
          WHERE f.`farm#` = '{$farm}'
          AND d.`dateTime` >= '{$start}'
          AND d.`dateTime` <= '{$end}'";
    $test="SELECT t1.`dateTime`,t1.`typeOfSensor` as '溫度',t1.`sensorValue` as t1s,t2.`typeOfSensor` as t2t,t2.`sensorValue` as t2s
          FROM `rawdata` t1 JOIN `rawdata` t2 ON t1.`dateTime`=t2.`dateTime` AND t1.`typeOfSensor`='溫度' AND t2.`typeOfSensor`='濕度'
          WHERE t1.`LOCALPC#` = '{$farm}'
          AND t1.`dateTime` >= '{$start}'
          AND t1.`dateTime` <= '{$end}'
          AND t2.`LOCALPC#` = '{$farm}'
          AND t2.`dateTime` >= '{$start}'
          AND t2.`dateTime` <= '{$end}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    $json_array = array();
    
    if ($query)
    {
        while($row = mysqli_fetch_assoc($query))
        {
            $json_array[] = $row;
        }
        
        return json_encode($json_array);
    }
    else
    {
        echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
}

//查詢該使用者管理的全部農場
function get_farm()
{
    
    if($_SESSION['login_user_identity']=='admin')
    {
        //若身分為admin則顯示全部農場資料
        $sql="SELECT * FROM `farm`";
    }
    else
    {
        //若身分不是admin則顯示登入者負責的農場資料
        $sql = "SELECT * 
                FROM `farm` f INNER JOIN `manage` m ON f.`farm#` = m.`farm#`
                WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    }
    
    $query = mysqli_query($_SESSION['link'],$sql);
    if ($query)
    {
        echo <<< EOT
        <div class="dropdown">
            <button class="btn btn-warning dropdown-toggle" type="button" id="farmChoose" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                農場
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="farmChoose" id="farmChoose1stChild">
EOT;
        $i = 1;
        while($row = mysqli_fetch_assoc($query))
        {
            echo <<< EOT
            <li>
                <a href="#" data-value=$i>
                <p>
EOT;
                echo $row['farm#'];   
            echo <<< EOT
                </p>
                <h4> 
                <span class="glyphicon glyphicon-leaf"></span> 
                <span>
EOT;
            echo $row['positionDescription'];
            echo <<< EOT
            </span>  
                </h4>
                </a>
            </li>
EOT;
            //若不是最後一行，要輸出分隔線
            if($i!=mysqli_num_rows($query))
            {
                echo '<li class="divider"></li>';
            }
            $i++;
        }
        echo <<< EOT
            </ul>
        </div>
        <br />
EOT;
    }
    else
    {
        echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
}

function get_user_information()
{
    $sql="SELECT * FROM `users` WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    $row = mysqli_fetch_assoc($query);
    if ($query)
    {
        $_SESSION['login_user_phone']=$row["phone"];
        $_SESSION['login_user_name']=$row["name"];
        $_SESSION['login_user_email']=$row["email"];
    }
    else
    {
        echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
}

function change_password($pw,$nupw)
{
    //比對目前密碼是否與資料庫的使用者密碼相同
    $result=null;
    $sql="SELECT `password` FROM `users` WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    $row = mysqli_fetch_array($query);
    if ($query)
    {
        if(validate_password($pw,$row['password']))
        {
            //驗證成功，變更密碼
            $nupw = create_hash($nupw);
            $sql="UPDATE `users` SET `password` = '{$nupw}' WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
            $query = mysqli_query($_SESSION['link'],$sql);
            if ($query)
            {
                if(mysqli_affected_rows($_SESSION['link'])==1)
                {
                    //變更密碼成功
                    $result = '1';
                }
                else
                {
                    //變更密碼失敗
                    $result = '2';
                }
            }
            else
            {
                echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
            }
        }
        else
        {
            //驗證失敗
            $result = '0';
        }
    }
    else
    {
        echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }
    return $result;
}

function change_phone($nuphone)
{
    $result = null;
    $sql = "UPDATE `users` SET `phone` = '{$nuphone}' WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        if(mysqli_affected_rows($_SESSION['link'])==1)
        {
            //變更電話號碼成功
            $result = '1';
        }
        else
        {
            //變更電話號碼成功
            $result = '0';
        }
    }
    else
    {
        echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }
    return $result;
}

function change_name($nuname)
{
    $result = null;
    $sql = "UPDATE `users` SET `name` = '{$nuname}' WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        if(mysqli_affected_rows($_SESSION['link'])==1)
        {
            //姓名變更成功
            $result = '1';
        }
        else
        {
            //姓名變更成功
            $result = '0';
        }
    }
    else
    {
        echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }
    return $result;
}

function change_email($nuemail)
{
    $result = null;
    $sql = "UPDATE `users` SET `email` = '{$nuemail}' WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        if(mysqli_affected_rows($_SESSION['link'])==1)
        {
            //Email變更成功
            $result = '1';
        }
        else
        {
            //Email變更成功
            $result = '0';
        }
    }
    else
    {
        echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }
    return $result;
}
endif;
?>