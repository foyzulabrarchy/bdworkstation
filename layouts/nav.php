<header id="header" class="header-main">

                <!-- Begin Navbar -->
                <nav id="main-navbar" class="navbar navbar-fixed-top" role="navigation"> <!-- Classes: navbar-default, navbar-inverse, navbar-fixed-top, navbar-fixed-bottom, navbar-transparent. Note: If you use non-transparent navbar, set "height: 98px;" to #header -->

                  <div class="container">

                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <!-- <span class="sr-only">Toggle navigation</span> -->
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="index.php">WorkStation</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="page-scroll" href="#body">Home</a></li>
                            <li><a class="page-scroll" href="#about-section">About</a></li>
                            <li><a class="page-scroll" href="#services-section">Services</a></li>
                            <li><a class="page-scroll" href="#contact-section">Contact</a></li>
                            <li><a class="page-scroll" onclick="showLogin()">Log In</a></li>
                            <li><a class="page-scroll" onclick="showSignup()">Sign Up</a></li>
                            <li><a href="#"><button class="btn btn-danger btn-md">Post Job</button></a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container -->
                </nav>
                <!-- End Navbar -->

            </header>




                <!-- Begin Log In Modal View --> 
                    <?php

                        include "login.php";
                    
                    ?>
                <!-- End Log In Modal View --> 


             <!-- Begin Sign Up Modal View --> 
                    <?php

                        include "signup.php";
                    
                    ?>
             <!-- End Log In Modal View --> 