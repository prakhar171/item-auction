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
    <title>Items For Sale</title>
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

    <!--[if lt IE 9]>
        <script src="js/vendor/html5shiv.min.js"></script>
        <script src="js/vendor/respond.min.js"></script>
    <![endif]-->

</head>

<body>  



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

                                            $list_url=$base_url."/ItemListing?access_token=".$access_token;

                                            $get_list=json_decode(CallAPI('GET',$list_url,false), true);



                                                echo "<div class='table-responsive' id='dash' >

                                                        <table class='table-bordered' style='margin-left: auto; margin-right: auto;'>
                                                        <thead>
                                                            
                                                                <tr style='font-weight:bold;'>
                                                                    <th style='padding:8px;'>Item ID</th>
                                                                    <th style='padding:8px;'>Item Description</th>
                                                                    <th style='padding:8px;'>Reserve Price</th>
                                                                    <th style='padding:8px;'>Status</th>
                                                                    <th style='padding:8px;'>Make A Bid</th>
                                                                    
                                                                </tr>
                                                        </thead>
                                                        <tbody>

                                                            ";

                                            foreach ($get_list as $listing) {

                                                if ($listing['state']=="FOR_SALE") {
                                                    $bid="<form method='post' action='make_bid.php'>
                                                    <input type='hidden' value='".$listing['listingId']."' name=listid />
                                                    <button class='btn btn-success' type='submit' style='margin-top: 20px;'>Make A Bid</button>
                                                    </form>";   
                                                }

                                                else{
                                                    $bid=$listing['state'];
                                                }
                                                
                                                 echo "<tr>
                                                            <td style='padding:8px;' class='dasht'>".$listing['listingId']."</td>                    
                                                            <td style='padding:8px;' class='dasht'>".$listing['description']."</td>
                                                            <td style='padding:8px;' class='dasht'>".$listing['reservePrice']."</td>
                                                            <td style='padding:8px;' class='dasht'>".$listing['state']."</td>

                                                            <td style='padding:8px;' class='dasht'>".$bid."</td>
                                                            
                                                        </tr>";
                                            }

                        ?>


                                    </tbody>
                                </table>
                            </div>
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
        $bid = $_POST['bid'];
        $key = $_POST['key'];

        $listid=$_POST['listid'];

        $mem= $_SESSION['user_email'];

        $encbid=encryptAES($bid,$key);

        $offer=json_encode(array(

        "$class"=> "org.example.mynetwork.Offer",
        "bidPrice"=> $encbid,
        "listing"=> "resource:org.example.mynetwork.ItemListing#".$listid,
        "member"=> "resource:org.example.mynetwork.Member#".$mem,
        ));

        $add_url=$base_url."/Offer?access_token=".$access_token;

        $res=json_decode(CallAPI('POST',$add_url,$offer), true);

        if (!array_key_exists("error", $res)) {

            echo "alert('Hurray')";
        }

        else{
            print_r($res);
        }

}
    

?>