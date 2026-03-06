<?php
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            
            // If they had a domain waiting, go to register it, else dashboard
            if (isset($_SESSION['pending_domain'])) {
                header("Location: domain_register.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GoClone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background: #f0f2f5;">

    <nav>
        <a href="index.php" class="logo">GoClone<span>.</span></a>
        <div class="nav-links">
            <a href="signup.php" class="btn-signup">Join Now</a>
        </div>
    </nav>

    <div class="auth-container">
        <h2>Welcome Back</h2>
        
        <?php if($error): ?>
            <p style="color: var(--error); margin-bottom: 1rem; text-align: center; font-weight: 600;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="john@example.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-auth">Sign In</button>
        </form>
        
        <p style="text-align: center; margin-top: 1.5rem;">
            New to GoClone? <a href="signup.php" style="color: var(--primary); text-decoration: none; font-weight: 600;">Create an account</a>
        </p>
    </div>

    <script src="script.js"></script>
</body>
</html>
