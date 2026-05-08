<?php include 'config.php'; include 'header.php'; ?>
<div class="hero">
    <h1>⚡ Laundry Shop Management System</h1>
    <p>Manage customers, services, products, laundry orders, payments, and reports in a modern glassmorphism dashboard with lightning effects.</p>
</div>
<div class="cards">
<?php
$customers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers"))['total'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM services"))['total'];
$products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM products"))['total'];
$orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders"))['total'];
$sales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS total FROM payments WHERE payment_status='Paid'"))['total'];
?>
<div class="card"><h3>👥 Customers</h3><p><?php echo $customers; ?></p></div>
<div class="card"><h3>🧼 Services</h3><p><?php echo $services; ?></p></div>
<div class="card"><h3>🛒 Products</h3><p><?php echo $products; ?></p></div>
<div class="card"><h3>📦 Orders</h3><p><?php echo $orders; ?></p></div>
<div class="card"><h3>💰 Total Paid Sales</h3><p>₱<?php echo number_format($sales,2); ?></p></div>
</div>

<h1 style="margin-top:28px">Featured Laundry Products</h1>
<div class="product-grid">
<?php $res = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT 4"); while($row=mysqli_fetch_assoc($res)): ?>
<div class="card product-card">
    <div class="emoji"><?php echo $row['icon']; ?></div>
    <span class="tag"><?php echo $row['category']; ?></span>
    <h3><?php echo $row['product_name']; ?></h3>
    <p class="price">₱<?php echo number_format($row['price'],2); ?></p>
    <small>Stock: <?php echo $row['stock']; ?></small>
</div>
<?php endwhile; ?>
</div>
<?php include 'footer.php'; ?>
