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
						<h2>Orion Project Details</h2>
						<div class="page_link">
							<a href="index.php">Home</a>
							<a href="orion.php">Orion</a>
						
						</div>
						
					</div>
				</div>
            </div>
        </section>
        <!--================End Home Banner Area =================-->
        
        <!--================Portfolio Details Area =================-->
        <section class="portfolio_details_area p_120">
        	<div class="container">
        		<div class="portfolio_details_inner">
					<div class="row">
						<div class="col-md-6">
							<div class="left_img">
								<img class="img-fluid" src="img/projects/orion-slide1.jpg" alt="">
							</div>
						</div>
						<div class="col-md-6">
							<div class="portfolio_right_text">
								<h4>Streamlining IT Excellence</h4>
								<p>Enhance IT operations with intelligent automation, proactive monitoring, and seamless infrastructure management. </p>
								<ul class="list">
									<li><span>Rating</span>: <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></li>
									<li><span>Client</span>:  colorlib</li>
									<li><span>Website</span>:  colorlib.com</li>
									<li><span>Completed</span>:  17 Aug 2018</li>
								</ul>
							</div>
						</div>
					</div>
       				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p>
       				<p>Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
        		</div>
        	</div>
        </section>
        <!--================End Portfolio Details Area =================-->
        <?php include "includes/footer.php"; ?>