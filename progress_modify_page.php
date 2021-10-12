
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
        
    }
?>
<style>
.container{
    display:none;
}    
</style>
<html>
    <head>
        <title>Modify the Progress of a Resident</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_add_record.css">
        <link rel="stylesheet" type="text/css" href="bootstrap-3.3.6/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.min.css">
        <style type="text/css">
            .container {
                margin-top: 40px;
            }
            .btn-primary {
                width: 100%;
            }
        </style>

        <script type="text/javascript" src="javascript/jquery-1.12.4.min.js"></script> 
        <script type="text/javascript" src="javascript/moment.min.js"></script> 
        <script type="text/javascript" src="bootstrap-3.3.6/dist/js/bootstrap.min.js"></script> 
        <script type="text/javascript" src="javascript/bootstrap-datetimepicker.min.js"></script>

        <script type='text/javascript'>
            $( document ).ready(function() {
                $('#datetimepicker1').datetimepicker();
            });
        </script>

    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
            Modify the Progress of a Resident 
            </h4>
        </header>
        <section class="section1">
            <div class="container" id="display1" style="width:960px">  
                <div class="containerHeader" >
                    <p align="center" style="position:relative;top:25px;font-weight:bold;font-size:18px;">Please Input Modification Info</p><br />                                                      
                </div> 
                <div class="formBlock">
                    <form class="form" action="progress_modify_insert.php" method="POST" style="position:relative; top:0px;">
                        <ul style="margin-bottom: 0px;">
                            <li>
                                <input type="text" name="name" class="field-style field-full align-left" placeholder="Resident's Name" required/>
                            </li>
                            <li>
                                <select type="text" name="taskLevel" class="field-style field-full align-right" required>
                                    <option selected hidden value="">Select the task Level</option>
                                    <option value="level01">level01</option>
                                    <option value="level02">level02</option>
                                    <option value="level03">level03</option>
                                </select>
                            </li>
                            <li>
                                <input type="text" name="sequenceNum" class="field-style field-full align-right" placeholder="Task Sequence Number" required/>
                            </li>
                            <li>
                                <select type="text" name="taskState" class="field-style field-full align-right" required>
                                    <option selected hidden value="">Select the task state</option>
                                    <option value="finished">finished</option>
                                    <option value="">unfinished</option>
                                </select>
                            </li>    
                            <li>
                                <input type="submit" value="Submit"  />
                            </li>
                        </ul>
                    </form>
                </div>
            </div>  
        </section>

        <footer>
            <p id="footerText" style="margin-top:4px;font-weight: lighter;" >
                <a href = "personal_home_page.php"  style="text-decoration: none; font-weight:inherit; font-family:'Times New Roman'; font-size:inherit; color:inherit;">    
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