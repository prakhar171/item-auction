<?php  
    session_start();
    include("functions/functions.php");
    if(!isset($_SESSION['user_email'])) {
        echo "<script>alert('Please Log In ');window.open('login.php','_self');</script>";
    }


?>


<!doctype html>
<!--[if IE 9]> <html class="no-js ie9 fixed-layout" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js " lang="en"> <!--<![endif]-->
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->



    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Site Meta -->
    <title>Make Bid</title>
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
    <link rel="stylesheet" href="css/prettyPhoto.css">
        <script src="js/jquery.min.js"></script>
        <script src="js/aes.js"></script>

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



                                <style type="text/css">
                                    #dash {
                                        color: black;
                                    }
                                    @media screen and (max-width: 768px) {
                                        #app {
                                            display: block;
                                        }
                                    }

                                    @media screen and (min-width: 769px) {
                                        #app {
                                            display: none;
                                        }
                                    }
                                    
                                </style>

        <section class="section wb">
            <div class="container" style="padding: 30px;">


                <div class="row">
                    <div class="col-md-12">
                            <h2 class="text-center" style="font-size: 50px; font-family: Open Sans;">Items For Sale</h2>
                            
                        </br></br>


                        <?php
                                            $list_id=$_POST['listid'];


                        ?>

                        <script type="text/javascript">
                            function encBid(){
                                var bid=document.getElementById('bid').value;
                                var key=document.getElementById('key').value;
                                var enc= CryptoJS.AES.encrypt(bid, key);
                                document.getElementById('enc').value =enc;
                                document.forms["makebid"].submit();

                            }
                        </script>

                            <form class="login-card" method="post" id="makebid" enctype="multipart/form-data" onsubmit="encBid()" >

                                <label class="control-label">Listing </label>
                                <input class="form-control" type="text" readonly required name="listid" value='<?php echo $list_id; ?>' />

                                <label class="control-label">Your Bid </label>
                                <input class="form-control" type="number" id='bid' required name="bid" />

                                <label class="control-label">Encryption Key (Please Remember It For Revealing Your Bid)</label>
                                <input class="form-control" type="text" required id="key" name="key" />
                                <input type="hidden" value="" id="enc" name="encbid">
                                <br><br>
                                <a href="#" onclick="encBid();"><button class="btn btn-primary btn-block" name="add_item">Make Bid!</button></a>
                            </form>

                        
                    </div><!-- end col -->
                </div><!-- end row -->
                
            </div><!-- end container -->
        </section><!-- end section -->


    <!-- jQuery Files -->

    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/carousel.js"></script>
</body>
</html>

<?php

    if (isset($_POST['add_item'])) {

        #Make Offer
        $encbid=$_POST['encbid'];;
        echo "<script>alert('$encbid');</script>";
        $bid = $_POST['bid'];
        $key = $_POST['key'];

        $listid=$_POST['listid'];

        $mem= $_SESSION['user_email'];

        // $encbid=bin2hex(encryptAES($bid,$key));
        // $encbid=$bid;

        $offer=json_encode(array(
        "\$class"=> "org.example.mynetwork.Offer",
        "bidPrice"=> $encbid,
        "listing"=> "resource:org.example.mynetwork.ItemListing#".$listid,
        "member"=> "resource:org.example.mynetwork.Member#".$mem,
        ));

        $add_url=$base_url."/Offer?access_token=".$access_token;

        $res=json_decode(CallAPI('POST',$add_url,$offer), true);

        if (!array_key_exists("error", $res)) {

            echo "<script>alert('Hurray')</script>";
        }

        else{
            print_r($res);
        }

        #Deduct Amount

        $get_mem=$add_url= $base_url."Member/".$mem."?access_token=".$access_token;

        $mem_detail=json_decode(CallAPI('GET',$add_url,false), true);

        if (!array_key_exists("error", $mem_detail)) {

            // echo "<script>alert('Hurray')</script>";

            $new_bal=$mem_detail['balance']-$bid;

            array_push($mem_detail['itembids'], $listid);

            $itembids= $mem_detail['itembids'];

            $add_mem=json_encode(array(
              "\$class"=>$mem_detail["\$class"],
              "balance"=>$new_bal,
              "key"=>$mem_detail["key"],
              "email"=>$mem_detail["email"],
              "password"=>$mem_detail["password"],
              "firstName"=>$mem_detail["firstName"],
              "lastName"=>$mem_detail["lastName"],
              "itembids"=>$itembids
                )
            );

            echo $add_mem;
            $add_url= $base_url."Member/".$mem."?access_token=".$access_token;
            $res=json_decode(CallAPI('PUT',$add_url,$add_mem), true);

            if (!array_key_exists("error", $res)) {

                echo "<script>alert('Hurray'); window.open('dashboard.php', '_self');</script>";

                
            }

            else{

                echo "<script>alert('ERROR LOL')</script>";
                print_r($res);
            }
        }

        else{

            echo "<script>alert('ERROR LOL')</script>";
            print_r($res);
        }



        
    }
    

?>