
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
        <title>Add a New Task</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_add_record.css">
        <link rel="stylesheet" type="text/css" href="bootstrap-3.3.6/dist/css/bootstrap.min.css">
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

    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
            Add a New Task
            </h4>
        </header>
        <section class="section1">
            <div class="container" id="display1" style="width:960px">  
                <div class="containerHeader" >
                    <p align="center" style="position:relative;top:25px;font-weight:bold;font-size:18px;">Please Input Task Info</p><br />                                                                                                      
                </div> 
                <div class="formBlock">
                    <form class="form" action="task_insert.php" method="POST" style="position:relative; top:0px;">
                        <ul style="margin-bottom: 0px;">
                            <li>
                                <input type="text" name="theme" class="field-style field-split align-left" placeholder="Task Title" required/>
                                <select  type="text" name="level" onchange="myfunc(this.value)" class="field-style field-split align-right" required>
                                    <option selected hidden value="">Select Task Level</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                            </li>
                            <li>
                                <select type="text" id="tasks" name="sequenceNum" class="field-style field-full align-right" required> <!-- will be filled by function-->
                                    <option selected hidden value=''>Choose a Sequence Number</option>
                                </select>
                            </li>
                            <li>
                                <textarea type="text" name="content" class="field-style" placeholder="Task Specification" style="height:120px;" required></textarea>   
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
<script>
    function myfunc(inputlevel){

        var yroptions = "<option selected hidden value=''>Choose a Sequence Number</option>"
        if (inputlevel=='01')
        {
            for (var i = 1; i < 16; i++ )
            {
                yroptions += "<option value='S1_task"+i+"'>S1_task"+i+"</option>";
            }
        }
        else if (inputlevel=='02')
        {
            for (var i = 1; i < 16; i++ )
            {
                yroptions += "<option value='S2_task"+i+"'>S2_task"+i+"</option>";
            }
        }
        else
        {
            for (var i = 1; i < 16; i++ )
            {
                yroptions += "<option value='S3_task"+i+"'>S3_task"+i+"</option>";
            }
        }
        document.getElementById("tasks").innerHTML = yroptions; 
    }
</script>