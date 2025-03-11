<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?redirect=" . basename(__FILE__));
    exit();
}
?>
<?php
include "includes/header.php";
include "includes/navbar.php";

?>
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