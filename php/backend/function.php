<?php
@session_start();

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    header("Location: ../../index.php");
}
else:

function get_data($farm,$typeOfData,$start,$end)
{

    $sql="SELECT `dateTime`,`sensorValue` 
          FROM `rawdata`
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

function change_password($pw)
{
    
    require_once '../PasswordHash.php';
    $result=null;
    $pw = create_hash($pw);
    $sql="UPDATE `users` SET `password` = '{$pw}' WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = mysqli_query($_SESSION['link'],$sql);
    if ($query)
    {
        if(mysqli_num_rows($query)==1)
        {
            //變更密碼成功
            $result = '1';
        }
        else
        {
            //變更密碼失敗
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