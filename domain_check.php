<?php
header('Content-Type: application/json');
require_once 'db.php';

if (isset($_GET['domain'])) {
    $domain = strtolower(trim($_GET['domain']));
    
    // Basic validation to ensure it looks like a domain
    if (preg_match('/^[a-z0-9-]+(\.[a-z]{2,})+$/', $domain)) {
        
        // Prepare statement to check if domain exists in our "registered" database
        $stmt = $pdo->prepare("SELECT id FROM domains WHERE domain_name = ?");
        $stmt->execute([$domain]);
        $exists = $stmt->fetch();

        echo json_encode([
            'domain' => $domain,
            'available' => !$exists,
            'status' => 'success'
        ]);
    } else {
        echo json_encode(['error' => 'Invalid domain format', 'status' => 'error']);
    }
} else {
    echo json_encode(['error' => 'No domain provided', 'status' => 'error']);
}
?>
