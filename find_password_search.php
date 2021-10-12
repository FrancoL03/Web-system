<?php
session_start();
include_once('dbConn.php');

if (mysqli_connect_error()) 
{
    echo 'Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error();
} 
else 
{
    if($_POST['action']=='search')
    {
        $username=$_POST['username'];
        $_SESSION['the_username'] = $username ;
        $SELECT = "SELECT username From accountstaff Where username = ? Limit 1";
        
        //Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        $stmt->close();
    
        if ($rnum==1) //username exists
        {

            $SELECT = "SELECT question1, answer1, question2, answer2, question3, answer3 From accountstaff Where username = '$username' ";
            $result = mysqli_query($conn, $SELECT);
            $row = mysqli_fetch_assoc($result);
            $question1 = $row["question1"];
            $question2 = $row["question2"];
            $question3 = $row["question3"];
            $answer1 = $row["answer1"];
            $answer2 = $row["answer2"];
            $answer3 = $row["answer3"];

        }           
        else
        {
            echo "<script>alert('This username does not exists, please input a correct one! :-(');</script>";
            echo "<script> location.href= \"javascript:history.go(-1)\"; </script>"; 
            exit();
        }

        if($result)
        {
            $_SESSION['question1'] = $question1;
            $_SESSION['question2'] = $question2;
            $_SESSION['question3'] = $question3;
            $_SESSION['answer1'] = $answer1;
            $_SESSION['answer2'] = $answer2;
            $_SESSION['answer3'] = $answer3;

            echo "<script> location.href= 'find_password_page.php?afts=yes'; </script>";
            exit();
        }
        else
        {
        echo "<script>alert('The Search has failed, please try again! :-( ');</script>";
        echo "<script> location.href= \"javascript:history.go(-1)\"; </script>"; 
        exit();
        }

        $stmt->close();
        $conn->close();
    }

    else if($_POST['action']=='confirm') //the page for answers 
    {   
        $ans1 = $_POST['answer1'];
        $ans2 = $_POST['answer2'];
        $ans3 = $_POST['answer3'];

        $ifCorrect1 = password_verify($ans1, $_SESSION['answer1']); 
        $ifCorrect2 = password_verify($ans2, $_SESSION['answer2']); 
        $ifCorrect3 = password_verify($ans3, $_SESSION['answer3']); 

        if($ifCorrect1 && $ifCorrect2 && $ifCorrect3)
            
        {
            echo "<script>alert('Answers are correct!☺ Please reset your password now.');</script>";

            $_SESSION['ifAnsOk'] = 'yes';
            echo "<script> location.href= 'find_password_page.php?afts=yes'; </script>";
        }  
        else 
        {
            echo "<script>alert('Answers are not fully correct, please try again. :-(');</script>";
            echo "<script> location.href= \"javascript:history.go(-1)\"; </script>"; 
        }  
    }
    
}
    
?>
