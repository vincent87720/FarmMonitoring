<!DOCTYPE HTML>
<html>
    <head>
        <title>自動化農場監測</title>
        <meta name="keyword" content="農場'自動化農場'農場數據監測'"><!--keyword讓搜索引擎容易找到此網頁-->
        <meta name="viewport" content="width=device-width, initial-scale=1" ><!--指定螢幕寬度為裝置寬度，畫面載入初始縮放比例 100%-->
        <link rel="icon" href="./image/barrier.ico">
        <noscript>
            
        </noscript>
        <link rel="stylesheet" href="css/style.css" type="text/css" charset="utf8">
        <!--Bootstrap CSS-->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!--Bootstrap CSS-->

        <!--Bootstrap JAVA-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!--Bootstrap JAVA-->

    </head>
    <body>
        <!-- CheckLogin -->
        <?php
            if(isset($_SESSION['is_login']) && $_SESSION['is_login']==TRUE):
                header('Location: backend.php');
            else:
        ?>
        <!-- CheckLogin -->

        <div class="top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <embed src="./image/barrier.svg" style="display:block; width:70px; height:70px; margin:auto;"/>
                        <br>
                        <h2 class="text-center">自動化農場監測</h2>
                        <br>
                        <div class="col-sm-4 ml-auto mr-auto">
                            <form method="post" name="login" action="./php/checklogin.php">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password">
                                </div>

                                <!-- CheckLogin -->
                                <?php
                                    if(isset($_GET['msg']))
                                    {
                                        echo "<p class='error'>{$_GET['msg']}</p>";
                                    }
                                ?>
                                <!-- CheckLogin -->
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-default">Submit</button>                                    
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer">
        
        </div>
        <!-- CheckLogin -->
        <?php endif;?>
        <!-- CheckLogin -->
    </body>
</html>