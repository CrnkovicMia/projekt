    <header>
        <div class="banner">
            <img src="images/grb.svg" alt="Grb">
        </div>
        <script>
            function showAlert(message) {
                alert(message);
            }
        </script>
        <?php
        session_start();
        ?>

        <nav>
            <ul>
                <li><a href="index.php?section=home">Početna stranica</a></li>
                <li><a href="index.php?section=novosti">Novosti</a></li>
                <li><a href="index.php?section=kontakt">Kontakt</a></li>
                <li><a href="index.php?section=onama">O nama</a></li>
                <li><a href="index.php?section=galerija">Galerija</a></li>
                <li><a href="index.php?section=registracija">Registracija</a></li>
                <li><a href="index.php?section=prijava">Prijava</a></li>
                <?php if (isset($_SESSION['user_id']) && isset($_SESSION['is_approved']) && $_SESSION['is_approved'] == 1): ?>
        <li>
            <a href="logout.php">
                <img src="images/logout-icon.png" alt="Logout" style="width: 20px; height: 20px;">
            </a>
        </li>

        <?php 
        if (isset($_SESSION['role_id']) && ($_SESSION['role_id'] == 1 || $_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 3)): ?>
            <li><a href="novaVijest.php">Nova Vijest</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
            <li><a href="admin.php">Admin Panel</a></li>
        <?php endif; ?>
    <?php endif; ?>

            </ul>
        </nav>

    </header>