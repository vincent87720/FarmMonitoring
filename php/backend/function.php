<?php
@require_once (realpath($_SERVER["DOCUMENT_ROOT"]) .'/php/PasswordHash.php');
@session_start();

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    @header("Location: /index.php");
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
    $query = @mysqli_query($_SESSION['link'],$sql);
    $json_array = @array();
    
    if ($query)
    {
        while($row = @mysqli_fetch_assoc($query))
        {
            $json_array[] = $row;
        }
        
        return @json_encode($json_array);
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
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
    $query = @mysqli_query($_SESSION['link'],$sql);
    $json_array = @array();
    
    if ($query)
    {
        while($row = @mysqli_fetch_assoc($query))
        {
            $json_array[] = $row;
        }
        
        return @json_encode($json_array);
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
}

//查詢該使用者管理的全部農場
function get_farm()
{
    if($_SESSION['login_user_identity']=='ADMIN'||$_SESSION['login_user_identity']=='MIS')
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
    
    $query = @mysqli_query($_SESSION['link'],$sql);
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
        while($row = @mysqli_fetch_assoc($query))
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
            if($i!=@mysqli_num_rows($query))
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
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
}

//申請農場功能選擇農場的下拉式選單
function application_get_farm()
{
    $sql="SELECT * FROM `farm`";
    
    $query = @mysqli_query($_SESSION['link'],$sql);
    if ($query)
    {
        echo <<< EOT
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="farmChoose" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                農場
                <span class="caret"></span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="farmChoose1stChild">
            <a class="dropdown-item" href="#">FARM000000 總公司</a>
            <div class="dropdown-divider"></div>
EOT;
        $i = 1;
        while($row = @mysqli_fetch_assoc($query))
        {
            echo '<a class="dropdown-item" href="#">';
            echo $row['farm#'];
            echo ' ';
            echo $row['positionDescription'];
            echo '</a>';
            if($i!=@mysqli_num_rows($query))
            {
                echo '<div class="dropdown-divider"></div>';
            }
            $i++;
        }
        echo <<< EOT
            </div>
        </div>
        <br />
EOT;
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
}

//列出所有權限申請清單
function get_application_list()
{
    $sql="SELECT * FROM `application`";
    $query = @mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        echo <<< EOT
        <div id="carouselControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
EOT;
        $i=1;
        while($row = @mysqli_fetch_assoc($query))
        {
            if($i==1)
            {
                echo '<div class="carousel-item active">';
            }
            else
            {
                echo '<div class="carousel-item">';
            }
            echo '<div class="permission-list-group">';
            
            echo '<ul class="list-group permission-list-group">';
            echo '<li class="list-group-item list-group-item-action borderless" id="application_username">';
            echo '&nbsp申請人&nbsp　　&nbsp';
            echo '<strong>';
            echo $row['username'];
            echo '</strong></li>';

            echo '<li class="list-group-item list-group-item-action borderless" id="application_farm">';
            echo '申請農場　　&nbsp';
            echo '<strong>';
            echo $row['farm#'];
            echo '</strong></li>';

            echo '<li class="list-group-item list-group-item-action borderless" id="application_identity">';
            echo '申請權限　　&nbsp';
            echo '<strong>';
            echo $row['identity'];
            echo '</strong></li>';

            echo '<li class="list-group-item list-group-item-action borderless" id="application_dateTime">';
            echo '申請時間　　&nbsp';
            echo '<strong>';
            echo $row['applicationDateTime'];
            echo '</strong></li>';

            echo '</ul>';
            echo '</div>';
            echo '</div>';
            $i++;
        }

        echo <<< EOT
            </div>
            <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>                                           
        </div>
EOT;
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
    
}

//權限申請
function application_identity($farm,$identity)
{
    $result = null;
    //若是FARM000000則代表總公司，不須在前面identity前面加上農場編號
    if($farm!="FARM000000")
    {
        $identity = $farm.' '.$identity;
    }
    $dateTime = @date ("Y-m-d H:i:s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
    $sql = "INSERT INTO `application` (`username`,`farm#`,`applicationDateTime`,`identity`) VALUES ('{$_SESSION['login_user_id']}','{$farm}','{$dateTime}','{$identity}')";
    $query = @mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        if(@mysqli_affected_rows($_SESSION['link'])==1)
        {
            //identity申請成功
            $result = '1';
        }
        else
        {
            //identity申請失敗
            $result = '0';
        }
    }
    else
    {
        if(@mysqli_connect_errno()=='#1062')
        {
            //語法執行失敗，權限已存在
            $result = '1062';
        }
        else
        {
            $result = '0';
            //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        }
    }
    return $result;
}

//允許權限申請，賦予權限並刪除權限申請清單中的資料
function application_permit($username,$farm,$identity,$dateTime)
{
    $result = null;
    $sql1 = "UPDATE `users` SET `identity` = '{$identity}' WHERE `username` = '{$username}';";
    $query1 = @mysqli_query($_SESSION['link'],$sql1);
    
    if($query1)
    {
        //users.identity更新成功
        if($farm=="FARM000000")
        {
            //申請總公司的權限不用將可管理農場加入manage資料表
            if(@application_delete($username,$farm,$identity,$dateTime)==1)
            {
                //新增權限成功
                $result = '1';
            }
            else
            {
                //新增權限成功，申請資料尚未刪除
                $result = '2';
            }
        }
        else
        {
            $sql2 = "INSERT INTO `manage`(`username`, `farm#`) VALUES ('{$username}','{$farm}');";
            $query2 = @mysqli_query($_SESSION['link'],$sql2);
            if($query2)
            {
                //成功將資料新增到manage資料表
                if(@application_delete($username,$farm,$identity,$dateTime)==1)
                {
                    //新增權限成功
                    $result = '1';
                }
                else
                {
                    //新增權限成功，申請資料尚未刪除
                    $result = '2';
                }
            }
            else
            {
                if(@mysqli_connect_errno()=='#1062')
                {
                    //語法執行失敗，權限已存在
                    $result = '1062';
                }
                else
                {
                    $result = '0';
                    //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
                }
            }
        } 
    }
    else
    {
        //users.identity更新失敗
        $result = '0';
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }
    return $result;
}

//刪除權限申請清單中的資料
function application_delete($username,$farm,$identity,$dateTime)
{
    $result = null;
    $sql = "DELETE FROM `application` WHERE `username` = '{$username}' AND `farm#` = '{$farm}' AND `identity` = '{$identity}'AND `applicationDateTime` = '{$dateTime}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        //刪除資料成功
        $result = '1';
    }
    else
    {
        $result = '0';
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }
    return $result;
}

function get_user_information()
{
    $sql="SELECT * FROM `users` WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    $row = @mysqli_fetch_assoc($query);
    if ($query)
    {
        $_SESSION['login_user_phone']=$row["phone"];
        $_SESSION['login_user_name']=$row["name"];
        $_SESSION['login_user_email']=$row["email"];
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
}

function change_password($pw,$nupw)
{
    //比對目前密碼是否與資料庫的使用者密碼相同
    $result=null;
    $sql="SELECT `password` FROM `users` WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    $row = @mysqli_fetch_array($query);
    if ($query)
    {
        if(@validate_password($pw,$row['password']))
        {
            //驗證成功，變更密碼
            $nupw = @create_hash($nupw);
            $sql="UPDATE `users` SET `password` = '{$nupw}' WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
            $query = @mysqli_query($_SESSION['link'],$sql);
            if ($query)
            {
                if(@mysqli_affected_rows($_SESSION['link'])==1)
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
                //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
                $result = 'Exception';
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
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        $result = 'Exception';
    }
    return $result;
}

function change_phone($nuphone)
{
    $result = null;
    $sql = "UPDATE `users` SET `phone` = '{$nuphone}' WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        if(@mysqli_affected_rows($_SESSION['link'])==1)
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
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        $result = 'Exception';
    }
    return $result;
}

function change_name($nuname)
{
    $result = null;
    $sql = "UPDATE `users` SET `name` = '{$nuname}' WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        if(@mysqli_affected_rows($_SESSION['link'])==1)
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
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        $result = 'Exception';
    }
    return $result;
}

function change_email($nuemail)
{
    $result = null;
    $sql = "UPDATE `users` SET `email` = '{$nuemail}' WHERE `username` LIKE '{$_SESSION['login_user_id']}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        if(@mysqli_affected_rows($_SESSION['link'])==1)
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
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        $result = 'Exception';
    }
    return $result;
}

endif;
?>