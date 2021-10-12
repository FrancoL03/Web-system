<?php
session_start();
include_once('dbConn.php');

$url1="appo_list_page.php";

if (mysqli_connect_error()) 
{
    echo 'Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error();
} 
else 
{
    $residentName = $_POST['residentName'];
    $staffName = $_POST['staffName'];
    $theme = $_POST['theme'];
    $category = $_POST['category'];
    $time = $_POST['time'];
    $comment = $_POST['comment'];
    $state='normal';

    $INSERT = "INSERT INTO appointments (residentName, staffName, theme, category, time, comment, state) values(?, ?, ?, ?, ?, ?, ?)";
    //Prepare statement
    $stmt = $conn->prepare($INSERT);
    $stmt->bind_param("sssssss", $residentName, $staffName, $theme, $category, $time ,$comment, $state);
    $result = $stmt->execute(); 
    
    if($result)
    {
        echo "<script>alert('A new Appointment has been inserted sucessfully! ☺');</script>";
        echo "<script> location.href= '$url1'; </script>"; 
    }
    else
    {
    echo "<script>alert('Failed to insert the record, please make sure the resident and staff exist!:-( ');</script>";
    echo "<script> location.href= '$url1'; </script>"; 
    }
}
$stmt->close();
$conn->close();
?>