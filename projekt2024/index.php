<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Projekt NTPWS">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="author" content="Mia Crnkovic">
    <link rel="stylesheet" href="main.css">
    <title>Projekt2024</title>
</head>
<body>
<?php include 'header.php'; ?>

<?php
$servername = "localhost"; 
$username = "root";        
$password = "";       
$dbname = "projekt";       

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "<script>console.error('Connection failed: " . addslashes($conn->connect_error) . "');</script>";
} else {
    echo "<script>console.log('Connected successfully');</script>";

    $conn->close();
}
?>

<?php

$section = isset($_GET['section']) ? $_GET['section'] : 'home';

switch ($section) {
    case 'novosti':
        include 'novosti.php';
        break;
    case 'kontakt':
        include 'kontakt.php';
        break;
    case 'onama':
        include 'onama.php';
        break;
    case 'galerija':
        include 'galerija.php';
        break;
    case 'registracija':
        include 'registracija.php';
        break;
    case 'prijava':
        include 'prijava.php';
        break;
    default:
        include 'home.php';
        break;
}

?>

<?php include 'footer.php'; ?>
</body>
</html>
