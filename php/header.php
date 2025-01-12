<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <title>IMDb2</title>
</head>
<body>
<header>
    <div class="nav-links">
        <a href="index.php" class="index">Főoldal</a>
    </div>
    <div class="logo-container">
        <img alt="Norris" class="kep" src="../img/header.png">
        <a class="title" href="index.php">IMDb2</a>
    </div>
    <div class="user-actions">
        <?php if (isset($_SESSION['felhasznalonev'])){ ?>
            <a href="../functions/kijelentkezes.php" class="login-link">Kijelentkezés</a>
        <?php } else { ?>
            <a href="bejreg.php" class="login-link">Bejelentkezés / Regisztráció</a>
        <?php } ?>
    </div>
</header>
</body>
</html>

