<?php
$servername = "localhost"; 
$username = "root";        
$password = "";       
$dbname = "projekt";       

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$country_id = $_POST['country'];
$city = $_POST['city'];
$street = $_POST['street'];
$dob = $_POST['dob'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$sql = "INSERT INTO users (ime, prezime, email, država, grad, ulica, datumRodenja, lozinka) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $first_name, $last_name, $email, $country_id, $city, $street, $dob, $password);

if ($stmt->execute()) {
    session_start(); 
    $user_id = $conn->insert_id; 

    $_SESSION['user_id'] = $user_id;
    $_SESSION['is_approved'] = $is_approved;

    header("Location: index.php"); 
    exit; 
} else {
    echo "<script>showAlert('Greška prilikom registracije: " . addslashes($stmt->error) . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
