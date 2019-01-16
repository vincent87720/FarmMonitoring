<?php
//session_cache_limiter('private');//返回上一頁時(history.go(-1))不清空表單，只在session生效期間
@ini_set("session.cookie_httponly", 1);//限制Cookie只能經由HTTP(S)協定來存取
@ini_set("session.cookie_lifetime", 0);//設定Cookie的存活時間在瀏覽器關閉後失效(有些瀏覽器不支援)
//ini_set('session.cookie_secure', 1);//限制Cookie只能透過https的方式傳輸
@session_start();
//設定連線資訊，建立與bbqandvenuerental資料庫的連線
$host='127.0.0.1';
$username='webuser';
$password='iamwebuser';
$database='farmmonitoring';

//宣告一個Link變數，連結結果會帶入link中
//$link=mysqli_connect($host,$username,$password,$database);

$_SESSION['link']=@mysqli_connect($host,$username,$password,$database);
if($_SESSION['link'])
{
    //若傳回True，代表已建立連線
    //設定編碼為UTF-8
    @mysqli_query($_SESSION['link'],"SET NAMES utf8");
}
else
{
    //連線失敗，mysql_connect_error()顯示錯誤訊息
    //echo '無法連線mysql資料庫:<br/>'.mysql_connect_error();
}
?>