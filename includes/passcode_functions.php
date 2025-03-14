<?php
// passcode_functions.php
require_once 'config.php';

// Generate a unique 6-digit passcode
function generateUniquePasscode($conn) {
    do {
        $passcode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $stmt = $conn->prepare("SELECT id FROM passcodes WHERE passcode = ?");
        $stmt->bind_param("s", $passcode);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
    } while ($exists);
    
    return $passcode;
}

// Generate multiple unique passcodes
function generateMultiplePasscodes($conn, $count, $description = '') {
    $generated = [];
    
    for ($i = 0; $i < $count; $i++) {
        $passcode = generateUniquePasscode($conn);
        $stmt = $conn->prepare("INSERT INTO passcodes (passcode, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $passcode, $description);
        
        if ($stmt->execute()) {
            $generated[] = $passcode;
        }
        
        $stmt->close();
    }
    
    return $generated;
}

// Get all passcodes
function getAllPasscodes($conn) {
    $passcodes = [];
    $query = "SELECT p.*, COUNT(l.id) as access_count 
              FROM passcodes p 
              LEFT JOIN access_logs l ON p.id = l.passcode_id 
              GROUP BY p.id 
              ORDER BY p.created_at DESC";
    
    $result = $conn->query($query);
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $passcodes[] = $row;
        }
    }
    
    return $passcodes;
}

// Verify passcode
function verifyPasscode($conn, $passcode) {
    $stmt = $conn->prepare("SELECT id FROM passcodes WHERE passcode = ? AND is_active = 1");
    $stmt->bind_param("s", $passcode);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $passcodeId = $row['id'];
        $stmt->close();
        
        // Log access
        logAccess($conn, $passcodeId);
        
        return true;
    }
    
    $stmt->close();
    return false;
}

// Log access
function logAccess($conn, $passcodeId) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
    $stmt = $conn->prepare("INSERT INTO access_logs (passcode_id, ip_address, user_agent) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $passcodeId, $ip, $userAgent);
    $stmt->execute();
    $stmt->close();
}

// Get passcode info including access logs
function getPasscodeDetails($conn, $passcodeId) {
    $stmt = $conn->prepare("SELECT * FROM passcodes WHERE id = ?");
    $stmt->bind_param("i", $passcodeId);
    $stmt->execute();
    $passcode = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    if (!$passcode) {
        return null;
    }
    
    // Get access logs
    $stmt = $conn->prepare("SELECT * FROM access_logs WHERE passcode_id = ? ORDER BY access_time DESC");
    $stmt->bind_param("i", $passcodeId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }
    
    $passcode['logs'] = $logs;
    
    return $passcode;
}

// Toggle passcode status
function togglePasscodeStatus($conn, $passcodeId) {
    $stmt = $conn->prepare("UPDATE passcodes SET is_active = NOT is_active WHERE id = ?");
    $stmt->bind_param("i", $passcodeId);
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
}

// Delete passcode
function deletePasscode($conn, $passcodeId) {
    $stmt = $conn->prepare("DELETE FROM passcodes WHERE id = ?");
    $stmt->bind_param("i", $passcodeId);
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
}
?>