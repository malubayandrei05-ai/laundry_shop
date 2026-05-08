<?php include 'config.php'; include 'header.php';
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    mysqli_query($conn, "INSERT INTO customers(customer_name, contact_number, address) VALUES('$name','$contact','$address')");
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM customers WHERE id=$id");
}
?>
<h1>Customers</h1>
<form method="POST" class="form-row">
    <input name="customer_name" placeholder="Customer Name" required>
    <input name="contact_number" placeholder="Contact Number">
    <input name="address" placeholder="Address">
    <button name="add">Add Customer</button>
</form>
<table><tr><th>ID</th><th>Name</th><th>Contact</th><th>Address</th><th>Action</th></tr>
<?php $res = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC"); while($row=mysqli_fetch_assoc($res)): ?>
<tr><td><?php echo $row['id']; ?></td><td><?php echo $row['customer_name']; ?></td><td><?php echo $row['contact_number']; ?></td><td><?php echo $row['address']; ?></td><td><a class="danger" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete customer?')">Delete</a></td></tr>
<?php endwhile; ?></table>
<?php include 'footer.php'; ?>
