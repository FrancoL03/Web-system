<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

if (!empty($username) || !empty($password) ) 
{
    
    include_once('dbConn.php');
    if (mysqli_connect_error()) 
    {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } 


    $SELECT = "select password from accountstaff where username= '$username' limit 1";
    $result = mysqli_query($conn, $SELECT);
    $row = mysqli_fetch_array($result);
    if(!isset($row['password']))
    {
        $url2="login_page.php";
        echo "<script>alert('Username or password is incorrect, please try again.');</script>";
        echo "<script> location.href= '$url2'; </script>"; 
        exit();
    }
    else 
    {
        $hashedPwInDb = $row['password'];
        $ifCorrect = password_verify($password, $hashedPwInDb); 
    }
    if($ifCorrect==1)
    {
        $_SESSION['startTime'] = time(); 
        $_SESSION['expireTime'] = $_SESSION['startTime'] + (60 * 60);//session will expire after a certain time.
        $_SESSION['username'] = $username;
        $url1="personal_home_page.php";
        echo "<script>alert('Login successfully.');</script>";
        echo "<script> location.href= '$url1'; </script>"; 
        exit();
    }
    else
    {
        $url2="login_page.php";
        echo "<script>alert('Username or password is incorrect, please try again.');</script>";
        echo "<script> location.href= '$url2'; </script>"; 
        exit();
    }   
    $stmt->close();
    $conn->close();

} 
else 
{
 echo "All field are required";
 die();
}
?>