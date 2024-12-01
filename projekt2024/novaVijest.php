<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to access this page.";
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dateCreated = date("Y-m-d H:i:s"); 
    if ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2){
    $is_approved = 1;
    } 
    else{
    $is_approved = 0;
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $image_path = 'images/' . basename($image['name']); 

        if (move_uploaded_file($image['tmp_name'], $image_path)) {
        
            $sql = "INSERT INTO news (title, description, image, dateCreated, is_approved) 
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssi', $title, $description, $image_path, $dateCreated, $is_approved);

            if ($stmt->execute()) {
                echo "<script>alert('News added successfully.');</script>";
            } else {
                echo "<script>alert('Error adding news: " . $stmt->error . "');</script>";
            }
        } else {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Projekt NTPWS">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Page</title>
    <style>
       
        form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            background: #f9f9f9;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Submit News</h1>
      
        <form action="novaVijest.php" method="POST" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" rows="5" required></textarea>

            <label for="image">Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <button type="submit">Submit News</button>
        </form>
        <a href="index.php">Naslovnica</a>
</body>
</html>
