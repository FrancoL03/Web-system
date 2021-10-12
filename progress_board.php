
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

        $query1 = "SELECT * FROM progresslevel01";
        $query2 = "SELECT * FROM progresslevel02";
        $query3 = "SELECT * FROM progresslevel03";

        $result1= mysqli_query($conn, $query1);
        $result2 = mysqli_query($conn, $query2);
        $result3 = mysqli_query($conn, $query3);

        function printHeaders($colNames){
            foreach($colNames as $colName)
            {
                if ($colName == 'id')
                {
                    echo "<th style='text-align:center; width:50px; border:2px solid grey; font-size:18; font-weight:bold;'>ID</th>";
                }
                else if ($colName == 'sequenceNum')
                {
                    echo "<th style='text-align:center; width:150px; border:2px solid grey; font-size:18; font-weight:bold;'>Sequence Number</th>";
                }
                else if ($colName == 'theme')
                {
                    echo "<th style='text-align:center; width:200px; border:2px solid grey; font-size:18; font-weight:bold;'>Task Theme</th>";
                }
                else 
                {
                    echo "<th style='text-align:center; width:80px; border:2px solid grey; font-size:18; font-weight:bold;'>$colName</th>";
                }
            }
        }
        function printRows($data,$colNames) {
            $i = 1;
            foreach($data as $row)
            {
                echo "<tr>";
                foreach($colNames as $colName)
                {
                    if($colName != 'id')
                    {
                    echo "<td style='text-align:center; '>".$row[$colName]."</td>";
                    }
                    else{
                    echo "<td style='text-align:center; '>".$i."</td>";
                    }
                }
                echo "</tr>";
                $i = $i+1;
            }
        }
    }
?>

<html>
    <head>
        <title>Progress Board</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_all_progress.css">
        <link rel="stylesheet" href="bootstrap-3.3.6/dist/css/bootstrap.min.css" />  

        <script src="javascript/jquery-3.5.1.min.js"></script>
        <script src="javascript/bootstrap.min.js"></script>            
        <script src="javascript/jquery.tabledit.min.js"></script>
    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
            Current Progress Board
            </h4> 
        </header>
        <section class="section1">
            <div class="container">
                <div class="table-responsive" id="board_level01" style="background-color:rgba(231, 53, 91, 0.45);">  
                    <table id="editable_table1" class="table table-bordered table-striped tableBodey" style="table-layout: fixed;";>
                    <?php 
                        $data = array();
                        while($row = mysqli_fetch_assoc($result1))
                        {
                            $data[] = $row;
                        }
    
                        $colNames = array_keys(reset($data))
                    ?>

                        
                        <tr>
                            <?php
                                //print the header
                                printHeaders($colNames);
                            ?>
                        </tr>

                            <?php
                                //print the rows
                                printRows($data, $colNames);
                            ?>
                    </table>
                </div>  


                <div class="table-responsive" id="board_level02" style="background-color:rgba(53, 175, 231, 0.45);">  
                    <table id="editable_table2" class="table table-bordered table-striped tableBodey" style="table-layout: fixed;">
                        <?php 
                            $data = array();
                            while($row = mysqli_fetch_assoc($result2))
                            {
                                $data[] = $row;
                            }
        
                            $colNames = array_keys(reset($data))
                        ?>

                        <tr>
                            <?php
                                //print the header
                                printHeaders($colNames);
                            ?>
                        </tr>

                        <?php
                            //print the rows
                            printRows($data, $colNames);
                        ?>       
                    </table>
                </div> 

                <div class="table-responsive" id="board_level03" style="background-color:hsla(64, 100%, 52%, 0.45);">  
                    <table id="editable_table3" class="table table-bordered table-striped tableBodey" style="table-layout: fixed;">
                        <?php 
                            $data = array();
                            while($row = mysqli_fetch_assoc($result3))
                            {
                                $data[] = $row;
                            }
        
                            $colNames = array_keys(reset($data))
                        ?>

                        <tr>
                            <?php
                                //print the header
                                printHeaders($colNames);
                            ?>
                        </tr>

                        <?php
                            //print the rows
                            printRows($data, $colNames);
                        ?>
                    </table>
                </div> 
                <div class="listBottom" id="board_level04">
                    <a href="progress_modify_page.php">                
                        <button type="button" class="btn-add" style="position:relative; top:3px;">Modify the Progress</button>
                    </a>
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
<script type="text/javascript">
 
 $(document).ready(function(){
 	for(var i=1;i<5;i++)
 	{
 		var theid = $("#board_level0"+i);
 		var thetime = 800 *i;
 		$(theid).show(thetime); 
 		thetime = thetime * i;
 	}
 });

</script>

