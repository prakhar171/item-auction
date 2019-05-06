<?php  
    
    session_start();
    include("functions/functions.php");

?>


<!doctype html>
<!--[if IE 9]> <html class="no-js ie9 fixed-layout" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js " lang="en"> <!--<![endif]-->
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-126695806-1"></script>


    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Site Meta -->
    <title>Decent Auction</title>
    <meta name="keywords" content="">
    
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700,900" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,400i,700,700i" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:800" rel="stylesheet">
    
    <!-- Custom & Default Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/carousel.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="style.css">
    <script src="js/jquery.min.js"></script>

    
</head>
<body>

    <?php include 'navbar.php'; ?>

<script type="text/javascript">
    if ( $(window).width() > 767){
    var element = document.getElementById("head");
    element.classList.remove("header-normal");
    }

</script>

<style type="text/css">
    #brand{
        display: none;
    }
</style>

        <!-- Modal -->
        
        <script type="text/javascript">
            $(document).ready(function () {
                $('#mainlogo').fadeIn(2000);
                $('#mainmsg').fadeIn(2000);
                $('#mainexp').fadeIn(6000);
            });
        </script>

        <section id="home" class="video-section js-height-full" style="background-image: url(images/home_bg.jpg)">
            <div class="overlay"></div>
            </br>
            </br>
            <div class="home-text-wrapper relative container">
                <div class="home-message">
                    <h1 style="font-size: 100px; color: white; font-family: Open Sans;" class="text-responsive">Decent Auction</h1>
                    </br>
                    </br>
                    </br>
                    <!-- <p style="font-family: 'Open Sans', sans-serif;">UNIFORM APPLICATION</p> -->
                    <small id="mainmsg" style=" display:none; font-size: 26px; color: rgb(255,255,255,1);">A Secure and Verifiable Auction on the Blockchain</small> 
                </div>
            </div>
            
        </section>


        

    <!-- jQuery Files -->

    <script src="js/bootstrap.min.js"></script>
    <script src="js/carousel.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/custom.js"></script>
    <!-- VIDEO BG PLUGINS -->
    <script type="text/javascript">
        function scroller(){
            $('html, body').animate({
            scrollTop: $("#usp").offset().top
            }, 1000);
        }
    </script>

</body>
</html>