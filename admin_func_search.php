<?php
session_start();
include_once('dbConn.php');

$type = $_SESSION['searchType'];
$type = str_replace("'", "", $type); 
$url1="personal_home_page.php";
if (mysqli_connect_error()) 
{
    echo 'Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error();
} 
else 
{
    $username=$_POST['username'];
    if($type=='MAS')
    {
        $SELECT = "SELECT username From accountstaff Where username = ? Limit 1";
    }
    else if($type=='MAP')
    {
        $SELECT = "SELECT username From accountresident Where username = ? Limit 1";
    }
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
        if($type=='MAS')//modify a staff
        { 
            $SELECT = "SELECT accountstaff.id, accountstaff.name, accountstaff.isAdmin, accountstaff.username, 
                        accountstaff.password, staff.position, staff.birthdate, staff.joinTime 
                        FROM accountstaff INNER JOIN staff ON accountstaff.id = staff.id WHERE username = '$username'";
            $result = mysqli_query($conn, $SELECT);
        }
        else if($type=='MAP')//modify a resident
        {
            $SELECT = "SELECT accountresident.id, accountresident.name, accountresident.username, 
                        accountresident.password, residents.birthdate,residents.joinTime 
                        FROM accountresident INNER JOIN residents ON accountresident.id = residents.id WHERE username = '$username'";
            $result = mysqli_query($conn, $SELECT);
        }
        else 
        {
            echo "<script>alert('The Search has failed, please try again! :-(' );</script>";
            echo "<script> location.href= 'specific_admin_func_page.php?afc=$type'; </script>"; 
            exit();
        }    
    }           
    else
    {
        echo "<script>alert('This username does not exists, please input a correct one! :-(');</script>";
        echo "<script> location.href= 'specific_admin_func_page.php?afc=$type'; </script>"; 
        exit();
    }
}
    
if($result)
{
    $_SESSION['single_result']='yes';
    $_SESSION['adminfunc_query']=$SELECT;
    echo "<script> location.href= 'specific_admin_func_page.php?afc=$type&afts=yes'; </script>";
    exit();
}
else
{
echo "<script>alert('The Search has failed, please try again! :-( ');</script>";
echo "<script> location.href= 'specific_admin_func_page.php?afc=$type'; </script>"; 
exit();
}

$stmt->close();
$conn->close();
?>
