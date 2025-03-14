<?php
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
                </div>
            </div>
        </div>

        <div class="card">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>