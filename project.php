<?php
// index.php
require_once 'includes/config.php';
require_once 'includes/passcode_functions.php';

$error = '';
$success = false;

// Check if user is already logged in with a valid passcode
if (isset($_SESSION['passcode_verified']) && $_SESSION['passcode_verified'] === true) {
    $success = true;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['passcode'])) {
    $passcode = trim($_POST['passcode']);

    if (strlen($passcode) !== 6 || !is_numeric($passcode)) {
        $error = 'Passcode must be 6 digits';
    } else {
        if (verifyPasscode($conn, $passcode)) {
            $_SESSION['passcode_verified'] = true;
            $success = true;
        } else {
            $error = 'Invalid passcode';
        }
    }
}
?>


<?php include "includes/header.php"; ?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .login-container {
        margin-top: 100px;
    }

    .digit-input {
        width: 50px;
        height: 50px;
        text-align: center;
        font-size: 24px;
        margin: 0 5px;
    }
</style>


    <div class="container mb-5">
        <?php if (!$success): ?>
            <div class="row justify-content-center login-container">
                <div class="col-md-6">
                    <div class="card mb-5">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Enter Passcode</h4>
                        </div>
                        <div class="card-body">
                            <?php if ($error): ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>

                            <p class="text-center mb-4">Please enter your 6-digit passcode to access the protected content.
                            </p>

                            <form method="post" id="passcodeForm">
                                <div class="form-group text-center">
                                    <input type="text" name="passcode" id="passcode" maxlength="6"
                                        class="form-control form-control-lg text-center" placeholder="Enter 6-digit code"
                                        required>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>

            
            <!-- <div class="row justify-content-center mt-5">
                <div class="col-md-12 "> -->
                    <?php include "projects-details.php"; ?>
                <!-- </div>
            </div> -->
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php include "includes/footer.php"; ?>