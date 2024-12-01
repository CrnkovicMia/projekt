<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_name'] !== 'Admin') {
    header("Location: index.php");
    exit;
}

$user_id = $_GET['user_id'];
$new_role = $_POST['role'];  

$servername = "localhost"; 
$username = "root";        
$password = "";       
$dbname = "projekt";       
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE users SET role_id = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $new_role, $user_id);

if ($stmt->execute()) {
    echo "Role updated successfully.";
    header("Location: admin.php"); 
    exit;
} else {
    echo "Error updating role: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
