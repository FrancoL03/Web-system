
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
    else{
            $residentName = $_GET['rty'];
            include_once('dbConn.php');
            $query="SELECT * FROM residents WHERE residentName = '$residentName'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
    }
?>
<style>

.leftHalf{
    display:none;
}    

.rightHalf{
    display:none;
}    

</style>
<html>
    <head>
        <title>Resident info</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_home_page.css">
        <script src="javascript/jquery-3.5.1.min.js"></script>
    </head>
    <script>
        fucntion passvalue()
        {
            var taskName = document.getElementById("task").value;
            lcoalStorage.setItem("task_name", taskName);
        }
    </script>    

    <body>
        <header>
        <h4 id="footerText" style="margin-top:3px;" >
            Resident Info 
            </h4>
        </header>
        <section class="section1" >
            <div class = "leftHalf" id="display1">
                <div class="left_split_header">
                    <img src="images/avatars/avatar_resident.png" alt="avatar">
                </div>
                <div class="left_split_panel">    
                    <div class="left_split_panel_line" id="residentName" style="position:relative; top:20px;">
                        <p id="residentName" style="position:relative; top:3px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize;">
                            <?php echo $row['residentName']; ?>
                        </p>
                    </div>
                    <div class="left_split_panel_line" id="birthdate" style="margin-top:40px">
                        <p id="birthdate" style="position:relative; top:8px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize;">
                            Birthdate: <?php echo $row['birthdate']; ?>
                        </p>
                    </div>
                    <div class="left_split_panel_line" id="joinTime" style="margin-top:20px">
                        <p id="joinTime" style="position:relative; top:8px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize;">
                            Joined Since: <?php echo $row['joinTime']; ?>
                        </p>    
                    </div>  
                </div>   
            </div>

            <div class="rightHalf" id="display2">

                <div class = "bar">
                </div>
                <div class = "funcHeader">
                <p id="position" style="margin-top:auto;position:relative;top:8px;font-weight: bold; font-size:18px; font-family: Arial, Helvetica, sans-serif;text-transform: capitalize;" >
                                
                Function Panel
                </div>

                <div class = "rcontainer" >
                    <div class = "lineblock" style="position:relative">
                        <div class="sblock">
                            <a href="specific_card_page.php?rpx=<?php echo $residentName?>" >
                                <img src="images/logos_icons/red_yellow_card_icon.png" alt="avatar">
                            </a>
                            <p>Card Events</p>
                        </div>
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
 		var thetime = 800 *1;
 		$(theid).fadeIn(thetime); 

        var theid = $("#display2");
 		var thetime = 800 *1;
 		$(theid).fadeIn(thetime);  

 });

</script>