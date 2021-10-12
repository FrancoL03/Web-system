
<!DOCTYPE html>
<?php
    session_start();
    $now = time();
    $url1="login_page.php";

    if (!isset($_SESSION['expireTime']) or !isset($_SESSION['username'])) {
        session_destroy();
        echo "<script>alert('Invalid access! Please login first.');</script>";
        echo "<script> location.href= '$url1'; </script>"; 
    }
    else if ($now > $_SESSION['expireTime']){
        session_destroy();
        echo "<script>alert('Your Login has expired! Please login again.');</script>";
        echo "<script> location.href= '$url1'; </script>"; 
    }
    else
    {
    }
?>
<style>
.container{
    display:none;
}    
.btn-logout{
    margin-top: 0px;
    padding: 10px 20px;
    border-radius: 6px;
    color:white;
    opacity: 1;
    font-weight: bold;
    outline:none;
    position: relative;
    left: -36px;
    transition: 0.6s;

    border-width: 0 3px 3px 0;
}
.btn1 {
    background: rgb(108, 199, 66);
    border-color: #8af798;
}
.btn2 {
    background: rgb(230, 66, 38);
    border-color: #f78a8a;
}
.btn1:hover {
    opacity: 1;
    background: rgb(66, 136, 34);
    transform: scale(1.08);
    box-shadow: 0 0 10px rgb(66, 136, 34);;
    z-index: 2;
    transition: 0.6s;
}
.btn2:hover {
    opacity: 1;
    background: rgb(173, 50, 50);
    transform: scale(1.08);
    box-shadow: 0 0 10px rgb(173, 50, 50);
    z-index: 2;
    transition: 0.6s;
}
</style>
<html>
    <head>
        <title>Log Out</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_list_view.css">
        <script src="javascript/jquery-3.5.1.min.js"></script>
    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
                Log Out 
            </h4>
        </header>
        <section class="section1">
            <div class="container" id="display1" >
                <div class="listHeader">
                    <img src="images/logos_icons/log_out_icon.png" alt="notebook">
                </div>

                <div class="listBlock" style="height:80px; width:500px; text-align:center;" >
                    <p style="font-size:25px; font-weight:bold; position:relative; top:20px;">
                        Do you really want to log out?
                    </p>
                        
                
                </div>
                <div class="listBottom">
                    
                    <?php
                        if(isset($_POST['logout'])) { 
                            session_destroy();

                            $url = "login_page.php";
                            echo "<script>alert('You have been logged out sucessfully! ☺');</script>";
                            echo "<script> location.href= '$url'; </script>";
                        } 
                        if(isset($_POST['stay'])) { 
                            $url = "personal_home_page.php";
                            echo "<script> location.href= '$url'; </script>"; 
                        } 
                    ?> 
                    <form method="post"> 
                        <input type="submit" name="logout" class="btn-logout btn1"
                                value="Yes" style="position:relative; top:5px; left:-5px; width:120px;"/> 
                        
                        <input type="submit" name="stay" class="btn-logout btn2"
                                value="No" style="position:relative; top:5px; left:5px; width:120px;"/> 
                    </form> 
                </div>
            </div> 
        </section>

        <footer>
            <p id="footerText" style="margin-top:6px;font-weight: lighter;" >
                <a href = "personal_home_page.php"  style="font-weight:inherit; font-family:inherit; font-size:inherit; color:inherit;">    
                    Go to The Home Page                    
                </a>  
            </p>
        </footer>

    </body>
</html>
<script type="text/javascript">
 
 $(document).ready(function(){

 		var theid = $("#display1");
 		var thetime = 800 *1;
 		$(theid).fadeIn(thetime); 

 });

</script>