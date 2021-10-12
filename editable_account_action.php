<?php  

session_start();
include_once('dbConn.php');

$input = filter_input_array(INPUT_POST);
$action = $_SESSION['action'];
$action = str_replace("'", "", $action); 

$password = mysqli_real_escape_string($conn, $input["password"]);
$birthdate = mysqli_real_escape_string($conn, $input["birthdate"]);
$joinTime = mysqli_real_escape_string($conn, $input["joinTime"]);


if($action=='MAS')
{
    $isAdmin = mysqli_real_escape_string($conn, $input["isAdmin"]);
    $position = mysqli_real_escape_string($conn, $input["position"]);

    if($input["action"] === 'edit')
    {
        $query1 = "
        UPDATE staff 
        SET 
        position = '". $position."',   
        birthdate = '".$birthdate."', 
        joinTime = '".$joinTime."'
        WHERE id = '".$input["id"]."'
        ";
        $result1 = mysqli_query($conn, $query1);

        if(strlen($password) < 25) //max lengthe of pw
        {
            $hashedPwInDb = password_hash($password, PASSWORD_DEFAULT); 
            $query2 = "
            UPDATE accountstaff 
            SET 
            isAdmin = '".$isAdmin."',
            password = '".$hashedPwInDb."'
            WHERE id = '".$input["id"]."'
            ";
        }
        else
        {
            $query2 = "
            UPDATE accountstaff 
            SET 
            isAdmin = '".$isAdmin."'
            WHERE id = '".$input["id"]."'
            ";
        }
        $result2 = mysqli_query($conn, $query2);

    }
    if($input["action"] === 'delete')
    {
        $query1 = "
        DELETE FROM staff 
        WHERE id = '".$input["id"]."'
        ";
        $result1 = mysqli_query($conn, $query1);

        $query2 = "
        DELETE FROM accountstaff 
        WHERE id = '".$input["id"]."'
        ";
        $result2 = mysqli_query($conn, $query2);
        
    }
}
else if($action=='MAP')
{
    if($input["action"] === 'edit')
    {
        $query1 = "
        UPDATE residents
        SET 
        birthdate = '".$birthdate."', 
        joinTime = '".$joinTime."'
        WHERE id = '".$input["id"]."'
        ";
        $result1 = mysqli_query($conn, $query1);

        if(strlen($password) < 25)
        {
            $hashedPwInDb = password_hash($password, PASSWORD_DEFAULT); 
            $query2 = "
            UPDATE accountresident
            SET 
            password = '".$hashedPwInDb."'
            WHERE id = '".$input["id"]."'
            ";
            $result2 = mysqli_query($conn, $query2);
        }
        else
        {
            $result2 = 'true';
        }    
    }
    if($input["action"] === 'delete')
    {
        //delete from the progress board
        $query = "
        SELECT residentName FROM residents
        WHERE id = '".$input["id"]."'
        ";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $columnName = $row['residentName'];


        $query = "ALTER TABLE progresslevel01 DROP COLUMN $columnName ";
        mysqli_query($conn, $query);
        $query = "ALTER TABLE progresslevel02 DROP COLUMN $columnName ";
        mysqli_query($conn, $query);
        $query = "ALTER TABLE progresslevel03 DROP COLUMN $columnName ";
        mysqli_query($conn, $query);

        $query1 = "
        DELETE FROM residents 
        WHERE id = '".$input["id"]."'
        ";
        mysqli_query($conn, $query1);

        $query2 = "
        DELETE FROM accountresident
        WHERE id = '".$input["id"]."'
        ";
        mysqli_query($conn, $query2);
        $result2 = 'true';

    }
}
if($result1 && $result2 )
{
    $isModified = 'yes';
}
else
{
    $isModified = 'no';
}
$json = array();
$json['isModified'] = $isModified;
$json['input'] = $input;
echo json_encode($json);

?>
