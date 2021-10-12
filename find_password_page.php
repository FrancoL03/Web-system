
<!DOCTYPE html>
<?php
    session_start();
    include_once('dbConn.php');
    if(isset($_GET['afts']))
    {
        if($_GET['afts']=='yes') //the account is found
        {
            $showQuestion = 'yes';
            $question1 = $_SESSION['question1'];
            $question2 = $_SESSION['question2'];
            $question3 = $_SESSION['question3'];
        }
        else 
        {
            $showQuestion = 'no';
        }
    }
    else
    {
        $showQuestion = 'no';
    }
    
?>
<style>
.container{
    display:none;
}    
</style>
<html>
    <head>
        <title>Find Password</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_add_record.css" />  
        <link rel="stylesheet" href="bootstrap-3.3.6/dist/css/bootstrap.min.css" />  

        <script src="javascript/jquery-3.5.1.min.js"></script>
        <script src="javascript/bootstrap.min.js"></script>            
        <script src="javascript/jquery.tabledit.min.js"></script>

    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
            Find Your Password Back
            </h4> 
        </header>
        <section class="section1">
            <div class="container" id="display1" style="width:1060px; height:360px; position:relative; top:20px; ">  
                <div class="tableHeader" >
                    <?php 
                        if($showQuestion == 'no')
                        {
                            echo 'Please search for your account by username';
                        }
                        else if (!isset($_SESSION['ifAnsOk']))
                        {
                            echo 'Please input the correct answer to your security questions';
                        }
                        else
                        {
                            echo 'Please reset your password';
                        }
                    ?>
                </div>
                <div class="table-responsive" style="position:relative; bottom:-12px;left:0px; height:300px;">  
                    <?php 
                         if( ($showQuestion == 'no') && !isset($_SESSION['ifAnsOk'])) // search bar
                         {
                    ?> 
                            <div class="formBlock" style="height:220px">
                                <form class="form" action="find_password_search.php?" method="POST" style="position:relative; top:20px;">
                                    <ul style="margin-bottom: 0px;"> 
                                        <li>
                                            <input type="text" name="username" class="field-style field-full align-left" placeholder="Please input your username" required/>
                                        </li>
                                        <input type="hidden" name="action" value="search"  />
                                        <li>
                                            <input type="submit" value="Search"  />
                                        </li>
                                    </ul>
                                </form>
                            </div>
                    <?php 
                         }
                    ?> 


                    <?php 
                         if(($showQuestion == 'yes') && !isset($_SESSION['ifAnsOk']) ) // show the security question
                         {
                    ?>      
                            <div class="formBlock" style="height:270px">
                                <form class="form" action="find_password_search.php" method="POST" style="position:relative; top:20px;">
                                    <ul style="margin-bottom: 0px;">
                                        <li>
                                            <div class="field-style field-full align-left">
                                                    <?php echo $question1;?>
                                            </div>
                                        </li>    
                                        <li>
                                            <input type="password" name="answer1" class="field-style field-full align-left" placeholder="Please input your answer for the first question" required/>
                                        </li>
                                        <li>
                                            <div class="field-style field-full align-left">
                                                    <?php echo $question2;?>
                                            </div>
                                        </li>    
                                        <li>
                                            <input type="password" name="answer2" class="field-style field-full align-left" placeholder="Please input your answer for the second question" required/>
                                        </li>
                                        <li>
                                            <div class="field-style field-full align-left">
                                                    <?php echo $question3;?>
                                            </div>
                                        </li>    
                                        <li>
                                            <input type="password" name="answer3" class="field-style field-full align-left" placeholder="Please input your answer for the third question" required/>
                                        </li>
                                        <input type="hidden" name="action" value="confirm"  />
                                        <li>
                                            <input type="submit" value="Confirm"  />
                                        </li>
                                    </ul>
                                </form>
                            </div>
                    <?php 
                         }
                    ?> 

                    <?php
                        if(isset($_POST['reset_btn'])) { //if click the confirm btn to reset password
                        
                            $new_pw = $_POST['new_pw'];
                            $con_new_pw = $_POST['con_new_pw'];
                            if($new_pw == $con_new_pw)
                            {
                                $the_username =  $_SESSION['the_username'];
                                $hashedPwInDb = password_hash($new_pw, PASSWORD_DEFAULT);
                                $query1 = " UPDATE accountstaff SET password = ? WHERE username = ? "; 
                                $stmt = $conn->prepare($query1);
                                $stmt->bind_param("ss", $hashedPwInDb, $the_username);
                                $result1 = $stmt->execute(); 

                                $url = "login_page.php";
                                if($result1)
                                {
                                    session_destroy();
                                    echo "<script>alert('The password has been successfully reset!☺ Now you can log in with your new password. ');</script>";
                                    echo "<script> location.href= '$url'; </script>";
                                }
                                else
                                {   
                                    session_destroy();
                                    echo "<script>alert('Failed to reset the password, error happens.:-( ');</script>";
                                    echo "<script> location.href= '$url'; </script>";
                                }

                            }
                            else 
                            {
                                echo "<script>alert('Please confirm your password! Make sure you have typed the same password. ');</script>";
                                echo "<script> location.href= \"javascript:history.go(-1)\"; </script>"; 

                            }

                        } 
                    ?>     
                    <?php 
                         if(isset($_SESSION['ifAnsOk'])) // password reset
                         {
                            if($_SESSION['ifAnsOk']=='yes'){
                    ?>      
    
                            <div class="formBlock" style="height:270px">
                                <form class="form"  method="POST" style="position:relative; top:20px;">
                                    <ul style="margin-bottom: 0px;">
                                         
                                        <li>
                                            <input type="password" name="new_pw" class="field-style field-full align-left" placeholder="Please input a new password" required/>
                                        </li>
                                        <li>
                                            <input type="password" name="con_new_pw" class="field-style field-full align-left" placeholder="Please confirm the password" required/>
                                        </li>
                                        <input type="hidden" name="action" value="confirm"  />
                                        <li>
                                            <input type="submit" name=reset_btn value="Confirm"  />
                                        </li>
                                    </ul>
                                </form>
                            </div>
                    <?php 
                        
                        unset($_SESSION['ifAnsOk']);
                    
                            }
                         }
                    ?> 

                </div>  
            </div>  
        </section>

        <footer>
            <p id="footerText" style="margin-top:4px;font-weight: lighter; font-family:'Times New Roman';" >
                De Spiegel
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

