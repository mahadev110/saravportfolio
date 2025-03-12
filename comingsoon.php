<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?redirect=" . basename(__FILE__));
    exit();
}
?>
<?php
include "includes/header.php";


?>
<body>
    <!--================Header Menu Area =================-->
    <header class="header_area">
        <div class="main_menu" id="mainNav">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container box_1620">
				<a href="index.php" class="navbar-brand logo_h">Sarav Jagadeesan</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item active"><a class="nav-link" href="index">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php#aboutsection">About</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php#qualificationid">Experiences</a>
                            <li class="nav-item"><a class="nav-link" href="index.php#qualificationid">Academic</a></li>
                            <li class="nav-item"><a class="nav-link" href="index.php#portfolioid">Portfolio</a>                         
                            <li class="nav-item"><a class="nav-link" href="index.php#contactid">Contact</a></li>
                            <li class="nav-item"><a class="menu_btn" href="login.php">Login</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!--================Header Menu Area =================-->

   <!--================Home Banner Area =================-->
   <section class="banner_area">
            <div class="banner_inner d-flex align-items-center">
            	<div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""></div>
				<div class="container">
					<div class="banner_content text-center">
					<img src="img/comingsoon.png" alt="" />
						<div class="page_link">
							<a href="index.php"><< Back</a>
						
						
						</div>
						
					</div>
				</div>
            </div>
        </section>
        <!--================End Home Banner Area =================-->
        
<?php include "includes/footer.php"; ?>