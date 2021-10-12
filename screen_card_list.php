
<!DOCTYPE html>
<?php
    session_start();

    include_once('dbConn.php');
    $query="SELECT * from cards";
    $result = mysqli_query($conn, $query);
?>
<style>
.container{
    display:none;
}    
</style>
<html>
    <head>
        <title>Card Page</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_list_view.css">
        <script src="javascript/jquery-3.5.1.min.js"></script>
    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
                Card List 
            </h4>
        </header>
        <section class="section1">
            <div class="container" id="display1">
                <div class="listHeader">
                    <img src="images/logos_icons/red_yellow_card_icon.png" alt="notebook">
                </div>
                <div class="listBlock">
                    <?php
                        while($row = mysqli_fetch_assoc($result))
                        {
                    ?>
                    <div class = "singleRecord" >
                        <p class="tooltip" style="font-weight:bold;">
                                (<?php echo $row['cardType']; ?>) 
                                <?php echo $row['residentName']; ?>: <?php echo $row['cause']; ?>                            
                            <span class="tooltiptext"><?php echo $row['time']; ?></span>               
                        </p>
                    </div>   
                    <?php
                        }
                    ?>
                </div>
            </div>

        </section>

        <footer>
            <p id="footerText" style="margin-top:6px;font-weight: lighter;" >
                De Spiegel
            </p>
        </footer>

    </body>
</html>

<script type="text/javascript">
 
 $(document).ready(function(){

 		var theid = $("#display1");
 		var thetime = 800 *1;
 		$(theid).fadeIn(thetime); 

 });

</script>