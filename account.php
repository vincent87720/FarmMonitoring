<?php
    require_once 'php/connect.php';
    if(!isset($_SESSION['is_login'])||$_SESSION['is_login']==FALSE):
    {
        header("Location: index.php");
    }
    else:
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>自動化農場監測</title>
        <meta name="keyword" content="農場'自動化農場'農場數據監測'"><!--keyword讓搜索引擎容易找到此網頁-->
        <meta name="viewport" content="width=device-width, initial-scale=1" ><!--指定螢幕寬度為裝置寬度，畫面載入初始縮放比例 100%-->
        <link rel="icon" href="image/barrier.ico">
        <noscript>
            
        </noscript>
        <link rel="stylesheet" href="css/style.css" type="text/css" charset="utf8">
        <!--Bootstrap CSS-->
        <link rel="stylesheet" href="css/bootstrap.css">
        <!--Bootstrap CSS-->
        
        <!--JQUERY-->
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <!--JQUERY-->

        <!--JavaScript-->
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <!--JavaScript-->
    </head>
    <body>
        <div class="background">
            <div class="topbar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <br>
                            <!--顯示登入中帳號的資訊與登出按鈕-->
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-info" onclick="location.href='monitor.php'">農場監測</button>
                                <button type="button" class="btn btn-info" onclick="location.href='php/logout.php'">登出</button>
                            </div>
                            <!--顯示登入中帳號的資訊與登出按鈕-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!--顯示LOGO與標題-->
                            <embed src="image/barrier.svg" style="display:inline; vertical-align:middle; width:70px; height:70px; margin:auto;">
                            <h2 style="display:inline; vertical-align:middle;">自動化農場監測</h2>
                            <!--顯示LOGO與標題-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-4 ml-auto">
                            <div class="jumbotron jumbotron-fluid">
                                <div class="container">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mr-auto">
                            <div class="jumbotron jumbotron-fluid">
                                <div class="container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    endif;
?>