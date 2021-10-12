
<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
        <link rel="stylesheet" href="/css/style_login.css">
        <link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/all.css"> <!-- for icons -->
        <script src="javascript/jquery-3.5.1.min.js"></script>
        <link rel="shortcut icon" typr="image/png" href="images/logos_icons/de_spiegel_favicon.png">
    </head>
    <script>
    </script>    

    <body>
        <header>
            <h4 id="footerText" style="margin-top:3px;" >
                Central Login
            </h4>
        </header>

        <section class="section1">
            <div class = "leftHalf">
                
                    <figure>
                        <img src="images/logos_icons/de_spiegel_logo.png" alt="logo" >
                        <figcaption>
                            <strong>                    
                            <a href="screen_home_page.php" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px;">Central Screen</a>
                            </strong>
                        </figcaption>
                    </figure>
                
            </div>
            
            <div class="rightHalf">

                <div class = "bar">
                </div>
                
                    <div class="container">
                        <img src="images/avatars/avatar_login.PNG"/>
                        <form action="login_insert.php" method="POST">
                            <div class="form-input div_username">
                                <i class="fa fa-user icon"></i>
                                <input class="input_username" type="text" name="username" placeholder="Username"  required/> 
                            </div>
                            <div class="form-input div_password">
                                <i class="fa fa-key icon"></i>
                                <input class="input_password" type="password" name="password" placeholder="Password" required/>
                            </div>
                                <button type="submit" class="btn-login">LOGIN</button>
                        </form>
                    </div>
                    <a href="find_password_page.php" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px;">Forget password?</a>
                
            </div>
        </section>
        <footer>
            <p id="footerText" style="margin-top:6px;font-weight: lighter;" >
                De Spiegel, Pellenbergstraat 160, 3010 Leuven 
            </p>
        </footer>

    </body>

</html>
<script>

    $('input').focus( // border
    function(){
        $(this).parent('div').css('border-color','rgb(8,167,235)');
    }).blur(
    function(){
        $(this).parent('div').css('border-color','rgb(46, 89, 155)');
    });

</script>