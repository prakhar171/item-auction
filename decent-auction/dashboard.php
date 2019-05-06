<?php  
    session_start();
    include("functions/functions.php");
    if(!isset($_SESSION['user_email'])) {
        echo "<script>alert('Please Log In ');window.open('login.php','_self');</script>";
    }

    $user_email=$_SESSION['user_email'];

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
    <title>Member Dashboard</title>
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

    <!-- LOADER -->
    <div id="preloader">
        <img class="preloader" src="images/loader.gif" alt="">
    </div><!-- end loader -->
    <!-- END LOADER -->

                <?php include 'navbar.php'; ?>



                                <style type="text/css">

                                    .dasht{
                                        padding: 20px;
                                    }

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
                    <div class="text-center col-md-12">
                            <h2 class="text-center" style="font-size: 50px; font-family: Open Sans;">Your Item Listings</h2>
                            

                        <button class="btn btn-primary" data-toggle="modal" data-target="#ItemList" style="margin-top: 20px;">Add Item Listing</button>

                        <br>
                        <br>
                            <?php

                                $list_url=$base_url."/ItemListing?access_token=".$access_token;

                                $get_list=json_decode(CallAPI('GET',$list_url,false), true);



                                    echo "<div class='table-responsive' id='dash' >

                                            <table class='table-bordered' style='margin-left: auto; margin-right: auto;'>
                                            <thead>
                                                
                                                    <tr style='font-weight:bold;'>
                                                        <th style='padding:12px;'>Listing ID</th>
                                                        <th style='padding:12px;'>Item Description</th>
                                                        <th style='padding:12px;'>Reserve Price</th>
                                                        <th style='padding:12px;'>Status</th>
                                                        <th style='padding:12px;'>Bid Count</th>
                                                        <th style='padding:12px;'>Close Bidding</th>
                                                        <th style='padding:12px;'>End Auction</th>
                                                    </tr>
                                            </thead>
                                            <tbody>
                                                ";

                                foreach ($get_list as $listing) {

                                    if ($listing['state']=='FOR_SALE') {
                                        $close_bid="<form method='post'>
                                                    <input type='hidden' value='".$listing['listingId']."' name=listid />
                                                    <button class='btn btn-danger' name='close_bid' type='submit' style='margin-top: 20px;'>Close Bidding</button>
                                                    </form>";
                                    }
                                    else{
                                        $close_bid="Already Closed";
                                    }

                                    if ($listing['state']=='BIDDING_CLOSED') {
                                        $end_bid="<form method='post'>
                                                    <input type='hidden' value='".$listing['listingId']."' name=listid />
                                                    <button class='btn btn-success' name='end_bid' type='submit' style='margin-top: 20px;'>End Auction</button>
                                                    </form>";
                                    }
                                    else{
                                        $end_bid="";
                                    }

                                    if ($listing['owner']=="resource:org.example.mynetwork.Member#".$_SESSION['user_email']) {
                                    
                                    
                                     echo "<tr>
                                                <td style='padding:55 px;' class='dasht'>".$listing['listingId']."</td>                    
                                                <td style='padding:55 px;' class='dasht'>".$listing['description']."</td>
                                                <td style='padding:55 px;' class='dasht'>".$listing['reservePrice']."</td>
                                                <td style='padding:55 px;' class='dasht'>".$listing['state']."</td>
                                                <td style='padding:55 px;' class='dasht'>".sizeof($listing['offers'])."</td>
                                                
                                                <td style='padding:55 px;' class='dasht'>".$close_bid."</td>
                                                <td style='padding:55 px;' class='dasht'>".$end_bid."</td>
                                            </tr>";
                                    }
                                }

                            ?>



                                    </tbody>
                                </table>
                            </div>
                    
                </div><!-- end row -->

                <div class="row">
                    <div class="text-center col-md-12">
                            <h2 class="text-center" style="font-size: 50px; font-family: Open Sans;">Your Bids</h2>
                            

                        <a href="items.php"><button class="btn btn-primary" style="margin-top: 20px;">Explore Items</button></a>

                        <br>
                        <br>
                            <?php

                                $mem_url=$base_url."/Member/".$user_email."?access_token=".$access_token;

                                $item_list=json_decode(CallAPI('GET',$mem_url,false), true);
                                
                                $itembids=$item_list['itembids'];

                                


                                    echo "<div class='table-responsive' id='dash' >

                                            <table class='table-bordered' style='margin-left: auto; margin-right: auto;'>
                                            <thead>
                                                
                                                    <tr style='font-weight:bold;'>
                                                        <th style='padding:12px;'>Listing ID</th>
                                                        <th style='padding:12px;'>Item Description</th>
                                                        
                                                        <th style='padding:12px;'>Status</th>
                                                        
                                                        <th style='padding:12px;'>Reveal Bid</th>
                                                        
                                                    </tr>
                                            </thead>
                                            <tbody>
                                                ";

                                foreach ($itembids as $item) {

                                    $list_url=$base_url."/ItemListing/".$item."?access_token=".$access_token;

                                    $listing=json_decode(CallAPI('GET',$list_url,false), true);


                                    
                                    if (!array_key_exists("error", $listing)) {

                                        if ($listing['state']=='BIDDING_CLOSED') {
                                            $rev_bid="<form method='post'>
                                                        <input type='hidden' value='".$listing['listingId']."' name='listid' />
                                                        <input type='hidden' value='".$user_email."' name='member' />
                                                        <input type='text' class='form-control' name='key' />
                                                        <button class='btn btn-danger' name='reveal_bid' type='submit' style='margin-top: 20px;'>Reveal Bid</button>
                                                        </form>";
                                        }
                                        else{
                                            $rev_bid="Bidding Still Open";
                                        }
                                        
                                        echo "<tr>
                                                    <td style='padding:55 px;' class='dasht'>".$listing['listingId']."</td>                    
                                                    <td style='padding:55 px;' class='dasht'>".$listing['description']."</td>
                                                    
                                                    <td style='padding:55 px;' class='dasht'>".$listing['state']."</td>
                                                    
                                                    
                                                    <td style='padding:55 px;' class='dasht'>".$rev_bid."</td>
                                                    
                                                </tr>";
                                        }
                                    
                                    else{
                                        echo $listing;
                                    }
                                }

                            ?>



                                    </tbody>
                                </table>
                            </div>
                    
                </div><!-- end row -->
                

            </div><!-- end container -->
        </section><!-- end section -->

                        <div id="ItemList" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <form method="post">
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h3 class="modal-title" style="color: white;">Add Item Listing</h3>
                                  </div>
                                  <div class="modal-body">
                                    <label class="mod_label">Unique Item Name:</label>
                                    <input type="text" name="vin">
                                    <br><br>
                                    <label class="mod_label">Unique Listing ID:</label>
                                    <input type="text" name="listid">
                                    <br><br>
                                    <label class="mod_label">Item Description</label>
                                    <input type="text" name="desc">
                                    <br><br>
                                    <label class="mod_label">Reserve Bid:</label>
                                    <input type="number" name="rbid">
                                    <br><br>
                                    <label class="mod_label">Bidding End Date:</label>
                                    <input type="datetime-local" name="enddt">

                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-default" name="add_item">Submit</button>
                                  </div>
                                </div>

                              </div>
                            </div>
                            </form>

    <!-- jQuery Files -->

    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/carousel.js"></script>
</body>
</html>

<?php

    if (isset($_POST['close_bid'])) {
        
        $listid = $_POST['listid'];
    
        $list=json_encode(array(

                "\$class"=> "org.example.mynetwork.CloseBidding",
                "listing"=> "resource:org.example.mynetwork.ItemListing#".$listid,
                ));

        $add_url=$base_url."/CloseBidding?access_token=".$access_token;

        $res=json_decode(CallAPI('POST',$add_url,$list), true);

        if (!array_key_exists("error", $res)) {
            
            echo "<script>window.location = window.location.href.split('#')[0];";


        }

        else{

            print_r($res);

        }
    }

    if (isset($_POST['add_item'])) {
        $vin = $_POST['vin'];
        $listid = $_POST['listid'];
        $desc = $_POST['desc'];
        $rbid = $_POST['rbid'];
        $enddt = $_POST['enddt'];

        $owner= $_SESSION['user_email'];

        $item=json_encode(array(

        "\$class"=> "org.example.mynetwork.Item",
        "vin"=> $vin,
        "owner"=> "resource:org.example.mynetwork.Member#".$owner
        ));

        $add_url=$base_url."/Item?access_token=".$access_token;

        $res=json_decode(CallAPI('POST',$add_url,$item), true);

        if (!array_key_exists("error", $res)) {
                

                $iteml=json_encode(array(

                "\$class"=> "org.example.mynetwork.ItemListing",
                "listingId"=> $listid,
                "reservePrice"=> $rbid,
                "description"=> $desc,
                "state"=> "FOR_SALE",
                "enddate"=> $enddt,
                "offers"=> [],
                "EncBids"=> [],
                "item"=> "resource:org.example.mynetwork.Item#".$vin,
                "owner"=> "resource:org.example.mynetwork.Member#".$owner
                ));

                $iteml_url=$base_url."/ItemListing?access_token=".$access_token;

                $res1=json_decode(CallAPI('POST',$iteml_url,$iteml), true);

                if (!array_key_exists("error", $res1)) {

                    echo "<script>alert('Item Listing Added');window.open('dashboard.php','_self');</script>";
                }
                else{
                    
                    print_r($res1);


                }
            }

        else{

            print_r($res);

        }
    }

    if (isset($_POST['reveal_bid'])) {
        $listid = $_POST['listid'];
        $member= $_SESSION['user_email'];
        $key=$_POST['key'];

        $enckey=caesarEncode($key,16);

        $rev=json_encode(array(

        "\$class"=> "org.example.mynetwork.RevealBid",
        "member"=> "resource:org.example.mynetwork.Member#".$member,
        "listing"=> "resource:org.example.mynetwork.ItemListing#".$listid,
        "EncKey"=> $enckey
        ));

        $rev_url=$base_url."/RevealBid?access_token=".$access_token;

        $res1=json_decode(CallAPI('POST',$rev_url,$rev), true);

        if (!array_key_exists("error", $res1)) {

            echo "<script>alert('Bid Revealed');window.open('dashboard.php','_self');</script>";
        }
        else{
            
            print_r($res1);


        }


    }

    if (isset($_POST['end_bid'])) {
        $listid = $_POST['listid'];


        $rev=json_encode(array(

        "\$class"=> "org.example.mynetwork.endAuction",
        "listing"=> "resource:org.example.mynetwork.ItemListing#".$listid
        ));

        $rev_url=$base_url."/endAuction?access_token=".$access_token;

        $res1=json_decode(CallAPI('POST',$rev_url,$rev), true);

        if (!array_key_exists("error", $res1)) {

            echo "<script>alert('Auction Ended');window.open('dashboard.php','_self');</script>";
        }
        else{
            
            print_r($res1);


        }
    }

?>