<?php
session_start();
include "includes/connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement using MySQLi
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch(); // No arguments required

        // Verify password (use password_verify() if passwords are hashed)
        if ($password === $hashed_password) {  
            $_SESSION['username'] = $username;

            // Redirect to the correct page if specified
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
            header("Location: comingsoon.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
    }

    $stmt->close();
}
?>


<?php include "includes/header.php"; 
// include "includes/navbar.php"; 
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

   <style>
      /* Ensure the login form takes the full viewport height */
      .login-container {
        height: 100vh; /* Full screen height */
        display: flex;
        justify-content: center;
        align-items: center;
      }
    </style>
  </head>
  <body>


    <!-- Login Form -->
    <div class="login-container">
      <div class="card p-4 shadow-lg" style="width: 400px;">
        <h2 class="text-center">Login</h2>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </body>
</html>