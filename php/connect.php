﻿<?php
@session_start();
//設定連線資訊，建立與bbqandvenuerental資料庫的連線
$host='localhost';
$username='root';
$password='iamadmin';
$database='testdb';

//宣告一個Link變數，連結結果會帶入link中
//$link=mysqli_connect($host,$username,$password,$database);

$_SESSION['link']=mysqli_connect($host,$username,$password,$database);
if($_SESSION['link'])
{
    //若傳回True，代表已建立連線
    //設定編碼為UTF-8
    mysqli_query($_SESSION['link'],"SET NAMES utf8");
}
else
{
    //連線失敗，mysql_connect_error()顯示錯誤訊息
    echo '無法連線mysql資料庫:<br/>'.mysql_connect_error();
}
?>