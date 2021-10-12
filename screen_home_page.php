
<!DOCTYPE html>

<style>
.lineblock{
    border-radius: 10px;

    margin:auto;
    margin-top:20px;
    width: 800px;
    height: 250px;
    text-align: center;
}
.sblock{
    width:200px;
    height:200px;
    margin-top: 10px;
    margin-left: 20px;
    margin-right: 20px;
    text-align: center;
    text-transform: uppercase; 
    margin-bottom: 0px;
    display:inline-block;
    transition: 0.6s;
}   
.sblock img{
    height:180px;
    width:180px;
    background:white;
    border: 3px solid black;
    border-width: 0 3px 3px 0;
    border-color:rgb(76, 70, 107);
    border-radius: 15%;
    box-shadow: gray 3px 3px 10px;
    position: center;
    transition: 0.6s;
}
.sblock p{
    width:180px;
    margin:auto;
    font-weight: bold;
    font-size:18px; 
    font-family: Arial, Helvetica, sans-serif;
    color: rgb(10, 10, 10);
    text-transform: capitalize;
    position: relative;
    left: 0px;
}
</style>
<style>

.lineblock{
    display:none;   
}
.sblock:hover {
    transform: scale(1.1);
    z-index: 2;
  }
  .sblock img:hover{
    box-shadow: 0 0 10px #1070ff;
  }


</style>
<html>
    <head>
        <title>Central Screen</title>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
        <link rel="stylesheet" href="css/style_list_view.css">
        <script src="javascript/jquery-3.5.1.min.js"></script>
    </head>

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
                Central Screen 
            </h4>
        </header>
        <section class="section1">
            <div class="container"  style="width:1000px; height:400px; position:relative; top:0px">
                <div class="listHeader" style="width:800px">
                    <img src="images/logos_icons/de_spiegel_logo.png" style="height:60px; width:60px;" alt="notebook">
                </div>
                <div class="listBlock" style="height:300px" >
                    <div class = "lineblock" id="display1">
                        <div class="sblock" style="position:relative; left:-50px;">
                            <a href="screen_progress_board.php">
                                <img src="images/logos_icons/progress_icon.png" alt="avatar">
                            </a>    
                            <p>Progress Board</p>
                        </div>
                        <div class="sblock" style="position:relative; left:50px;">
                            <a href="screen_card_list.php">
                                <img src="images/logos_icons/red_yellow_card_icon.png" alt="avatar">
                            </a>    
                            <p>Red/Yellow Cards</p>
                        </div>
                    </div class = "lineblock">
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
    for(var i=1;i<3;i++)
 	{
 		var theid = $("#display"+i);
 		var thetime = 800 *i;
 		$(theid).fadeIn(thetime); 
 		thetime = thetime * i;
 	}
 });


</script>