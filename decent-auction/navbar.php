    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
            <header id="head" class="header header-normal">
                <div class="topbar clearfix">
                    <div class="container">
                        <div class="row-fluid">
                            <div class="col-md-6 col-sm-6 text-left">
                                <p>
                                    <strong><i class="fa fa-phone"></i></strong> +91 93 69 21 77 24 &nbsp;&nbsp;
                                    <strong><i class="fa fa-envelope"></i></strong> <a href="mailto: decent.auction@gmail.com">decent.auction@gmail.com</a>
                                </p>
                            </div><!-- end left -->
                            
                        </div><!-- end row -->
                    </div><!-- end container -->
                </div><!-- end topbar -->

            <div class="container">
                <nav class="navbar navbar-default yamm">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                        </button>
                        <div class="logo-normal">
                           <?php
                           if(isset($_SESSION['user_email'])) {
                                    
                                    echo "<span style='color:white;'>Welcome back, ".$_SESSION['user_email']."</span>";
                                }
                            ?>
                        </div>
                    </div>

                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <?php 
    
                                

                                if(!isset($_SESSION['user_email'])) {
                                    
                                    echo "<li><a href='login.php'>LOG IN</a></li>
                                        <li role='presentation'><a href='login.php' id='signin'>SIGN UP</a></li>";
                                }
                                else{

                                    echo "
                                            <li><a href='items.php'>Items</a></li>
                                            <li role='presentation'><a href='dashboard.php'>Dashboard</a></li>
                                            <li><a href='logout.php'>Logout</a></li>
                                            
                                            ";
                                }

                            ?>
                        </ul>
                    </div>
                </nav><!-- end navbar -->
            </div><!-- end container -->
        </header>