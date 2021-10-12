
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
</style>   
<html>
    <head>
        <title>Admin Control Panel</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_list_view.css">
        <script src="javascript/jquery-3.5.1.min.js"></script>
    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
                Admin Control Panel
            </h4>
        </header>
        <section class="section1">
            <div class="container" id="display1">
                <div class="listHeader">
                    <img src="images/logos_icons/lock_icon.png" alt="notebook">
                </div>

                <div class="listBlock">
                    <div class = "singleRecord"  style="margin-top:20px;">
                        <p class="tooltip">
                            <a href = "specific_admin_func_page.php?afc=MAS"  >
                                Modify Account Info of a Staff                    
                            </a>         
                        </p>
                    </div>  
                    <div class = "singleRecord"  style="margin-top:20px;">
                        <p class="tooltip">
                            <a href = "specific_admin_func_page.php?afc=MAP"  >    
                                Modify Account Info of a Resident                    
                            </a>         
                        </p>
                    </div>  
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
 		var thetime = 800;
 		$(theid).fadeIn(thetime); 
 	
 });

</script>