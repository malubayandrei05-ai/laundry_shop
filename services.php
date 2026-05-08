<?php include 'config.php'; include 'header.php';
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $price = floatval($_POST['price_per_kg']);
    mysqli_query($conn, "INSERT INTO services(service_name, price_per_kg) VALUES('$name','$price')");
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM services WHERE id=$id");
}
?>
<h1>Services</h1>
<form method="POST" class="form-row">
    <input name="service_name" placeholder="Service Name" required>
    <input type="number" step="0.01" name="price_per_kg" placeholder="Price per KG" required>
    <button name="add">Add Service</button>
</form>
<table><tr><th>ID</th><th>Service</th><th>Price/KG</th><th>Action</th></tr>
<?php $res = mysqli_query($conn, "SELECT * FROM services ORDER BY id DESC"); while($row=mysqli_fetch_assoc($res)): ?>
<tr><td><?php echo $row['id']; ?></td><td><?php echo $row['service_name']; ?></td><td>₱<?php echo number_format($row['price_per_kg'],2); ?></td><td><a class="danger" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete service?')">Delete</a></td></tr>
<?php endwhile; ?></table>
<?php include 'footer.php'; ?>
