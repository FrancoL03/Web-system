<?php  

include_once('dbConn.php');

$input = filter_input_array(INPUT_POST);

$cardType = mysqli_real_escape_string($conn, $input["cardType"]);
$cause = mysqli_real_escape_string($conn, $input["cause"]);
$givenBy = mysqli_real_escape_string($conn, $input["givenBy"]);
$moment = mysqli_real_escape_string($conn, $input["time"]);
$comment = mysqli_real_escape_string($conn, $input["comment"]);
$validity = mysqli_real_escape_string($conn, $input["isValid"]);


if($input["action"] === 'edit')
{
    $query = "
    UPDATE cards 
    SET cardType = '".$cardType."',
    cause = '".$cause."',
    givenBy = '".$givenBy."',
    time = '".$moment."',
    comment = '".$comment."', 
    isValid = '".$validity."' 
    WHERE id = '".$input["id"]."'
    ";

    $result = mysqli_query($conn, $query);
 
}
if($input["action"] === 'delete')
{
    $query = "
    DELETE FROM cards 
    WHERE id = '".$input["id"]."'
    ";
    $result = mysqli_query($conn, $query);
}
if($result)
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
