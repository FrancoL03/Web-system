
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
        if(isset($_GET['tsx']))
        {
            $taskID=$_GET['tsx'];
            $query = "SELECT * FROM taskinfo WHERE taskID = $taskID ";
            $result = mysqli_query($conn, $query);
            $type = 'Task';
        }
        else if(isset($_GET['api']))
        {
            $appoID=$_GET['api'];
            $query = "SELECT * FROM appointments WHERE id = $appoID ";
            $result = mysqli_query($conn, $query);
            $type = 'Appointment';
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
        <title><?php echo $type?> Details</title>
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
                <?php echo $type?> Details  
            </h4> 
        </header>
        <section class="section1">
            <div class="container" id="display1">  
                <div class="tableHeader" ><?php echo $type?> info</div>
                <div class="table-responsive" >  
                    <table id="editable_table" class="table table-bordered table-striped tableBodey">
                            <thead>
                                <tr>
                                    <?php 
                                        if($type=='Task')
                                        {
                                    ?>
                                        <th style="width:50px;">No.</th>
                                        <th style="width:50px;">Level</th>
                                        <th style="width:200px;">Title</th>
                                        <th style="width:300px;">Task Specification</th>
                                        <th style="width:130px;">Sequence Number</th>
                                    <?php 
                                        }
                                    ?>    
                                    <?php 
                                        if($type=='Appointment')
                                        {
                                    ?>
                                        <th style="width:50px;">ID</th>
                                        <th style="width:150px;">Resident Name</th>
                                        <th style="width:120px;">Staff Name</th>
                                        <th style="width:180px;">Theme</th>
                                        <th style="width:120px;">Category</th>
                                        <th style="width:125px;">Time</th>
                                        <th style="width:150px;">Comment</th>
                                        <th style="width:80px;">State</th>
                                    <?php 
                                        }
                                    ?>   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                        if($type=='Task')
                                        {
                                            echo '
                                            <tr>
                                            <td style="-webkit-text-security: disc;">'.$row["taskID"].'</td>
                                            <td>'.$row["level"].'</td>
                                            <td>'.$row["title"].'</td>
                                            <td>'.$row["content"].'</td>
                                            <td>'.$row["sequenceNum"].'</td>
                                            </tr>
                                            ';
                                            $_SESSION['pre_level'] = $row["level"];
                                            $_SESSION['pre_seqNum'] = $row["sequenceNum"];
                                            
                                        }
                                        if($type=='Appointment')
                                        {
                                            echo '
                                            <tr>
                                            <td style="-webkit-text-security: disc;">'.$row["id"].'</td>
                                            <td>'.$row["residentName"].'</td>
                                            <td>'.$row["staffName"].'</td>
                                            <td>'.$row["theme"].'</td>
                                            <td>'.$row["category"].'</td>
                                            <td>'.$row["time"].'</td>
                                            <td>'.$row["comment"].'</td>
                                            <td>'.$row["state"].'</td>
                                            </tr>
                                            ';
                                        }
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
                url:'editable_task_appo_action.php',
                columns:
                {
                    <?php 
                        if ($type=='Task')
                        { $_SESSION['action'] = 'tsx';
                    ?>
                    identifier:[0, "taskID"],
                    editable:[[2, 'title'], [3, 'content']] 
                    <?php 
                        }
                    ?>
                    <?php 
                        if ($type=='Appointment')
                        { $_SESSION['action'] = 'api';
                    ?>
                    identifier:[0, "id"],
                    editable:[[1, 'residentName'], [2, 'staffName'], [3, 'theme'], [4, 'category'], [5, 'time'], [6, 'comment'], [7, 'state']]
                    <?php 
                        }
                    ?>
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