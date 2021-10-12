
<!DOCTYPE html>
<?php
    session_start();
    $now = time();
    $url1="login_page.php";

    if (!isset($_SESSION['expireTime']) or !isset($_SESSION['username'])) {
        session_destroy();
        echo "<script>alert('Invalid access! Please login first.');</script>";
        echo "<script> location.href= '$url1'; </script>"; 
    }
    else if ($now > $_SESSION['expireTime']){
        session_destroy();
        echo "<script>alert('Your Login has expired! Please login again.');</script>";
        echo "<script> location.href= '$url1'; </script>"; 
    }
    else{
        include_once('dbConn.php');
        
        if(!isset($_GET['rpx'])){
            $cardID=$_GET['rtx'];
            $query = "SELECT * FROM cards WHERE id = $cardID ";
            $result = mysqli_query($conn, $query);
        }
        else if(!isset($_GET['rtx'])){
            $pName=$_GET['rpx'];
            $query = "SELECT * FROM cards WHERE residentName = '$pName' ORDER BY id ASC";
            $result = mysqli_query($conn, $query);
        }
        else{
            echo "<script>alert('Error occurs. :-( ');</script>";
        }
    }
    
?>
<style>
.container{
    display:none;
}    
</style>
<html>
    <head>
        <title>Card Details</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_specific_record.css">
        <link rel="stylesheet" href="bootstrap-3.3.6/dist/css/bootstrap.min.css" />  

        <script src="javascript/jquery-3.5.1.min.js"></script>
        <script src="javascript/bootstrap.min.js"></script>            
        <script src="javascript/jquery.tabledit.min.js"></script>
    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
            Card Details 
            </h4> 
        </header>
        <section class="section1">
            <div class="container" id="display1">  
                <div class="tableHeader" >Card info</div>
                <div class="table-responsive">  
                    <table id="editable_table" class="table table-bordered table-striped tableBodey">
                            <thead>
                                <tr>
                                        <th style="width:50px; ">No.</th>
                                        <th style="width:130px;">Resident Name</th>
                                        <th style="width:110px;">Card Type</th>
                                        <th style="width:150px; ">Cause</th>
                                        <th style="width:110px;">Given By</th>
                                        <th style="width:110px;">Moment</th>
                                        <th style="width:150px;">comment</th>
                                        <th style="width:50px;">Validity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            echo '
                                            <tr>
                                            <td style="-webkit-text-security: disc;">'.$row["id"].'</td>
                                            <td>'.$row["residentName"].'</td>
                                            <td>'.$row["cardType"].'</td>
                                            <td>'.$row["cause"].'</td>
                                            <td>'.$row["givenBy"].'</td>
                                            <td>'.$row["time"].'</td>
                                            <td>'.$row["comment"].'</td>
                                            <td>'.$row["isValid"].'</td>
                                            </tr>
                                            ';
                                        }
                                ?>
                            </tbody>
                    </table>
                </div>  
            </div>  
        </section>

        <footer>
            <p id="footerText" style="margin-top:4px;font-weight: lighter;" >
                <a href = "personal_home_page.php"  style="text-decoration: none; font-weight:inherit; font-family:'Times New Roman'; font-size:inherit; color:inherit;">    
                    Go to The Home Page                        
                </a>  
            </p>
        </footer>

    </body>
</html>
<script>  
$(document).ready
    (function()
    {   

        $('#editable_table').Tabledit
        ({
                url:'editable_card_action.php',
                columns:
                {
                    identifier:[0, "id"],
                    editable:[[2, 'cardType'], [3, 'cause'], [4, 'givenBy'], [5, 'time'], [6, 'comment'], [7, 'isValid']]
                },
                restoreButton:false,
                dataType : 'json',
                onSuccess:function(data, textStatus, jqXHR)
                {   
                    if(data.isModified == "yes"){
                        alert('A record has been modified successfully! ☺');
                        if(data.action == 'delete')
                        {
                            $('#'+data.input["id"]).remove();
                        }
                    }
                    else{
                        alert('Failed to modify the record! Please make sure the name is correct. :-(');
                    }
                    location.reload();
                }
        });
    });  
 </script>

 <script type="text/javascript">
 
 $(document).ready(function(){

 		var theid = $("#display1");
 		var thetime = 800 *1;
 		$(theid).fadeIn(thetime); 

 });

</script>