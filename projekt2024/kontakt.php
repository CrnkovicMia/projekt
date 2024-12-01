<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $description = $_POST['description'];


    $formSubmitted = true; 
}
?>

<!DOCTYPE html>
<html lang="hr">

<head>
    <link rel="stylesheet" href="kontakt.css">
    <title>Projekt2024</title>
</head>

<body>
    <main>
        <section>
            <h2>Naša lokacija</h2>

            <p>Posjetite nas na našoj lokaciji. Kliknite na kartu ispod za više informacija:</p>
            <div id="googleMap" style="width:100%;height:400px;"></div>

            <script>
                function myMap() {
                    var mapProp = {
                        center: new google.maps.LatLng(51.508742, -0.120850),
                        zoom: 5,
                    };
                    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                }
            </script>

            <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
        </section>

        <section>
            <h2>Kontaktirajte nas putem forme</h2>

            <form action="kontakt.php" method="post" novalidate>

                <label for="first-name">Ime (obavezno):</label>
                <input type="text" id="first-name" name="first-name" placeholder="Unesite ime" required>

                <label for="last-name">Prezime (obavezno):</label>
                <input type="text" id="last-name" name="last-name" placeholder="Unesite prezime" required>

                <label for="email">E-mail adresa (obavezno):</label>
                <input type="email" id="email" name="email" placeholder="Unesite e-mail adresu" required>

                <label for="country">Država:</label>
                <select id="country" name="country">
                    <option value="hr">Hrvatska</option>
                    <option value="si">Slovenija</option>
                    <option value="rs">Srbija</option>
                    <option value="ba">Bosna i Hercegovina</option>
                    <option value="other">Ostalo</option>
                </select>

                <label for="description">Opis poruke:</label>
                <textarea id="description" name="description" rows="5" placeholder="Napišite svoju poruku"></textarea>

                <button type="submit">Pošalji</button>
            </form>
        </section>
    </main>

    <?php if (isset($formSubmitted) && $formSubmitted): ?>
        <script>
            
            alert('Forma je proslana');
            
          
            setTimeout(function() {
                window.location.href = "index.php";
            }, 2000); 
        </script>
    <?php endif; ?>

</body>

</html>
