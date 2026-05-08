<?php include 'config.php'; include 'header.php';
if (isset($_GET['delete'])) { $id=intval($_GET['delete']); mysqli_query($conn,"DELETE FROM orders WHERE id=$id"); }
if (isset($_POST['update_status'])) { $id=intval($_POST['order_id']); $status=mysqli_real_escape_string($conn,$_POST['status']); mysqli_query($conn,"UPDATE orders SET status='$status' WHERE id=$id"); }
?>
<h1>Orders</h1>
<p><a class="btn" href="add_order.php">Add New Order</a></p>
<table><tr><th>ID</th><th>Customer</th><th>Service</th><th>Weight</th><th>Total</th><th>Status</th><th>Order Date</th><th>Pickup Date</th><th>Action</th></tr>
<?php
$sql="SELECT orders.*, customers.customer_name, services.service_name FROM orders JOIN customers ON orders.customer_id=customers.id JOIN services ON orders.service_id=services.id ORDER BY orders.id DESC";
$res=mysqli_query($conn,$sql); while($row=mysqli_fetch_assoc($res)):
?>
<tr>
<td><?php echo $row['id']; ?></td><td><?php echo $row['customer_name']; ?></td><td><?php echo $row['service_name']; ?></td><td><?php echo $row['weight']; ?> kg</td><td>₱<?php echo number_format($row['total_amount'],2); ?></td>
<td><form method="POST"><input type="hidden" name="order_id" value="<?php echo $row['id']; ?>"><select name="status" onchange="this.form.submit()"><option <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option><option <?php if($row['status']=='Washing') echo 'selected'; ?>>Washing</option><option <?php if($row['status']=='Drying') echo 'selected'; ?>>Drying</option><option <?php if($row['status']=='Ready') echo 'selected'; ?>>Ready</option><option <?php if($row['status']=='Claimed') echo 'selected'; ?>>Claimed</option></select><input type="hidden" name="update_status" value="1"></form></td>
<td><?php echo $row['order_date']; ?></td><td><?php echo $row['pickup_date']; ?></td><td><a class="danger" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete order?')">Delete</a></td>
</tr>
<?php endwhile; ?></table>
<?php include 'footer.php'; ?>
