

<?php
// admin_dashboard.php
require_once '../includes/config.php';
require_once 'admin_auth.php';
require_once '../includes/passcode_functions.php';

requireAdmin();

$message = '';
$generated_passcodes = [];

// Generate new passcodes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    $count = (int)$_POST['count'];
    $description = $_POST['description'] ?? '';
    
    if ($count > 0 && $count <= 100) {
        $generated_passcodes = generateMultiplePasscodes($conn, $count, $description);
        $message = count($generated_passcodes) . ' passcodes generated successfully.';
    } else {
        $message = 'Please enter a valid number between 1 and 100.';
    }
}

// Toggle passcode status
if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    if (togglePasscodeStatus($conn, $_GET['toggle'])) {
        $message = 'Passcode status updated successfully.';
    } else {
        $message = 'Failed to update passcode status.';
    }
}

// Delete passcode
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (deletePasscode($conn, $_GET['delete'])) {
        $message = 'Passcode deleted successfully.';
    } else {
        $message = 'Failed to delete passcode.';
    }
}

// Send Email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_email'])) {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $passcodeId = (int)$_POST['passcode_id'];
    $accessUrl = getAccessUrl();
    
    if ($email && $passcodeId) {
        $passcodeDetails = getPasscodeById($conn, $passcodeId);
        
        if ($passcodeDetails && $passcodeDetails['is_active']) {
            $result = sendPasscodeEmail($email, $passcodeDetails['passcode'], $accessUrl);
            
            if ($result) {
                $message = 'Email sent successfully to ' . $email;
            } else {
                $message = 'Failed to send email. Please check your server configuration.';
            }
        } else {
            $message = 'Invalid or inactive passcode.';
        }
    } else {
        $message = 'Please enter a valid email address.';
    }
}

// Get all passcodes
$passcodes = getAllPasscodes($conn);

/**
 * Get the access URL for the protected page
 */
function getAccessUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    $path = rtrim(dirname($_SERVER['PHP_SELF']), '/');
    return $protocol . $domainName . $path . '/poject.php';
}

/**
 * Get passcode by ID
 */
function getPasscodeById($conn, $passcodeId) {
    $stmt = $conn->prepare("SELECT * FROM passcodes WHERE id = ?");
    $stmt->bind_param("i", $passcodeId);
    $stmt->execute();
    $result = $stmt->get_result();
    $passcode = $result->fetch_assoc();
    $stmt->close();
    return $passcode;
}

/**
 * Send passcode email
 *//**
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .popover {
            max-width: 300px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">Passcode Admin</a>
            <ul class="navbar-nav ml-auto">
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
                <h5>Generate New Passcodes</h5>
            </div>
            <div class="card-body">
                <form method="post" class="form-inline">
                    <div class="form-group mr-2">
                        <label for="count" class="mr-2">Number of passcodes:</label>
                        <input type="number" class="form-control" id="count" name="count" min="1" max="100" value="1" required>
                    </div>
                    <div class="form-group mr-2">
                        <label for="description" class="mr-2">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Optional description">
                    </div>
                    <button type="submit" name="generate" class="btn btn-primary">Generate</button>
                </form>

                <?php if (!empty($generated_passcodes)): ?>
                <div class="mt-3">
                    <h6>Generated Passcodes:</h6>
                    <div class="row">
                        <?php foreach ($generated_passcodes as $passcode): ?>
                            <div class="col-md-3 mb-2">
                                <div class="alert alert-success"><?php echo $passcode; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Manage Passcodes</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Passcode</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Description</th>
                                <th>Access Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($passcodes)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No passcodes found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($passcodes as $passcode): ?>
                                    <tr>
                                        <td><?php echo $passcode['id']; ?></td>
                                        <td><?php echo $passcode['passcode']; ?></td>
                                        <td>
                                            <?php if ($passcode['is_active']): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $passcode['created_at']; ?></td>
                                        <td><?php echo $passcode['description'] ?: '-'; ?></td>
                                        <td><?php echo $passcode['access_count']; ?></td>
                                        <td>
                                            <a href="passcode_details.php?id=<?php echo $passcode['id']; ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Details
                                            </a>
                                            <a href="admin_dashboard.php?toggle=<?php echo $passcode['id']; ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-toggle-on"></i> Toggle
                                            </a>
                                            <a href="admin_dashboard.php?delete=<?php echo $passcode['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this passcode?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                            <button type="button" class="btn btn-sm btn-success email-btn" 
                                                    data-toggle="popover" 
                                                    data-passcode-id="<?php echo $passcode['id']; ?>" 
                                                    data-passcode="<?php echo $passcode['passcode']; ?>">
                                                <i class="fas fa-envelope"></i> Email
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Popover Content Template -->
    <div id="email-popover-template" style="display: none;">
        <form method="post" class="email-form">
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <input type="hidden" name="passcode_id" class="passcode-id-input">
                <input type="hidden" name="send_email" value="1">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-sm">Send</button>
                <button type="button" class="btn btn-secondary btn-sm close-popover">Cancel</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            // Initialize popovers
            var currentPopover = null;
            
            $('.email-btn').on('click', function() {
                // Close any open popovers
                if (currentPopover) {
                    currentPopover.popover('hide');
                }
                
                var passcodeId = $(this).data('passcode-id');
                var passcode = $(this).data('passcode');
                var button = $(this);
                
                button.popover({
                    html: true,
                    container: 'body',
                    title: 'Send Passcode (' + passcode + ') via Email',
                    content: function() {
                        var content = $('#email-popover-template').clone().show();
                        content.find('.passcode-id-input').val(passcodeId);
                        return content;
                    },
                    placement: 'left',
                    trigger: 'manual'
                });
                
                currentPopover = button;
                button.popover('show');
            });
            
            // Close popover when clicking outside
            $(document).on('click', function(e) {
                if (currentPopover && 
                    !$(e.target).closest('.popover').length && 
                    !$(e.target).closest('.email-btn').length) {
                    currentPopover.popover('hide');
                    currentPopover = null;
                }
            });
            
            // Handle cancel button click
            $(document).on('click', '.close-popover', function() {
                if (currentPopover) {
                    currentPopover.popover('hide');
                    currentPopover = null;
                }
            });
            
            // Submit the email form via AJAX
            $(document).on('submit', '.email-form', function(e) {
                // We'll use regular form submission instead of AJAX
                // This ensures proper error handling and message display
                return true;
            });
            
            // Auto-dismiss alerts after 5 seconds
            $(".alert-dismissible").fadeTo(5000, 500).slideUp(500, function(){
                $(".alert-dismissible").alert('close');
            });
        });
    </script>
</body>
</html>