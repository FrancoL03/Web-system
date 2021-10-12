
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
        $username = $_SESSION['username'];
        include_once('dbConn.php');
        $query="SELECT staff.staffName,staff.position, accountstaff.isAdmin from staff INNER JOIN accountstaff ON staff.staffName = accountstaff.name 
                WHERE accountstaff.username = '$username';";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if(isset($row['staffName'])){
            $isAdmin = $row['isAdmin'];
        }
        else{//the current account is deleted
            echo "<script>alert('Please login in again.');</script>";
            echo "<script> location.href= '$url1'; </script>"; 
        }
    }
?>
<style>

.leftHalf{
    display:none;
}

.rightHalf{
    display:none;
}

.rcontainer{
    display:none;
}
</style>

<html>
    <head>
        <title>Personal Home Page  </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                Personal Home Page 
            </h4>
        </header>
        <section class="section1">
            <div class = "leftHalf" id="display1" >
                <div class="left_split_header" >
                    <?php 
                        if($isAdmin=='yes'){
                    ?>
                    <img src="images/avatars/avatar_admin.png" alt="avatar">
                    <?php 
                        }
                    ?>
                    <?php 
                        if($isAdmin!='yes'){
                    ?>
                    <img src="images/avatars/avatar_normal.png" alt="avatar">
                    <?php 
                        } 
                    ?>
                </div>
                <div class="left_split_panel">    
                    <div class="left_split_panel_line" id="staffName" style="position:relative; top:20px;">
                        <p id="staffName" style="position:relative; top:10px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize;">
                            <?php echo $row['staffName']; ?>
                        </p>
                    </div>
                    <div class="left_split_panel_line" id="position" style="margin-top:40px; font-size:20px;">
                        <p id="position" style="position:relative; top:8px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize;">
                            Position: <?php echo $row['position']; ?>
                        </p>
                    </div>
                    <div class="left_split_panel_line" id="isAdmin" style="margin-top:20px; font-size:20px;">
                        <p id="isAdmin" style="position:relative; top:8px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize;">
                            <?php 
                                if($isAdmin=='yes'){
                            ?>
                                < Administrator >
                            <?php 
                                }
                            ?>
                            <?php 
                                if($isAdmin!='yes'){
                            ?>
                                < Non-Administrator >
                            <?php 
                                }
                            ?>
                        </p>    
                    </div>  
                </div>                    
            </div>

        <div class="rightHalf" id="display2">

            <div class = "bar">
            </div>
            <div class = "funcHeader">
            <p id="func" style="margin-top:auto;position:relative;top:8px;font-weight: bold;font-size:18px; 
                            font-family: Arial, Helvetica, sans-serif;text-transform: capitalize;" >
            Function Panel
            </p>
            </div>

            <div class = "rcontainer" id="display3">
                <div class = "lineblock" >
                    <div class="sblock">
                        <a href="appo_list_page.php">                
                            <img src="images/logos_icons/notebook_icon.png" alt="avatar">
                        </a>
                        <p>Appointments</p>
                    </div>
                    <div class="sblock">
                        <a href="card_list_page.php">
                            <img src="images/logos_icons/red_yellow_card_icon.png" alt="avatar">
                        </a>
                        <p>Cards</p>
                    </div>
                    <div class="sblock">
                        <a href="progress_board.php">
                            <img src="images/logos_icons/progress_icon.png" alt="avatar">
                        </a>   
                        <p>Progress</p>
                    </div>
                    <div class="sblock">
                        <a href="resident_list_page.php">
                            <img src="images/logos_icons/resident_icon.png" alt="avatar">
                        </a>    
                        <p>Residents</p>
                    </div>
                </div>

                <?php 
                    if($isAdmin=='yes'){
                ?>
                <div class = "lineblock" >
                    <div class="sblock" >
                        <a href="admin_func_page.php">
                            <img src="images/logos_icons/lock_icon.png" alt="avatar">
                        </a>    
                        <p>Admin</p>
                    </div>
                    <div class="sblock" >
                        <a href="card_user_add.php?HCT=SDF">
                            <img src="images/avatars/avatar_staff.png" alt="avatar">
                        </a>    
                        <p>Add Staff</p>
                    </div>
                    <div class="sblock" >
                        <a href="card_user_add.php?HCT=PGH">
                            <img src="images/avatars/avatar_resident.png" alt="avatar">
                        </a>    
                        <p>Add Resident</p>
                    </div>
                    <div class="sblock" >
                        <a href="task_list_page.php">
                            <img src="images/logos_icons/task_icon.png" alt="avatar">
                        </a>    
                        <p>Task List</p>
                    </div>
                </div>
                <?php 
                    }
                ?>

                <div class = "lineblock" >
                    <div class="sblock" >
                        <a href="log_out_page.php">
                            <img src="images/logos_icons/log_out_icon.png" alt="avatar">
                        </a>    
                        <p>Log out</p>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <p id="footerText" style="margin-top:6px;font-weight: lighter;" >
                De Spiegel
            </p>
        </footer>

    </body>
</html>
<script type="text/javascript">
 
 $(document).ready(function(){
 	for(var i=1;i<4;i++)
 	{
 		var theid = $("#display"+i);
 		var thetime = 400 *i;
 		$(theid).fadeIn(thetime); 
 	}
 });

</script>