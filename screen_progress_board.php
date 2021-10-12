
<!DOCTYPE html>
<?php
    session_start();
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
            <div class="container" style="background-color:rgb(255, 250, 240,0.8);">
                <div class="table-responsive" id="board_level01" style="background-color:rgba(231, 53, 91, 0.45); position:relative; top:6px;">  
                    <table id="editable_table1" class="table table-bordered table-striped tableBodey" style="table-layout: fixed;">
                    <?php 
                        $data = array();
                        while($row = mysqli_fetch_assoc($result1))
                        {
                            $data[] = $row;
                        }
                        $colNames = array_keys(reset($data));
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


                <div class="table-responsive" id="board_level02" style="background-color:rgba(53, 175, 231, 0.45); position:relative; top:10px;">  
                    <table id="editable_table2" class="table table-bordered table-striped tableBodey" style="table-layout: fixed;">
                        <?php 
                            $data = array();
                            while($row = mysqli_fetch_assoc($result2))
                            {
                                $data[] = $row;
                            }
                            $colNames = array_keys(reset($data));
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

                <div class="table-responsive" id="board_level03" style="background-color:hsla(64, 100%, 52%, 0.45); position:relative; top:15px; bottom:5%;">  
                    <table id="editable_table3" class="table table-bordered table-striped tableBodey" style="table-layout: fixed;">
                        <?php 
                            $data = array();
                            while($row = mysqli_fetch_assoc($result3))
                            {
                                $data[] = $row;
                            }
                            $colNames = array_keys(reset($data));
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
            </div>  
            
        </section>
        
        <footer>
            <p id="footerText" style="margin-top:4px;font-weight: lighter; font-family:'Times New Roman', Arial, Helvetica, sans-serif, Times, serif;" >
                De Spiegel
            </p>
        </footer>

    </body>
</html>
<script type="text/javascript">
 
 $(document).ready(function(){
 	for(var i=1;i<4;i++)
 	{
 		var theid = $("#board_level0"+i);
 		var thetime = 400 *i;
 		$(theid).slideDown(thetime); 
 	}
 });

</script>

