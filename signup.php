<?php
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email already registered.";
        } else {
            // Hash password and insert
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $hashedPassword])) {
                $success = "Account created successfully! <a href='login.php'>Login here</a>";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | GoClone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background: #f0f2f5;">

    <nav>
        <a href="index.php" class="logo">GoClone<span>.</span></a>
        <div class="nav-links">
            <a href="login.php" class="btn-login">Sign In</a>
        </div>
    </nav>

    <div class="auth-container">
        <h2>Create Account</h2>
        
        <?php if($error): ?>
            <p style="color: var(--error); margin-bottom: 1rem; text-align: center; font-weight: 600;"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <?php if($success): ?>
            <p style="color: var(--success); margin-bottom: 1rem; text-align: center; font-weight: 600;"><?php echo $success; ?></p>
        <?php endif; ?>

        <form action="signup.php" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="John Doe" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="john@example.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-auth">Register Now</button>
        </form>
        
        <p style="text-align: center; margin-top: 1.5rem;">
            Already have an account? <a href="login.php" style="color: var(--primary); text-decoration: none; font-weight: 600;">Sign In</a>
        </p>
    </div>

    <script src="script.js"></script>
</body>
</html>
