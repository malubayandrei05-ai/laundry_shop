<?php

include 'config.php';

$method = $_SERVER['REQUEST_METHOD'];


// GET ALL USERS
if ($method == 'GET') {

    $sql = "SELECT * FROM users ORDER BY user_id DESC";
    $result = $conn->query($sql);

    $users = [];

    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $users
    ]);
}



// ADD USER
if ($method == 'POST') {

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(fullname, username, password, role)
            VALUES('$fullname', '$username', '$hashedPassword', '$role')";

    if($conn->query($sql)) {

        echo json_encode([
            "success" => true,
            "message" => "User added successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to add user"
        ]);
    }
}



// UPDATE USER
if ($method == 'PUT') {

    parse_str(file_get_contents("php://input"), $_PUT);

    $user_id = $_PUT['user_id'];
    $fullname = $_PUT['fullname'];
    $username = $_PUT['username'];
    $role = $_PUT['role'];

    $sql = "UPDATE users
            SET fullname='$fullname',
                username='$username',
                role='$role'
            WHERE user_id='$user_id'";

    if($conn->query($sql)) {

        echo json_encode([
            "success" => true,
            "message" => "User updated successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to update user"
        ]);
    }
}



// DELETE USER
if ($method == 'DELETE') {

    parse_str(file_get_contents("php://input"), $_DELETE);

    $user_id = $_DELETE['user_id'];

    $sql = "DELETE FROM users WHERE user_id='$user_id'";

    if($conn->query($sql)) {

        echo json_encode([
            "success" => true,
            "message" => "User deleted successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to delete user"
        ]);
    }
}

?>