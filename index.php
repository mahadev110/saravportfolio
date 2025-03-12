<?php
session_start(); // Start session at the top of the file
?>
<?php
include "includes/header.php";
include "includes/navbar.php";
include "includes/slider.php";
?>
<!--================Welcome Area =================-->
<section class="welcome_area p_120" id="aboutsection">
  <div class="container">
    <div class="row welcome_inner">

      <div class="col-lg-7">
        <div class="welcome_text">
          <h4>About Myself</h4>
          <p>
            I would enjoy fast paced environment contributing for multiple
            projects.
          </p>
          <p class="mb-4">
            <strong>Technical:</strong> AWS, Azure, GCP , Consul, Docker,
            Chef, packer, Terraform, NoSQL, Microservices, Sumologic,
            Jenkins, Bamboo, Stash, github, artifactory, Python, redis,
            golang, grafana, vault, Kubernetes, Qualys
          </p>
          <p class="mb-0">
            <strong>Specialties:</strong>Multi-cloud, Kubernetes,
            Monitoring, incident management, devtools, Automation,
            Continuous delivery, Version control, Tool migrations, Extending
            tools, Continuous Integration, Docker, Atlasssian Specialist,
            AWS, Change and Release Management, Audit compliance,
            Deployment, Plugin Development, Build & Release, Service
            Discovery
          </p>
          <div class="row">
            <div class="col-md-4">
              <div class="wel_item text-center">
                <h4>16 +</h4>
                <p>Years experience</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="wel_item text-center">
                <h4>12 +</h4>
                <p>Completed projects</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="wel_item text-center">
                <h4>05</h4>
                <p>Companies trained</p>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="col-lg-5">
        <div class="image-frame mt-5">
          <img class="img-fluid" src="img/banner/profile.png" alt="about" />
        </div>
      </div>

    </div>
  </div>
</section>
<!--================End Welcome Area =================-->

<!--================Feature Area =================-->
<section class="feature_area p_120" id="qualificationid">
  <div class="container">
    <div class="main_title">
      <h2>Qualification</h2>
      <p> My journey of learning and experience </p>
    </div>


    <ul class="nav justify-content-center nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
          aria-controls="pills-home" aria-selected="true">Experience</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
          aria-controls="pills-profile" aria-selected="false">Academic</a>
      </li>

    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="timeline">
          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
              <h5>Expert in Platform Engineering & Infrastructure</h5>
              <p>Redwood City, California, United States</p>
              <span style="font-size: 12px;"> <i class="fa-solid fa-calendar-days"></i>
                9 yrs 6 mos</span>
            </div>
          </div>

          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
              <h5>Sr. Software Engineer - DevOps</h5>
              <p>Elementum - San Francisco Bay Area</p>
              <span style="font-size: 12px;"> <i class="fa-solid fa-calendar-days"></i>
                Dec 2014 - Nov 2015 · 1 yr</span>
            </div>
          </div>

          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
              <h5>Senior DevOps Engineer / DevOps Engineer</h5>
              <p>Qualys - San Francisco Bay Area</p>
              <span style="font-size: 12px;"> <i class="fa-solid fa-calendar-days"></i>
                Jan 2012 - Dec 2014 · 3 yrs</span>
            </div>
          </div>

          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
              <h5>Senior Software Developer</h5>
              <p>Qualcomm - San Francisco Bay Area</p>
              <span style="font-size: 12px;"> <i class="fa-solid fa-calendar-days"></i>
                Feb 2011 - Jan 2012 · 1 yr</span>
            </div>
          </div>

          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
              <h5>Software Engineer</h5>
              <p>HP Autonomy - Bengaluru Area, India</p>
              <span style="font-size: 12px;"> <i class="fa-solid fa-calendar-days"></i>
                Oct 2008 - Feb 2011 · 2 yrs 5 mos</span>
            </div>
          </div>
        </div>

      </div>
      <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="timeline">
          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
              <div class="projects_item">
                <img class="img-fluid" src="img/education/1.jpg" alt="Stanford University" />
              </div>
              <h5>Organizational Leadership</h5>
              <p>Stanford University Graduate School of Business</p>
              <span><i class="fa-solid fa-calendar-days"></i> Feb 2023 - Mar 2023</span>
            </div>
          </div>

          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
              <div class="projects_item">
                <img class="img-fluid" src="img/education/2.jpg" alt="Anna University" />
              </div>
              <h5>BE, Electrical & Electronics</h5>
              <p>Anna University, Chennai</p>
              <span><i class="fa-solid fa-calendar-days"></i> July 2002 - May 2006</span>
            </div>
          </div>

          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
              <div class="projects_item">
                <img class="img-fluid" src="img/education/3.jpg" alt="Arasunagar Matriculation" />
              </div>
              <h5>Higher Secondary</h5>
              <p>Arasunagar Matriculation (Ramakrishna Mission)</p>
              <span><i class="fa-solid fa-calendar-days"></i> 12 years of schooling</span>
            </div>
          </div>
        </div>
      </div>

    </div>




  </div>
</section>
<!--================End Feature Area =================-->

<!--================Testimonials Area =================-->
<!-- <section class="testimonials_area p_120" id="academicid">
  <div class="container">
    <div class="main_title">
      <h2>Academic Background</h2>
      <p>Lifelong Learning for Excellence</p>
    </div>
    <div class="feature_inner row">
      <div class="col-lg-4 col-md-6">
        <div class="feature_item">
          <div class="projects_item">
            <img class="img-fluid" src="img/education/1.jpg" alt="Stanford University" />
          </div>
          <h4 class="mt-4">Organizational Leadership</h4>
          <h5>Stanford University Graduate School of Business.</h5>
          <p>Feb 2023 - Mar 2023</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="feature_item">
          <div class="projects_item">
            <img class="img-fluid" src="img/education/2.jpg" alt="Anna University" />
          </div>
          <h4 class="mt-4">BE, Electrical & Electronics</h4>
          <h5>Anna University, Chennai.</h5>
          <p>July 2002 - May 2006</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="feature_item">
          <div class="projects_item">
            <img class="img-fluid" src="img/education/3.jpg" alt="Arasunagar Matriculation" />
          </div>
          <h4 class="mt-4">Higher Secondary</h4>
          <h5>Arasunagar Matriculation (Ramakrishna Mission).</h5>
          <p>12 years of schooling</p>
        </div>
      </div>




    </div>
  </div>
</section> -->
<!--================End Testimonials Area =================-->



<!--================Latest Blog Area =================-->
<section class="latest_blog_area p_120" id="portfolioid">
  <div class="container">
    <div class="main_title">
      <h2>Portfolio</h2>
      <p>
        Showcasing innovative projects, creative solutions, and a passion for excellence.
      </p>
    </div>
    <div class="row latest_blog_inner">
      <div class="col-lg-3">
        <div class="l_blog_item">
          <div class="l_blog_img">
            <img class="img-fluid" src="img/portfolio/1.jpg" alt="Managing Engineers" />
          </div>
          <div class="l_blog_text">
            <div class="date">
              <a href="#">Managing Engineers</a>
            </div>
            <a href="#">
              <h4>Managing more than 55 Engineers</h4>
            </a>
            <p>
              Successfully leading a team of 55+ engineers, ensuring project efficiency, timely delivery, and
              innovation.
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="l_blog_item">
          <div class="l_blog_img">
            <img class="img-fluid" src="img/portfolio/2.jpg" alt="High Value Projects" />
          </div>
          <div class="l_blog_text">
            <div class="date">
              <a href="#">High-Value Projects</a>
            </div>
            <a href="#">
              <h4>Handled projects over $30M</h4>
            </a>
            <p>
              Successfully managed high-value projects exceeding $30 million, ensuring optimal resource allocation and
              execution.
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="l_blog_item">
          <div class="l_blog_img">
            <img class="img-fluid" src="img/portfolio/3.jpg" alt="Global Teams" />
          </div>
          <div class="l_blog_text">
            <div class="date">
              <a href="#">Global Leadership</a>
            </div>
            <a href="#">
              <h4>5 Global Teams Reporting</h4>
            </a>
            <p>
              Effectively leading and coordinating 5 global teams, driving seamless collaboration and successful project
              execution.
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="l_blog_item">
          <div class="l_blog_img">
            <img class="img-fluid" src="img/portfolio/4.jpg" alt="Cost Savings" />
          </div>
          <div class="l_blog_text">
            <div class="date">
              <a href="#">Cost Optimization</a>
            </div>
            <a href="#">
              <h4>Implemented $20M+ Cost Savings</h4>
            </a>
            <p>
              Spearheaded cost-saving initiatives, optimizing operations and achieving over $20 million in financial
              efficiencies.
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
<!--================End Latest Blog Area =================-->
<?php include "includes/footer.php"; ?>