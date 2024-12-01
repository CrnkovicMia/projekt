<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projekt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT title, description, image, dateCreated FROM news WHERE is_approved = 1 ORDER BY dateCreated DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <link rel="stylesheet" href="novosti.css">
    <title>Projekt2024</title>
</head>
<body>

    <main>
        <section class="news-section">
            <?php
          
            if ($result->num_rows > 0) {
              
                while ($row = $result->fetch_assoc()) {
                    $image_path = $row['image'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $dateCreated = $row['dateCreated'];

                  
                    echo '<article class="news-item">';
                    echo '<img src="' . $image_path . '" alt="' . $title . '" class="thumbnail">';
                    echo '<h2 class="read-more">' . $title . '</h2>';
                    echo '<p>' . $description . '</p>';
                    echo '<p class="date">' . date("d. F Y", strtotime($dateCreated)) . '</p>';
                    echo '<a href="#" class="read-more">Pročitajte više...</a>';
                    echo '</article>';
                }
            } else {
             
                echo '<p>No approved news available.</p>';
            }

          
            $conn->close();
            ?>
        </section>
    </main>

</body>
</html>
