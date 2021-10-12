<?php  

session_start();
include_once('dbConn.php');

$input = filter_input_array(INPUT_POST);
$action = $_SESSION['action'];
$action = str_replace("'", "", $action);
$pre_seqNum = $_SESSION['pre_seqNum']; 
$pre_level = $_SESSION['pre_level'];

if($action=='tsx')
{
    $title = mysqli_real_escape_string($conn, $input["title"]);
    $content = mysqli_real_escape_string($conn, $input["content"]);

    if($input["action"] === 'edit')
    {
        //change the column name in progress table
        if($pre_level=='01') 
        {  
            $INSERT = "UPDATE progresslevel01 SET theme = '$title'  
                        WHERE sequenceNum = '$pre_seqNum' ";        
            $result1 = mysqli_query($conn, $INSERT);
        }
        else if($pre_level=='02')
        {
            $INSERT = "UPDATE progresslevel02 SET theme = '$title'  
                        WHERE sequenceNum = '$pre_seqNum' ";    
            $result1 = mysqli_query($conn, $INSERT);
        }
        else if($pre_level=='03')
        {
            $INSERT = "UPDATE progresslevel03 SET theme = '$title'  
                        WHERE sequenceNum = '$pre_seqNum' ";  
            $result1 = mysqli_query($conn, $INSERT);
        }
        else if($pre_level=='04')
        {
            $INSERT = "UPDATE progresslevel04 SET theme = '$title'  
                        WHERE sequenceNum = '$pre_seqNum' ";  
            $result1 = mysqli_query($conn, $INSERT);
        }

        $query = "
        UPDATE taskinfo 
        SET title = '".$title."',
        content = '".$content."'
        WHERE taskID = '".$input["taskID"]."'
        ";

        $result2 = mysqli_query($conn, $query);

    }

    if($input["action"] === 'delete')
    {

        if($pre_level=='01') 
        {  
            $INSERT = "DELETE FROM progresslevel01 WHERE sequenceNum = '$pre_seqNum' ";
            $result1 = mysqli_query($conn, $INSERT);
        }
        else if($pre_level=='02')
        {
            $INSERT = "DELETE FROM progresslevel02 WHERE sequenceNum = '$pre_seqNum' ";
            $result1 = mysqli_query($conn, $INSERT);
        }
        else if($pre_level=='03')
        {
            $INSERT = "DELETE FROM progresslevel03 WHERE sequenceNum = '$pre_seqNum' ";
            $result1 = mysqli_query($conn, $INSERT);
        }
        else if($pre_level=='04')
        {
            $INSERT = "DELETE FROM progresslevel04 WHERE sequenceNum = '$pre_seqNum' ";
            $result1 = mysqli_query($conn, $INSERT);
        }

        $query = "
        DELETE FROM taskinfo
        WHERE taskID = '".$input["taskID"]."'
        ";
        $result2 = mysqli_query($conn, $query);
        
        //delete the task column in progress table
    }
}
else if($action=='api')
{
    $residentName = mysqli_real_escape_string($conn, $input["residentName"]);
    $staffName = mysqli_real_escape_string($conn, $input["staffName"]);
    $theme = mysqli_real_escape_string($conn, $input["theme"]);
    $category = mysqli_real_escape_string($conn, $input["category"]);
    $time = mysqli_real_escape_string($conn, $input["time"]);
    $comment = mysqli_real_escape_string($conn, $input["comment"]);
    $state = mysqli_real_escape_string($conn, $input["state"]);

    if($input["action"] === 'edit')
    {
    $query = "
    UPDATE appointments 
    SET residentName = '".$residentName."', 
    staffName = '".$staffName."',
    theme = '".$theme."',
    category = '".$category."',
    time = '".$time."',
    comment = '".$comment."',
    state = '".$state."'
    WHERE id = '".$input["id"]."'
    ";

    $result1 = mysqli_query($conn, $query);

    }
    if($input["action"] === 'delete')
    {
    $query = "
    DELETE FROM appointments
    WHERE id = '".$input["id"]."'
    ";
    $result1 = mysqli_query($conn, $query);
    }
    $result2 = 'true';
}

if($result1 && $result2)
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
