<?php include 'config.php'; include 'header.php';
if (isset($_POST['save'])) {
    $customer_id=intval($_POST['customer_id']);
    $service_id=intval($_POST['service_id']);
    $weight=floatval($_POST['weight']);
    $pickup_date=mysqli_real_escape_string($conn,$_POST['pickup_date']);
    $service=mysqli_fetch_assoc(mysqli_query($conn,"SELECT price_per_kg FROM services WHERE id=$service_id"));
    $total=$weight * $service['price_per_kg'];
    mysqli_query($conn,"INSERT INTO orders(customer_id, service_id, weight, total_amount, status, order_date, pickup_date) VALUES($customer_id,$service_id,$weight,$total,'Pending',CURDATE(),'$pickup_date')");
    header('Location: orders.php'); exit;
}
?>
<h1>Add Order</h1>
<form method="POST" class="box-form">
<label>Customer</label><select name="customer_id" required><?php $c=mysqli_query($conn,"SELECT * FROM customers"); while($r=mysqli_fetch_assoc($c)): ?><option value="<?php echo $r['id']; ?>"><?php echo $r['customer_name']; ?></option><?php endwhile; ?></select>
<label>Service</label><select name="service_id" required><?php $s=mysqli_query($conn,"SELECT * FROM services"); while($r=mysqli_fetch_assoc($s)): ?><option value="<?php echo $r['id']; ?>"><?php echo $r['service_name']; ?> - ₱<?php echo $r['price_per_kg']; ?>/kg</option><?php endwhile; ?></select>
<label>Weight KG</label><input type="number" step="0.01" name="weight" required>
<label>Pickup Date</label><input type="date" name="pickup_date" required>
<button name="save">Save Order</button>
</form>
<?php include 'footer.php'; ?>
