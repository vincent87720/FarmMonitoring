<?php
    @session_start();
    
    //清空session信息
    $_SESSION = array();
    
    //清除客户端sessionid
    if(isset($_COOKIE[@session_name()]))
    {
        @setCookie(@session_name(),'',time()-3600,'/');
    }

    //清除session
    @session_destroy();
    
    @header("Location: ../index.php");
?>