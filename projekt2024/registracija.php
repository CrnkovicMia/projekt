<?php
$servername = "localhost"; 
$username = "root";        
$password = "";       
$dbname = "projekt";       

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$countries = [];
$sql = "SELECT id, name FROM countries"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $countries[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="hr">
<head>
<head>
    <link rel="stylesheet" href="kontakt.css">
    <title>Projekt2024</title>
</head>
</head>
<body>
    <main>
<h1>Registracija</h1>
<form action="process_registration.php" method="POST">
    <label for="first_name">Ime:</label>
    <input type="text" id="first_name" name="first_name" required><br>

    <label for="last_name">Prezime:</label>
    <input type="text" id="last_name" name="last_name" required><br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="country">Država:</label>
    <select id="country" name="country" required>
        <option value="">Odaberite državu</option>
        <?php foreach ($countries as $country): ?>
            <option value="<?= $country['id'] ?>"><?= htmlspecialchars($country['name']) ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="city">Grad:</label>
    <input type="text" id="city" name="city" required><br>

    <label for="street">Ulica:</label>
    <input type="text" id="street" name="street" required><br>

    <label for="dob">Datum rođenja:</label>
    <input type="date" id="dob" name="dob" required><br>

    <label for="password">Lozinka:</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">Registriraj se</button>
</form>
</main>
</body>
</html>

