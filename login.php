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
            header("Location: $redirect");
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
include "includes/navbar.php"; ?>
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