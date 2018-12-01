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
    $sql="SELECT `password`,`identity` FROM `users` WHERE `username` like '{$id}'";
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
                $_SESSION['login_user_identity'] = $row['identity'];
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

function get_data($farm,$typeOfData,$start,$end)
{

    $sql="SELECT `dateTime`,`sensorValue` 
          FROM `rawData`
          WHERE `LOCALPC#` = '{$farm}'
          AND `typeOfSensor` = '{$typeOfData}'
          AND `dateTime` >= '{$start}'
          AND `dateTime` <= '{$end}'";
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

//查詢全部農場
function get_farm()
{
    
    if($_SESSION['login_user_identity']=='admin')
    {
        //若身分為admin則顯示全部農場資料
        $sql="SELECT * FROM `localpc`";
    }
    else
    {
        //若身分不是admin則顯示登入者負責的農場資料
        $sql = "SELECT * FROM `localpc` WHERE `farmAdminId` LIKE '{$_SESSION['login_user_id']}'";
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
            <ul class="dropdown-menu" aria-labelledby="farmChoose" name="farmChoose">
EOT;
        $i = 1;
        while($row = mysqli_fetch_assoc($query))
        {
            echo <<< EOT
            <li>
                <a href="#" data-value=$i>
                <p>
EOT;
                echo $row['LOCALPC#'];
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
?>