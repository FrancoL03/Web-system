<?php
session_start();
include_once('dbConn.php');

$url1="progress_board.php";

if (mysqli_connect_error()) 
{
    echo 'Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error();
} 
else 
{
    $name = $_POST['name'];
    $sequenceNum = $_POST['sequenceNum'];
    $taskState = $_POST['taskState'];
    $taskLevel = $_POST['taskLevel'];

    if($taskLevel=='level01') //insert into the progress table 
    {  
        $INSERT = "UPDATE progresslevel01 SET $name = '$taskState' WHERE sequenceNum = '$sequenceNum';";
        mysqli_query($conn, $INSERT);
        $result = mysqli_affected_rows($conn);
    }
    else if($taskLevel=='level02')
    {
        $INSERT = "UPDATE progresslevel02 SET $name = '$taskState' WHERE sequenceNum = '$sequenceNum';";
        mysqli_query($conn, $INSERT);
        $result = mysqli_affected_rows($conn);
    }
    else if($taskLevel=='level03')
    {
        $INSERT = "UPDATE progresslevel03 SET $name = '$taskState' WHERE sequenceNum = '$sequenceNum';";
        mysqli_query($conn, $INSERT);
        $result = mysqli_affected_rows($conn);
    }
    mysqli_close($conn);

    if($result==1)
    {
        echo "<script>alert('Progress has been modified sucessfully! ☺');</script>";
        echo "<script> location.href= '$url1'; </script>"; 
    }
    else
    {
    echo "<script>alert('Failed to modify the progress, please input the correct info. :-( ');</script>";
    echo "<script> location.href= '$url1'; </script>"; 
    }
}
?>
