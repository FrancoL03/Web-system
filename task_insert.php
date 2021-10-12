<?php
session_start();
include_once('dbConn.php');

$url1="task_list_page.php";

if (mysqli_connect_error()) 
{
    echo 'Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error();
} 
else 
{
    $level = $_POST['level'];
    $content = $_POST['content'];
    $sequenceNum = $_POST['sequenceNum'];
    $theme = $_POST['theme'];


    $INSERT = "INSERT INTO taskinfo (level, title, content, sequenceNum) values(?, ?, ?, ?)";
    //Prepare statement
    $stmt = $conn->prepare($INSERT);
    $stmt->bind_param("ssss", $level, $theme, $content, $sequenceNum);
    $result1 = $stmt->execute(); 

    if ($result1) 
    {
        if($level=='01') //insert into the progress table 
        {  
            $INSERT = "INSERT INTO progresslevel01 (sequenceNum, theme) VALUES ('$sequenceNum', '$theme') ";
            $result2 = mysqli_query($conn, $INSERT);
        }
        else if($level=='02')
        {
            $INSERT = "INSERT INTO progresslevel02 (sequenceNum, theme) VALUES ('$sequenceNum', '$theme') ";
            $result2 = mysqli_query($conn, $INSERT);
        }
        else if($level=='03')
        {
            $INSERT = "INSERT INTO progresslevel03 (sequenceNum, theme) VALUES ('$sequenceNum', '$theme') ";
            $result2 = mysqli_query($conn, $INSERT);
        }
    }


    if($result1 && $result2)
    {
        echo "<script>alert('A new task has been inserted sucessfully! ☺');</script>";
        echo "<script> location.href= '$url1'; </script>"; 
    }
    else
    {
    echo "<script>alert('Failed to insert the record, please input the correct info. Note that sequence number cannot be duplicate. :-( ');</script>";
    echo "<script> location.href= '$url1'; </script>"; 
    }
}
$stmt->close();
$conn->close();
?>