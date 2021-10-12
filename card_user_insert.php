<?php
session_start();
include_once('dbConn.php');

$type = $_SESSION['addType'];
$type = str_replace("'", "", $type); 
$url1="personal_home_page.php";

if (mysqli_connect_error()) 
{
    echo 'Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error();
} 
else 
{

    if(isset($_POST['residentName']) && isset($_POST['cardType']) && isset($_POST['givenBy']) 
       && isset($_POST['moment']) && isset($_POST['cause'])
       )//add card event
    {
        $url1="card_list_page.php";
        $residentName = $_POST['residentName'];
        $cardType = $_POST['cardType'];
        $givenBy = $_POST['givenBy'];
        $moment = $_POST['moment'];
        $cause = $_POST['cause'];
        $isValid = 'Yes';
        $INSERT = "INSERT INTO cards (residentName, cardType, cause, givenBy, time, isValid) values(?, ?, ?, ?, ?, ?)";
        //Prepare statement
        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("ssssss", $residentName, $cardType, $cause, $givenBy, $moment, $isValid);
        $result1 = $stmt->execute();
        $result2='true'; 
        $result3='true';
        $result4='true';
        $result5='true';
    }
    else if(isset($_POST['name']) && isset($_POST['birthDate']) && isset($_POST['joinTime'])
             && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['vpassword']) 
            )//add staff or resident
    {
        $name = $_POST['name'];
        $birthDate = $_POST['birthDate'];
        $joinTime = $_POST['joinTime'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $vpassword = $_POST['vpassword'];

        if($password==$vpassword)//password verification
        { 
            $SELECT1 = "SELECT username From accountstaff Where username = ? Limit 1";
            //Prepare statement
            $stmt = $conn->prepare($SELECT1);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($username);
            $stmt->store_result();
            $rnum1 = $stmt->num_rows;
            $stmt->close();

            $SELECT2 = "SELECT username From accountresident Where username = ? Limit 1";
            //Prepare statement
            $stmt = $conn->prepare($SELECT2);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($username);
            $stmt->store_result();
            $rnum2 = $stmt->num_rows;
            $stmt->close();

            if ($rnum1==0 && $rnum2==0) //no duplication in username
            {
                if(!isset($_POST['position']))//resident
                { 
                    $hashedPwInDb = password_hash($password, PASSWORD_DEFAULT); 
                    $INSERT1 = "INSERT Into accountresident (name, username, password ) values(?, ?, ?)";
                    $stmt = $conn->prepare($INSERT1);
                    $stmt->bind_param("sss", $name, $username, $hashedPwInDb);
                    $result1 = $stmt->execute();
                    if($result1)//no duplication in name 
                    {  
                        $SELECT2 = "SELECT id From accountresident Where username = '$username'";
                        $resultx = mysqli_query($conn, $SELECT2);
                        $row = mysqli_fetch_assoc($resultx);
                        $identifier = $row['id'];
    
                        $stmt->close();
                        $INSERT2 = "INSERT Into residents (id, residentName, birthdate, joinTime) values(?, ?, ?, ?)";
                        $stmt = $conn->prepare($INSERT2);
                        $stmt->bind_param("ssss", $identifier, $name, $birthDate, $joinTime);
                        $result2 = $stmt->execute();
                    
                    //add a resident into the progress board
                        $INSERT3 = "ALTER TABLE progresslevel01 ADD COLUMN $name TEXT ";
                        $result3 = mysqli_query($conn, $INSERT3);
                        $INSERT4 = "ALTER TABLE progresslevel02 ADD COLUMN $name TEXT ";
                        $result4 = mysqli_query($conn, $INSERT4);
                        $INSERT5 = "ALTER TABLE progresslevel03 ADD COLUMN $name TEXT ";
                        $result5 = mysqli_query($conn, $INSERT5);
    
                        $stmt->close();
                        $conn->close();
                    }
                    else{} 
                }
                else if(isset($_POST['position']))//staff
                {
                    $position = $_POST['position'];
                    $isAdmin = $_POST['isAdmin'];
                    
                    $Q1 = $_POST['question1'];
                    $Q2 = $_POST['question2'];
                    $Q3 = $_POST['question3'];
                    $ans1 = $_POST['answer1'];
                    $ans2 = $_POST['answer2'];
                    $ans3 = $_POST['answer3'];

                    $hashedPwInDb = password_hash($password, PASSWORD_DEFAULT); 
                    $hsans1 = password_hash($ans1, PASSWORD_DEFAULT); 
                    $hsans2 = password_hash($ans2, PASSWORD_DEFAULT); 
                    $hsans3 = password_hash($ans3, PASSWORD_DEFAULT); 

                    $INSERT1 = "INSERT Into accountstaff (name, isAdmin, username, password, question1, answer1, question2, answer2, question3, answer3) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";
                    $stmt = $conn->prepare($INSERT1);
                    $stmt->bind_param("ssssssssss", $name, $isAdmin, $username, $hashedPwInDb, $Q1, $hsans1, $Q2, $hsans2, $Q3, $hsans3);
                    $result1 = $stmt->execute();
                    if($result1)//no duplication in name 
                    {
                        $SELECT2 = "SELECT id From accountstaff Where username = '$username'";
                        $resultx = mysqli_query($conn, $SELECT2);
                        $row = mysqli_fetch_assoc($resultx);
                        $identifier = $row['id'];
    
                        $stmt->close();
                        $INSERT2 = "INSERT Into staff (id, staffName, position, birthdate, joinTime) values(?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($INSERT2);
                        $stmt->bind_param("sssss", $identifier, $name, $position, $birthDate, $joinTime);
                        $result2 = $stmt->execute();
                        $result3='true';
                        $result4='true';
                        $result5='true';
    
                        $stmt->close();
                        $conn->close();
                    } 
                    else{}
                }
                else 
                {
                    echo "<script>alert('Failed to insert the record, please try again! :-(' );</script>";
                    echo "<script> location.href= '$url1'; </script>"; 
                }    
            }           
            else
            {
                echo "<script>alert('This username already exists, please try another one! :-(');</script>";
                echo "<script> location.href= 'card_user_add.php?HCT=$type'; </script>"; 
                exit();
            }
        }
        else
        {
            echo "<script>alert('Please verify the password! :-(');</script>";
            echo "<script> location.href= 'card_user_add.php?HCT=$type'; </script>"; 
        }
    }
    else
    {
        echo "<script>alert('Failed to insert the record, please try again.:-(');</script>";
        echo "<script> location.href= '$url1'; </script>"; 
    }

    if($result1 && $result2 && $result3 && $result4 && $result5)
    {

        echo "<script>alert('New record inserted sucessfully! ☺');</script>";
        echo "<script> location.href= '$url1'; </script>"; 
    }
    else
    {
    echo "<script>alert('Failed to insert the record, please try again. Please make sure the info is applicable. The name might already exist. :-( ');</script>";
    echo "<script> location.href= 'card_user_add.php?HCT=$type'; </script>"; 
    }
}

?>