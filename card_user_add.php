
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
        $addWhat = $_GET['HCT'];
        include_once('dbConn.php');
        $query = "SELECT * FROM cards WHERE id = '1' ORDER BY id DESC";
        $result = mysqli_query($conn, $query);
        if($addWhat=='CCD'){
            $addType='Card';
        }
        else if($addWhat=='PGH'){
            $addType='Resident';
        }
        else if($addWhat=='SDF'){
            $addType='Staff';
        }
        else{
            echo "<script>alert('Error occurs.');</script>";
            $url1="personal_home_page.php";
            echo "<script> location.href= '$url1'; </script>"; 
        }
        $_SESSION['addType'] = $addWhat; 
    }
?>
<style>
.container{
    display:none;
}    
</style>
<html>
    <head>
        <title>Add record</title>
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
        <script type='text/javascript'>
            $( document ).ready(function() {
                $('#datetimepicker2').datetimepicker();
            });
        </script>
    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
            Add a <?php echo $addType ?> 
            </h4>
        </header>
        <section class="section1">
            <div class="container" id="display1" style="width:960px">  
                <div class="containerHeader">
                    <p align="center" style="position:relative;top:10px;font-weight:bold;font-size:18px;">Please Input Event Info</p><br />                                                      
                </div> 
                <div class="formBlock" style="overflow:auto; height:380px; position: relative; top:-10px;">
                    <form class="form" style="position:relative; top:25px;" action="card_user_insert.php" method="POST">
                        <ul style="margin-bottom: 0px;">
                            <?php 
                                if($addType=='Card')
                                {
                            ?>
                                    <li>
                                        <input type="text" name="residentName" class="field-style field-split align-left" placeholder="Resident Name" required/>
                                        <select type="text" name="cardType" class="field-style field-split align-right" required>
                                            <option selected hidden value="">Select Card Type</option>
                                            <option value="Yellow">Yellow</option>
                                            <option value="Red">Red</option>
                                        </select>
                                    </li>
                                    <li>
                                        <input type="text" name="givenBy" class="field-style field-split align-left" placeholder="Given By" required/>
                                        <input type="text" name="moment" class='field-style field-split align-right' id='datetimepicker1' placeholder="Moment" required/>
                                    </li>
                                    <li>
                                        <textarea type="text" name="cause" class="field-style" placeholder="Cause" required></textarea>   
                                    </li>
                                    <li>
                                        <input type="submit" value="Submit"  />
                                    </li>
                            <?php 
                                }
                            ?>

                            <?php 
                                if($addType=='Resident')
                                {
                            ?>
                                    <li>
                                        <input type="text" name="name" class="field-style field-full align-left" placeholder="Resident Name" required/>
                                    </li>
                                    <li>
                                        <input type="text" name="birthDate" class='field-style field-split align-left' id='datetimepicker1' placeholder="Birthdate" required/>
                                        <input type="text" name="joinTime" class='field-style field-split align-right' id='datetimepicker2' placeholder="Join since" required/>
                                    </li>
                                    <li>
                                        <input type="text" name="username" class='field-style field-full' placeholder="Please input a username" required/>
                                    </li>
                                    <li>
                                        <input type="password" name="password" class='field-style field-full' placeholder="Please input a password" required/>
                                    </li>
                                    <li>
                                        <input type="password" name="vpassword" class='field-style field-full' placeholder="Please confirm the password" required/>
                                    </li>

                                    <li style="margin-bottom:0px;" >
                                        <input type="submit" value="Submit" />
                                    </li>
                            <?php 
                                }
                            ?>

                            <?php 
                                if($addType=='Staff')
                                {
                            ?>
                                    <li>
                                        <input type="text" name="name" class="field-style field-split align-left" placeholder="Staff Name" required/>
                                        <input type="text" name="position" class="field-style field-split align-right" placeholder="Occupation" required/>
                                    </li>
                                    <li>
                                        <input type="text" name="birthDate" class='field-style field-split align-left' id='datetimepicker1' placeholder="Birthdate" required/>
                                        <input type="text" name="joinTime" class='field-style field-split align-right' id='datetimepicker2' placeholder="Join since" required/>
                                    </li>
                                    <li>
                                        <input type="text" name="username" class='field-style field-full' placeholder="Please input a username" required/>
                                    </li>
                                    <li>
                                        <input type="password" name="password" class='field-style field-full' placeholder="Please input a password" required/>
                                    </li>
                                    <li>
                                        <input type="password" name="vpassword" class='field-style field-full' placeholder="Please confirm the password" required/>
                                    </li>

                                    <li>
                                        <input type="text" name="question1" class="field-style field-split align-left" placeholder="Security question 1" required/>
                                        <input type="password" name="answer1" class='field-style field-split align-right' id='datetimepicker2' placeholder="Answer to question 1" required/>
                                    </li>
                                    <li>
                                        <input type="text" name="question2" class="field-style field-split align-left" placeholder="Security question 2" required/>
                                        <input type="password" name="answer2" class='field-style field-split align-right' id='datetimepicker2' placeholder="Answer to question 2" required/>
                                    </li>
                                    <li>
                                        <input type="text" name="question3" class="field-style field-split align-left" placeholder="Security question 3" required/>
                                        <input type="password" name="answer3" class='field-style field-split align-right' id='datetimepicker2' placeholder="Answer to question 3" required/>
                                    </li>
                                    <li>
                                        <select type="text" name="isAdmin" class="field-style field-split align-left" required>
                                            <option selected hidden value="">Allow admin?</option>
                                            <option value="yes">yes</option>
                                            <option value="no">no</option>
                                        </select>
                                    </li>
                                    <li style="margin-bottom:0px;">
                                        <input type="submit" value="Submit"  />
                                    </li>
                            <?php 
                                }
                            ?>

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