<?php
require_once 'db.php';

// If user is not logged in, save the domain they want and redirect to login
if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['domain'])) {
        $_SESSION['pending_domain'] = $_POST['domain'];
    }
    header("Location: login.php");
    exit;
}

// Check if we have a domain from POST or from a pending session (from login)
$domain = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['domain'])) {
    $domain = strtolower(trim($_POST['domain']));
} elseif (isset($_SESSION['pending_domain'])) {
    $domain = strtolower(trim($_SESSION['pending_domain']));
    unset($_SESSION['pending_domain']); // Clear it after use
}

if ($domain) {
    $userId = $_SESSION['user_id'];

    // Check availability again on server side to prevent race conditions
    $stmt = $pdo->prepare("SELECT id FROM domains WHERE domain_name = ?");
    $stmt->execute([$domain]);
    
    if ($stmt->fetch()) {
        // Instead of die(), redirect to home with an error message
        header("Location: index.php?error=taken&domain=" . urlencode($domain));
        exit;
    }

    // Register the domain
    $stmt = $pdo->prepare("INSERT INTO domains (user_id, domain_name, status) VALUES (?, ?, 'active')");
    if ($stmt->execute([$userId, $domain])) {
        header("Location: dashboard.php?notif=registered");
        exit;
    } else {
        header("Location: index.php?error=failed");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
