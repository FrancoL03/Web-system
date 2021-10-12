
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
        if(isset($_GET['afc']))
        {
            $SELECT_ALL_STAFF = "SELECT accountstaff.id, accountstaff.name, accountstaff.isAdmin, accountstaff.username, 
            accountstaff.password, staff.position, staff.birthdate, staff.joinTime 
            FROM accountstaff INNER JOIN staff ON accountstaff.id = staff.id";
        
            $SELECT_ALL_PAT= "SELECT accountresident.id, accountresident.name, accountresident.username, 
            accountresident.password, residents.birthdate, residents.joinTime 
            FROM accountresident INNER JOIN residents ON accountresident.id = residents.id";
            
            $func=$_GET['afc'];
            if($func=='MAS')
            {
                $title='Staff';
            }
            else if($func=='MAP')
            {
                $title='Resident';
            }
            else
            {
                echo "<script>alert('Error occurs. :-( ');</script>";
                echo "<script> location.href= 'admin_func_page.php'; </script>"; 
            }
            $_SESSION['searchType'] = $func; 
        }
        else{
            echo "<script>alert('Error occurs. :-( ');</script>";
            echo "<script> location.href= 'admin_func_page.php'; </script>"; 
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
        <title>Admin func</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_specific_record.css">
        <link rel="stylesheet" href="css/style_add_record.css" />  
        <link rel="stylesheet" href="bootstrap-3.3.6/dist/css/bootstrap.min.css" />  

        <script src="javascript/jquery-3.5.1.min.js"></script>
        <script src="javascript/bootstrap.min.js"></script>            
        <script src="javascript/jquery.tabledit.min.js"></script>

    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
            Modify Account Info of a <?php echo $title?> 
            </h4> 
        </header>
        <section class="section1">
            <div class="container" id="display1" style="width:1060px; height:360px; position:relative; top:20px; ">  
                <div class="tableHeader" >
                    <?php 
                        if(!isset($_GET['afts']))
                        {
                            echo 'Please search for the account you want to modify or delete';
                        }
                        else
                        {
                            echo 'Account info';
                        }
                    ?>
                </div>
                <div class="table-responsive" style="position:relative; bottom:5px;left:0px;">  
                    <?php 
                        if(isset($_GET['afts']))
                        {
                    ?>
                            <table id="editable_table" class="table table-bordered table-striped tableBodey">
                                    <thead>
                                        <tr>
                                            <?php 
                                                if($func=='MAS')
                                                {
                                            ?>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Administrator?</th>
                                                <th>Username</th>
                                                <th >Password</th>
                                                <th>Position</th>
                                                <th>Birthdate</th>
                                                <th>Join Time</th>
                                            <?php 
                                                }
                                            ?>    
                                            <?php 
                                                if($func=='MAP')
                                                {
                                            ?>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th >Password</th>
                                                <th>Birthdate</th>
                                                <th>Join Time</th>
                                            <?php 
                                                }
                                            ?>   
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if(isset($_GET['Total']))//view all accounts
                                            {
                                                if($func=='MAS')
                                                {
                                                    $SELECT = $SELECT_ALL_STAFF;
                                                }
                                                else if($func=='MAP')
                                                {
                                                    $SELECT = $SELECT_ALL_PAT;
                                                }
                                            }

                                            else if (isset($_SESSION['single_result'])) //search for single account
                                            {   
                                                $SELECT = $_SESSION['adminfunc_query'];
                                            }

                                            $result = mysqli_query($conn, $SELECT);
                                            while($row = mysqli_fetch_assoc($result))
                                            {
                                                if($func=='MAS')
                                                {
                                                    $_SESSION['action'] = 'MAS';
                                                    echo '
                                                    <tr>
                                                    <td style="-webkit-text-security: disc;">'.$row["id"].'</td>
                                                    <td>'.$row["name"].'</td>
                                                    <td>'.$row["isAdmin"].'</td>
                                                    <td>'.$row["username"].'</td>
                                                    <td style="-webkit-text-security: disc;">'.$row["password"].'</td>
                                                    <td>'.$row["position"].'</td>
                                                    <td>'.$row["birthdate"].'</td>
                                                    <td>'.$row["joinTime"].'</td>
                                                    </tr>
                                                    ';
                                                }
                                                if($func=='MAP')
                                                {
                                                    echo '
                                                    <tr>
                                                    <td style="-webkit-text-security: disc;">'.$row["id"].'</td>
                                                    <td>'.$row["name"].'</td>
                                                    <td>'.$row["username"].'</td>
                                                    <td style="-webkit-text-security: disc;">'.$row["password"].'</td>
                                                    <td>'.$row["birthdate"].'</td>
                                                    <td>'.$row["joinTime"].'</td>
                                                    </tr>
                                                    ';
                                                }
                                            }
                                            
                                        ?>
                                    </tbody>
                            </table>
                    <?php 
                        }
                    ?>
                    <?php 
                         if(!isset($_GET['afts']))
                         {
                    ?> 
                            <div class="formBlock" style="height:270px">
                                <form class="form" action="admin_func_search.php" method="POST" style="position:relative; top:20px;">
                                    <ul style="margin-bottom: 0px;">
                                        <li>
                                            <input type="text" name="username" class="field-style field-full align-left" placeholder="Search by username" required/>
                                        </li>
                                        <li>
                                            <input type="submit" value="Search"  />
                                        </li>
                                    </ul>
                                </form>
                                <div class="listBottom">
                                    <a href="specific_admin_func_page.php?afc=<?php echo $func?>&Total=ok&afts=yes">                
                                        <button type="button" class="btn-add" style="position:relative; top:5px;">View All the <?php echo $title?> Accounts</button>
                                    </a>
                                </div>
                            </div>
                    <?php 
                         }
                    ?> 
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
                    url:'editable_account_action.php',
                    columns:
                    {   
                        <?php 
                            if ($func=='MAS')
                            { $_SESSION['action'] = 'MAS';
                        ?>
                        identifier:[0, "id"],
                        editable:[[2, 'isAdmin'], [4, 'password'], [5, 'position'], [6, 'birthdate'], [7, 'joinTime']]
                        <?php 
                            }
                        ?>
                        <?php 
                            if ($func=='MAP')
                            { $_SESSION['action'] = 'MAP';
                        ?>
                        identifier:[0, "id"],
                        editable:[[3, 'password'], [4, 'birthdate'], [5, 'joinTime']]
                        <?php 
                            }
                        ?>
                    },
                    restoreButton:false,
                    dataType : 'json',
                    onSuccess: function(data, textStatus, jqXHR)
                    {   
                        if(data.isModified == "yes"){
                            alert('A record has been modified successfully! ☺');
                            if(data.action == 'delete')
                            {
                                $('#'+data.input["id"]).remove();
                            }
                        }
                        else{
                            alert('Failed to modify the record! please input the correct info. :-(');
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


