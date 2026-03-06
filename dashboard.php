<?php
require_once 'db.php';

// Secure the page - redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// Fetch user's domains
$stmt = $pdo->prepare("SELECT * FROM domains WHERE user_id = ? ORDER BY registered_at DESC");
$stmt->execute([$userId]);
$userDomains = $stmt->fetchAll();

// Handle deletion (releasing a domain)
if (isset($_GET['release_id'])) {
    $releaseId = $_GET['release_id'];
    $stmt = $pdo->prepare("DELETE FROM domains WHERE id = ? AND user_id = ?");
    $stmt->execute([$releaseId, $userId]);
    header("Location: dashboard.php?notif=released");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard | GoClone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav>
        <a href="index.php" class="logo">GoClone<span>.</span></a>
        <div class="nav-links">
            <a href="index.php">Search New Domain</a>
            <span style="font-weight: 700; color: var(--primary);">Hi, <?php echo htmlspecialchars($userName); ?></span>
            <a href="logout.php" class="btn-signup">Logout</a>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>My Domains</h1>
            <a href="index.php" class="btn-signup" style="text-decoration: none;">+ Register New</a>
        </div>

        <?php if(isset($_GET['notif'])): ?>
            <div style="padding: 1rem; background: #e6f6ee; color: var(--accent); border-radius: 10px; margin-bottom: 2rem; font-weight: 600; text-align: center;">
                <?php 
                    if($_GET['notif'] == 'registered') echo "Domain successfully registered!";
                    if($_GET['notif'] == 'released') echo "Domain has been released back to market.";
                ?>
            </div>
        <?php endif; ?>

        <?php if(count($userDomains) > 0): ?>
            <table class="domain-table">
                <thead>
                    <tr>
                        <th>Domain Name</th>
                        <th>Registration Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($userDomains as $domain): ?>
                        <tr>
                            <td style="font-weight: 700; color: var(--secondary);"><?php echo htmlspecialchars($domain['domain_name']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($domain['registered_at'])); ?></td>
                            <td><span class="badge active">Active</span></td>
                            <td>
                                <a href="dashboard.php?release_id=<?php echo $domain['id']; ?>" 
                                   class="btn-release" 
                                   onclick="return confirm('Are you sure you want to release this domain?')">Release</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align: center; padding: 4rem; background: #fff; border-radius: 20px; box-shadow: var(--shadow);">
                <h3 style="margin-bottom: 1rem;">No domains found.</h3>
                <p style="color: var(--text-muted); margin-bottom: 2rem;">You haven't registered any domains yet.</p>
                <a href="index.php" class="btn-register" style="text-decoration: none;">Find Your First Domain</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
