<?php
require_once (realpath($_SERVER["DOCUMENT_ROOT"]) .'/php/PasswordHash.php');
@session_start();

if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
{
    @header("Location: /index.php");
}
else:

//////////////////////////////function.php//////////////////////////////

//查詢該使用者管理的全部農場
//monitor_get_farm(),account_get_farm()
function get_farm()
{
    $isFarmZero = 0;
    foreach($_SESSION['login_user_identity'] as $userIdentity)
    {
        if($userIdentity[0] == "FARM000000")
        {
            $isFarmZero=1;
            break;
        }
    }
    if($isFarmZero == 1)
    {
        //若身分為admin則顯示全部農場資料
        $sql="SELECT * FROM `farm`";
    }
    else
    {
        //若身分不是admin則顯示登入者負責的農場資料
        $sql = "SELECT * 
                FROM `farm` f INNER JOIN `manage` m ON f.`farm#` = m.`farm#`
                WHERE `username` LIKE '{$_SESSION['login_user_id']}' AND `auditStatus` = 1";
    }
    $query = @mysqli_query($_SESSION['link'],$sql);
    if ($query)
    {
        $farm_array = @array();
        while($row = @mysqli_fetch_assoc($query))
        {
            @array_push($farm_array,$row);
        }
        return $farm_array;
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return "";
    }
}

//查詢登入者可管理的所有權限
//get_manage_list()
function get_manage()
{
    $isFarmZero = 0;
    foreach($_SESSION['login_user_identity'] as $userIdentity)
    {
        if($userIdentity[0] == "FARM000000")
        {
            $isFarmZero=1;
            break;
        }
    }
    if($isFarmZero == 1)
    {
        $sql="SELECT DISTINCT m.`farm#`,m.`identity`,m.`username`,u.`name`,m.`applicationDateTime`,m.`auditDateTime`,m.`auditor`
              FROM `manage` m INNER JOIN `users` u ON m.`username` = u.`username` 
              WHERE `auditStatus` = 1
              ORDER BY m.`farm#`, m.`identity`, m.`username`";
    }
    else
    {
        $sql="SELECT DISTINCT b.`farm#`,b.`identity`,b.`username`,u.`name`,b.`applicationDateTime`,b.`auditDateTime`,b.`auditor`
              FROM (`manage` a INNER JOIN `manage` b ON a.`farm#` = b.`farm#`) INNER JOIN `users` u ON b.`username` = u.username
              WHERE a.`username` = '{$_SESSION['login_user_id']}' AND a.`auditStatus` = 1 AND b.`auditStatus` = 1 AND (a.`identity` = 'ADMIN' OR a.`identity` = 'MIS')
              ORDER BY b.`farm#`, b.`identity`, b.`username`";
    }

    $query = @mysqli_query($_SESSION['link'],$sql);
    $manage_array = array();
    if($query)
    {
        while($row = @mysqli_fetch_assoc($query))
        {
            $row_array = array();
            @array_push($row_array,$row['farm#'],$row['identity'],$row['username'],$row['name'],$row['applicationDateTime'],$row['auditDateTime'],$row['auditor']);
            @array_push($manage_array,$row_array);
        }
        return $manage_array;
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
}

//////////////////////////////monitor.php//////////////////////////////

//取得單一種類感測器資料
//get_monitoring_data.php
function get_data($farm,$typeOfData,$start,$end)
{
    $json_array = @array();

    //查詢該農場有哪些ARDUINO
    $sql="SELECT a.`arduino#`,a.`positionDescription`
          FROM `arduino` a
          WHERE a.`farm#` = '{$farm}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    $arduino_array = @array();
    if ($query)
    {
        while($row = @mysqli_fetch_assoc($query))
        {
            $arduino_array[] = $row;
        }
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
    
    //查詢資料
    $sql="SELECT d.`dateTime`,d.`data`,d.`arduino#`
          FROM (`data` d INNER JOIN `arduino` a ON d.`arduino#` = a.`arduino#`) INNER JOIN `farm` f ON a.`farm#` = f.`farm#`
          WHERE f.`farm#` = '{$farm}'
          AND d.`dataType` = '{$typeOfData}'
          AND d.`dateTime` >= '{$start}'
          AND d.`dateTime` <= '{$end}'
          ORDER BY d.`dateTime` ASC";
    $query = @mysqli_query($_SESSION['link'],$sql);
    $data_array = array();
    if ($query)
    {
        while($row = @mysqli_fetch_assoc($query))
        {
            $data_array[] = $row;
        }
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }

    $json_array = @array("arduino" => $arduino_array,"data" => $data_array);
    return @json_encode($json_array);
}

//查詢該使用者管理的所有農場
//monitor.php
function monitor_get_farm()
{
    $result = @get_farm();
    $html = "";
    if($result!="")
    {
        $html.='<div class="dropdown" style="display:inline;">
                    <button class="btn btn-warning dropdown-toggle" type="button" id="farmChoose" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        農場
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="farmChoose" id="farmChoose1stChild">';
        
        $i = 0; 
        foreach($result as $row)
        {
            //輸出FARM000000以外的農場
            if($row["farm#"] != "FARM000000")
            {
                $html.='<li>
                            <a>
                                <p>'.$row["farm#"].'</p>
                                <h4> 
                                    <span class="glyphicon glyphicon-leaf"></span> 
                                    <span>'.$row['positionDescription'].'</span>
                                </h4>
                            </a>
                        </li>';
                //若不是最後一行且數量不等於一個，要輸出分隔線
                if($i!=count($result)-2 && count($result)-1 != 0)
                {
                    $html.='<li class="divider"></li>';
                }
                $i++;
            }
        }
        $html.='</ul>
                </div>';
        echo $html;
    }
}

//////////////////////////////account.php//////////////////////////////
//////////////////////////////AccountBlock//////////////////////////////

//取得使用者資訊
//account.php
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

//更改使用者密碼
//change_password.php
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

//更改使用者電話
//change_phone.php
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

//更改使用者名稱
//change_name.php
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

//更改使用者信箱
//change_email.php
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

//申請農場功能選擇農場的下拉式選單，取得所有農場
//account.php
function application_get_farm()
{
    $sql="SELECT * FROM `farm`";
    $html = "";
    $query = @mysqli_query($_SESSION['link'],$sql);
    if ($query)
    {
        $html.='<div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="farmChoose" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        農場
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="farmChoose1stChild">';
        $i = 1;
        while($row = @mysqli_fetch_assoc($query))
        {
            $html.='<a class="dropdown-item" href="#">'.$row['farm#'].' '.$row['positionDescription'].'</a>';
            if($i!=@mysqli_num_rows($query))
            {
                $html.='<div class="dropdown-divider"></div>';
            }
            
            $i++;
        }
            $html.='</div>
                </div>
                <br />';
    echo $html;
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
}

//權限申請
//application_identity.php
function application_identity($farm,$identity)
{
    $result = null;

    //申請日期時間
    $dateTime = @date ("Y-m-d H:i:s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
    
    $sql = "INSERT INTO `manage` (`farm#`,`username`,`identity`,`applicationDateTime`,`auditStatus`) VALUES ('{$farm}','{$_SESSION['login_user_id']}','{$identity}','{$dateTime}',0)";
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


//////////////////////////////ArduinoBlock//////////////////////////////

//新增arduino
//add_arduino.php
function add_arduino($arduino,$positionDescription,$farm)
{
    $result = null;
    $sql = "INSERT INTO `arduino`(`arduino#`,`positionDescription`,`farm#`) VALUES('{$arduino}','{$positionDescription}','{$farm}')";
    $query = @mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        if(@mysqli_affected_rows($_SESSION['link'])>=1)
        {
            //arduino新增成功
            $result = '1';
        }
        else
        {
            //arduino新增失敗
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

//刪除arduino
//delete_arduino.php
function delete_arduino($arduino)
{
    $result = null;
    $sql = "DELETE FROM `arduino` WHERE `arduino#` = '{$arduino}'";
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

//編輯arduino
//change_arduino.php
function change_arduino($oldarduino,$arduino,$positionDescription,$GPS)
{
    $result = null;
    $sql = "UPDATE `arduino` SET `arduino#` = '{$arduino}',`positionDescription` = '{$positionDescription}',`gps` = '{$gps}' WHERE `arduino#` LIKE '{$_POST['oldarduino']}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    if($query)
    {
        if(@mysqli_affected_rows($_SESSION['link'])==1)
        {
            //arduino變更成功
            $result = '1';
        }
        else
        {
            //arduino變更成功
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

//查詢該使用者管理的所有農場
//account.php
function account_get_farm()
{
    $result = @get_farm();

    $html = "";
    if($result!="")
    {
        $html.='<div class="dropdown text-center">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="arduinoChoose" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        農場
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="arduinoChoose1stChild">';
            $i = 1;
            foreach($result as $row)
            {
                $html.='<a class="dropdown-item" href="#">'.$row['farm#'].' '.$row['positionDescription'].'</a>';
                if($i!=count($result) && count($result) != 0)
                {
                    $html.='<div class="dropdown-divider"></div>';
                }
                $i++;
            }
            $html.='</div>
                    </div>
                    <br />';
        echo $html;
    }
}

//查詢該使用者管理的所有農場的所有ARDUINO
//account.php,get_arduino.php
function get_admin_arduino($farm)
{
    $json_array = @array();

    //查詢該農場有哪些ARDUINO
    $sql="SELECT a.`arduino#`,a.`positionDescription`,a.`gps`
          FROM `arduino` a
          WHERE a.`farm#` = '{$farm}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    $arduino_array = @array();
    if ($query)
    {
        while($row = @mysqli_fetch_assoc($query))
        {
            $arduino_array[] = $row;
        }
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
    $json_array = @array("arduino" => $arduino_array);
    return @json_encode($json_array);
}

//////////////////////////////PermissionAuditBlock//////////////////////////////

//列出所有權限申請清單
//account.php
function get_application_list()
{
    $isFarmZero = 0;
    foreach($_SESSION['login_user_identity'] as $userIdentity)
    {
        if($userIdentity[0] == "FARM000000")
        {
            $isFarmZero=1;
            break;
        }
    }
    if($isFarmZero == 1)
    {
        $sql="SELECT `farm#`,`username`,`identity`,`applicationDateTime`
              FROM `manage`
              WHERE `auditStatus` = 0";
    }
    else
    {
        $sql="SELECT b.`farm#`,b.`username`,b.`identity`,b.`applicationDateTime`
              FROM `manage` a INNER JOIN `manage` b ON a.`farm#` = b.`farm#`
              WHERE a.`username` = '{$_SESSION['login_user_id']}' AND a.`auditStatus` = 1 AND b.`auditStatus` = 0";
    }
        
    $query = @mysqli_query($_SESSION['link'],$sql);
    $html="";
    if($query)
    {
        $html.='<div id="carouselControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">';
        $i=1;
        while($row = @mysqli_fetch_assoc($query))
        {
            if($i==1)
            {
                $html.='<div class="carousel-item active">';
            }
            else
            {
                $html.='<div class="carousel-item">';
            }
            $html.='<div class="permission-list-group">
                        <ul class="list-group permission-list-group">
                            <li class="list-group-item list-group-item-action borderless" id="application_username">
                                <strong>'.$row['username'].'</strong>
                            </li>
                            <li class="list-group-item list-group-item-action borderless" id="application_farm">
                                申請農場　　&nbsp<strong>'.$row['farm#'].'</strong>
                            </li>
                            <li class="list-group-item list-group-item-action borderless" id="application_identity">
                                申請權限　　&nbsp<strong>'.$row['identity'].'</strong>
                            </li>
                            <li class="list-group-item list-group-item-action borderless" id="application_dateTime">
                                申請時間　　&nbsp<strong>'.$row['applicationDateTime'].'</strong>
                            </li>
                        </ul>
                    </div>
                </div>';
            $i++;
        }

        $html.='</div>
                    <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>                                           
                </div>';
    echo $html;
    }
    else
    {
        //echo "語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
        return false;
    }
    
}

//允許權限申請，賦予權限並刪除權限申請清單中的資料
//application_permit.php
function application_permit($username,$farm,$identity,$dateTime)
{
    $result = null;
    //審核日期時間
    $auditDateTime = @date ("Y-m-d H:i:s" , mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y'))); 
    
    $sql = "UPDATE `manage` 
            SET `auditStatus` = 1,`auditDateTime` = '{$auditDateTime}',`auditor` = '{$_SESSION['login_user_id']}' 
            WHERE `username` = '{$username}'
            AND `farm#` = '{$farm}'
            AND `identity` = '{$identity}'
            AND `applicationDateTime` = '{$dateTime}'";
    $query = @mysqli_query($_SESSION['link'],$sql);
    
    if($query)
    {
        //users.identity更新成功
        $result = '1';
    }
    else
    {
        //users.identity更新失敗
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

//刪除使用者權限或權限申請清單中的資料
//application_delete.php,delete_permission.php
function delete_permission($farm,$identity,$username)
{
    $result = null;
    $sql = "DELETE FROM `manage` WHERE `username` = '{$username}' AND `farm#` = '{$farm}' AND `identity` = '{$identity}'";
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

//////////////////////////////PermissionListBlock//////////////////////////////

//列出登入者可管理的所有權限
//account.php
function get_manage_list()
{
    $result = @get_manage();
    $html="";
    $html.='<ul class="list-group account-list-group">';
    foreach($result as $row)
    {
        if($row[1] == "MIS")
        {
            $row[1]=$row[1]."&nbsp"."&nbsp";
        }
        $html.='<li class="list-group-item list-group-item-action borderless" id="'.$row[0].' '.$row[1].' '.$row[2].'">
                    <div style="float:right;">
                        <svg xmlns="http://www.w3.org/2000/svg" height="17" viewBox="0 0 48 48" width="17">
                            <g>
                                <path d="M6 34.5v7.5h7.5l22.13-22.13-7.5-7.5-22.13 22.13zm35.41-20.41c.78-.78.78-2.05 0-2.83l-4.67-4.67c-.78-.78-2.05-.78-2.83 0l-3.66 3.66 7.5 7.5 3.66-3.66z"/>
                                <path d="M0 0h48v48h-48z" fill="none"/>
                                <rect class="btn" x="0" y="0" width="50" height="50" onclick="editPeopleClick('.'\''.$row[0].','.$row[1].','.$row[2].','.$row[3].','.$row[4].','.$row[5].','.$row[6].'\''.')" />
                            </g>
                        </svg>
                    </div>
                    <strong id="username">'.$row[0].' '.$row[1].' '.$row[2].'</strong>
                </li>';
    }
    //'\''.$row[0].' '.$row[1].' '.$row[2].' '.$row[3].' '.$row[4].' '.$row[5].'\''
    $html.='</ul>'; 
    echo $html;
}


endif;
?>