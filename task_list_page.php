
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
        include_once('dbConn.php');
        $query="SELECT * from taskinfo ORDER BY sequenceNum ASC";
        $result = mysqli_query($conn, $query);
    }
?>
<style>
.container{
    display:none;
}    
</style>
<html>
    <head>
        <title>Task List Page</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_list_view.css">
        <script src="javascript/jquery-3.5.1.min.js"></script>
    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
                Task List 
            </h4>
        </header>
        <section class="section1">
            <div class="container" id="display1">
                <div class="listHeader">
                    <img src="images/logos_icons/task_icon.png" alt="notebook">
                </div>
                <div class="listBlock">
                    <?php
                        while($row = mysqli_fetch_assoc($result))
                        {
                    ?>
                    <div class = "singleRecord" >
                        <p class="tooltip">
                            <a href="specific_task_appo_page.php?tsx='<?php echo $row['taskID']; ?>'" >
                                 <?php echo $row['title']; ?> (Sequence: <?php echo $row['sequenceNum']; ?>)                           
                            </a>           
                        </p>
                    </div>   
                    <?php
                        }
                    ?>
                </div>
                <div class="listBottom">
                    <a href="task_add.php?">                
                        <button type="button" class="btn-add" style="position:relative; top:5px;">Add a New Task</button>
                    </a>
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