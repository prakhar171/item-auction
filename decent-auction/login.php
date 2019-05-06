<?php  
    
    session_start();
    include("functions/functions.php");
    if(isset($_SESSION['user_email'])) {
        echo "<script>alert('Already Logged In ');window.open('index.php','_self');</script>";
    }


?>


<!doctype html>
<!--[if IE 9]> <html class="no-js ie9 fixed-layout" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js " lang="en"> <!--<![endif]-->
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Site Meta -->
    <title>Login</title>
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

    <link rel="stylesheet" href="css/Google-Style-Login.css">
    <link rel="stylesheet" href="css/Pretty-Registration-Form.css">




    <!--[if lt IE 9]>
        <script src="js/vendor/html5shiv.min.js"></script>
        <script src="js/vendor/respond.min.js"></script>
    <![endif]-->

</head>

<body>  

    <!-- LOADER -->
    <div id="preloader">
        <img class="preloader" src="images/loader.gif" alt="">
    </div><!-- end loader -->
    <!-- END LOADER -->

    <?php include 'navbar.php'; ?>


        <section class="">
            <div class="container" style="padding: 30px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center" >
                            <h2 style="font-size: 50px; font-family: Open Sans;">LOG IN</h2>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
                <script type="text/javascript">
                    function switchtab(){
                    document.getElementById("tabl-1").classList.remove("active");
                    document.getElementById("tabl-2").classList.add("active");
                    document.getElementById("tab-1").classList.remove("active");
                    document.getElementById("tab-2").classList.add("active");
                    document.getElementById("tab-2").classList.add("in");

                }
                </script>

                <div class="col-md-8 col-md-offset-2">
                    
                    <ul class="nav nav-tabs nav-justified">
                        <li id="tabl-2" ><a href="#tab-2" role="tab" data-toggle="tab">LOG IN</a></li>
                        <li id="tabl-1" class="active"><a href="#tab-1" role="tab" data-toggle="tab">SIGN UP</a></li>
                    </ul>
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane fade" id="tab-2">
                            <div class="login-card"><img src="images/avatar_2x.png" class="profile-img-card" />
                                <p class="profile-name-card"></p>
                                <form class="form-signin" method="post"><span class="reauth-email"> </span>
                                    <input class="form-control" type="tel" required placeholder="Mobile Number" name="email" autofocus/>
                                    <input class="form-control" type="password" required placeholder="Password" name="pass"/>
                                    <div class="checkbox">
                                        <!-- <div class="checkbox">
                                            <label>
                                                <input type="checkbox" />Remember me</label>
                                        </div> -->
                                    </div>
                                    <button name="login" class="btn btn-primary btn-block btn-lg btn-signin" type="submit">Log in</button>
                                </form>
                                <a href="forgot_pw.php" class="forgot-password">Forgot your password?</a></br>
                                
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade  in active" id="tab-1">
                            <h4 class="text-center" style="font-style: italic; padding-top: 15px;">If you already have login details, please <span style="text-decoration: underline;"><a href="#" onclick="switchtab()" >log in here</a></span>.</h4>
                            <form class="login-card" method="post" enctype="multipart/form-data">
                                

                                <label class="control-label">First Name </label>
                                <input class="form-control" type="text" required name="fname" />


                                <label class="control-label">Last Name </label>
                                <input class="form-control" type="text" required name="lname" />                                 

                                <label class="control-label">Email Address </label>
                                <input class="form-control" type="email" required name="email" />
                                <label class="control-label">Password (Minimum 6 characters) </label>
                                <input class="form-control" type="password" required name="pass" pattern=".{6,}" />
                                </br>

                                <button class="btn btn-primary btn-block btn-lg btn-signin" name="signup" type="submit">Sign Up</button>
                                </form>
                        </div>
                    </div>
                </div>
                

            </div><!-- end container -->
        </section><!-- end section -->
    <!-- jQuery Files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
<?php  
    


    if (isset($_POST['login'])) {
        
        $email=$_POST['email'];
        $pass=$_POST['pass'];


        $mem_url=$base_url."Member/".$email."?access_token=".$access_token;

        $get_mem=CallAPI('GET',$mem_url,false);

        $mem=json_decode($get_mem, true);


        if (array_key_exists("error", $mem)) {
            echo "<script>window.location.replace(window.location.pathname + window.location.search + window.location.hash);alert('User does not exist. Please Sign Up.');</script>";

            exit();
        }

        else{

            $check_pass=$mem['password'];

            if (password_verify($pass,$check_pass)){

                $_SESSION['user_email']=$email;
                    
                echo "<script>alert('Login Successful');window.open('dashboard.php','_self');</script>";
            }
            else{
                echo "<script>alert('Password is incorrect. Please try again.');window.open('login.php', '_self');</script>";
            
            }
        }
    }


    if (isset(($_POST['signup']))) {
        
        //getting text data from fields
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $pass=$_POST['pass'];
        $pass_hash=password_hash($pass, PASSWORD_DEFAULT);
        $email=$_POST['email'];

        $add_mem=json_encode(array(
          "\$class"=> "org.example.mynetwork.Member",
          "balance"=> 1000,
          "key"=> "1",
          "itembids"=>[],
          "email"=> $email,
          "password"=> $pass_hash,
          "firstName"=> $fname,
          "lastName"=> $lname,
            )
        );

        $mem_url=$base_url."Member/".$email."?access_token=".$access_token;

        $get_mem=CallAPI('GET',$mem_url,false);

        $mem=json_decode($get_mem, true);

        $add_url= $base_url."Member/"."?access_token=".$access_token;

        // print_r($mem);

        if (!array_key_exists("error", $mem)) {
            echo "<script>window.location.replace(window.location.pathname + window.location.search + window.location.hash);$('.nav-tabs a[href=\"#tab2\"]').tab('show');</script>";
            echo "here1";
            
        }

        else{
            echo "here2";
            $res=json_decode(CallAPI('POST',$add_url,$add_mem), true);
            
            if (!array_key_exists("error", $res)) {
                $_SESSION['user_email']=$email;
                echo "<script>alert('User Added');window.open('dashboard.php','_self');</script>";
            }

            else{
                echo "<script>alert('Error');</script>";
                print_r($res);
            }

            

        }
    }




?>