<?php
// passcode_details.php
// passcode_details.php
require_once '../includes/config.php';
require_once 'admin_auth.php';
require_once '../includes/passcode_functions.php';

requireAdmin();

$passcodeId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$passcodeId) {
    header('Location: admin_dashboard.php');
    exit;
}

$passcode = getPasscodeDetails($conn, $passcodeId);

if (!$passcode) {
    header('Location: admin_dashboard.php');
    exit;
}

// Get email logs for this passcode
$emailLogs = getPasscodeEmailLogs($conn, $passcodeId);

// Handle send email from this page
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_email'])) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $accessUrl = getAccessUrl();
    
    if ($email) {
        $result = sendPasscodeEmail($email, $passcode['passcode'], $accessUrl);
        
        if ($result) {
            $message = 'Email sent successfully to ' . $email;
        } else {
            $message = 'Failed to send email. Please check your server configuration.';
        }
    } else {
        $message = 'Please enter a valid email address.';
    }
}

/**
 * Get the access URL for the protected page
 */
function getAccessUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    $path = rtrim(dirname($_SERVER['PHP_SELF']), '/admin');
    return $protocol . $domainName . $path . '/index.php';
}

/**
 * Send passcode email
 */
function sendPasscodeEmail($email, $passcode, $accessUrl) {
    global $conn;
    
    // Get passcode ID from passcode value
    $stmt = $conn->prepare("SELECT id FROM passcodes WHERE passcode = ?");
    $stmt->bind_param("s", $passcode);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $passcodeId = $row['id'];
    $stmt->close();
    
    $subject = "Your Access Passcode";
    
    $message = "
    <html>
    <head>
        <title>Your Access Passcode</title>
    </head>
    <body>
        <div style='max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;'>
            <h2>Your Access Passcode</h2>
            <p>You have been granted access to our protected content.</p>
            <p>Please use the following passcode to gain access:</p>
            <div style='background-color: #f0f0f0; padding: 15px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px; margin: 20px 0;'>
                {$passcode}
            </div>
            <p>Access the protected content at:</p>
            <p><a href='{$accessUrl}' style='color: #3498db;'>{$accessUrl}</a></p>
            <p>This passcode is confidential. Please do not share it with others.</p>
            <hr>
            <p style='font-size: 12px; color: #777;'>This is an automated message. Please do not reply to this email.</p>
        </div>
    </body>
    </html>
    ";
    
    // Set content-type header for sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: noreply@" . $_SERVER['HTTP_HOST'] . "\r\n";
    
    $mailResult = mail($email, $subject, $message, $headers);
    
    // Log the email sending attempt
    if ($passcodeId) {
        $status = $mailResult ? 'success' : 'failed';
        logPasscodeEmail($conn, $passcodeId, $email, $status);
    }
    
    return $mailResult;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passcode Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">Passcode Admin</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if ($message): ?>
            <div class="alert alert-info alert-dismissible fade show"><?php echo $message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Passcode Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> <?php echo $passcode['id']; ?></p>
                        <p><strong>Passcode:</strong> <?php echo $passcode['passcode']; ?></p>
                        <p><strong>Status:</strong> 
                            <?php if ($passcode['is_active']): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Inactive</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Created:</strong> <?php echo $passcode['created_at']; ?></p>
                        <p><strong>Created By:</strong> <?php echo $passcode['created_by']; ?></p>
                        <p><strong>Description:</strong> <?php echo $passcode['description'] ?: '-'; ?></p>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="admin_dashboard.php?toggle=<?php echo $passcode['id']; ?>" class="btn btn-warning">
                        <i class="fas fa-toggle-on"></i> Toggle Status
                    </a>
                    <a href="admin_dashboard.php?delete=<?php echo $passcode['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this passcode?')">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#emailModal">
                        <i class="fas fa-envelope"></i> Send Email
                    </button>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Access Logs</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Access Time</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($passcode['logs'])): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No access logs found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($passcode['logs'] as $log): ?>
                                    <tr>
                                        <td><?php echo $log['id']; ?></td>
                                        <td><?php echo $log['access_time']; ?></td>
                                        <td><?php echo $log['ip_address']; ?></td>
                                        <td><?php echo $log['user_agent']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Email Logs</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Sent Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($emailLogs)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No email logs found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($emailLogs as $log): ?>
                                    <tr>
                                        <td><?php echo $log['id']; ?></td>
                                        <td><?php echo $log['email']; ?></td>
                                        <td><?php echo $log['sent_time']; ?></td>
                                        <td>
                                            <?php if ($log['status'] == 'success'): ?>
                                                <span class="badge badge-success">Success</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Failed</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">Send Passcode Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="emailInput">Email address:</label>
                            <input type="email" class="form-control" id="emailInput" name="email" required>
                            <small class="form-text text-muted">
                                The passcode (<?php echo $passcode['passcode']; ?>) will be sent to this email address.
                            </small>
                        </div>
                        <input type="hidden" name="send_email" value="1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        $(".alert-dismissible").fadeTo(5000, 500).slideUp(500, function(){
            $(".alert-dismissible").alert('close');
        });
    </script>
</body>
</html>