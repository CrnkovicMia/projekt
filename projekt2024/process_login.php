<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; 
$username = "root";        
$password = "";       
$dbname = "projekt";       

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];


$sql = "SELECT id, lozinka, role_id, is_approved FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($user_id, $hashed_password, $role_id, $is_approved); 
$stmt->fetch();

if ($hashed_password && password_verify($password, $hashed_password)) {
  
    if ($is_approved == 0) {
        echo "<script>alert('Vaš račun još nije odobren od strane administratora. Molimo pokušajte kasnije.'); window.history.back();</script>";
        exit; 
    }

   
    session_start();
    $_SESSION['user_id'] = $user_id; 
    $_SESSION['role_id'] = $role_id;  
    $_SESSION['is_approved'] = $is_approved;
    $_SESSION['email'] = $email;

   
    header("Location: index.php");
    exit;
} else {
 
    echo "<script>alert('Neispravni podaci za prijavu.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
