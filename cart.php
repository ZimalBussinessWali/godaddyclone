<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle remove from cart
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    array_splice($_SESSION['cart'], $_GET['remove'], 1);
    header('Location: cart.php');
    exit;
}

// Handle checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    // Move items from cart to registered domains
    if (!isset($_SESSION['domains'])) {
        $_SESSION['domains'] = [];
    }
    
    foreach ($_SESSION['cart'] as $item) {
        $_SESSION['domains'][] = [
            'domain' => $item['domain'],
            'expiry_date' => date('Y-m-d', strtotime('+1 year')),
            'price' => $item['price']
        ];
    }
    
    $_SESSION['cart'] = [];
    header('Location: dashboard.php?registered=true');
    exit;
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - DomainHub</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <h1>🌐 DomainHub</h1>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="cart.php">Cart (<?php echo count($_SESSION['cart']); ?>)</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <section class="cart-section">
            <div class="container">
                <h2>Shopping Cart</h2>
                
                <?php if (empty($_SESSION['cart'])): ?>
                    <div class="empty-cart">
                        <p>Your cart is empty.</p>
                        <a href="index.php" class="btn-primary">Search Domains</a>
                    </div>
                <?php else: ?>
                    <div class="cart-items">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['domain']); ?></td>
                                    <td>$<?php echo number_format($item['price'], 2); ?>/year</td>
                                    <td><a href="cart.php?remove=<?php echo $index; ?>" class="btn-remove">Remove</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td><strong>Total</strong></td>
                                    <td><strong>$<?php echo number_format($total, 2); ?>/year</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <div class="checkout-section">
                            <form method="POST">
                                <button type="submit" name="checkout" class="btn-checkout">Proceed to Checkout</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 DomainHub. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>



