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

// Get all passcodes
$passcodes = getAllPasscodes($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
            <div class="alert alert-info"><?php echo $message; ?></div>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>