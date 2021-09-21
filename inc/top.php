<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tweeter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/favicon.png">
</head>
<body>
<header class="section">
    <div class="container has-text-centered">
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="index.php">
                <img src="img/logo.png">
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="index.php">
                    Home
                </a>

                <a class="navbar-item <?= empty($_SESSION["user"]) ? "is-hidden" : "" ?>" href="tweet.php">
                    Poster un message
                </a>
            </div>

            <div class="navbar-end">

                <a class=" navbar-item button is-info is-light <?= !empty($_SESSION["user"]) ? "is-hidden" : "" ?>" href="inscription.php">
                    <strong>Inscription</strong>
                </a>
                <a class="navbar-item button is-success is-light <?= !empty($_SESSION["user"]) ? "is-hidden" : "" ?>" href="connexion.php">
                    Connexion
                </a>
                <a class="navbar-item button is-success is-light <?= empty($_SESSION["user"]) ? "is-hidden" : "" ?>" href="logout.php">
                    Déconnexion (<?= $_SESSION["user"]["username"]?>)
                </a>

            </div>
        </div>
    </nav>
    </div>
</header>

<?php if(!empty($_SESSION["flashMessage"])) : ?>
<div class="container">
    <div class="notification has-text-centered is-<?=$_SESSION["flashMessage"][1]?>"> <?=$_SESSION["flashMessage"][0]?></div>
</div>
<?php
    // après avoir affiché le message je le supprime de la session
    unset($_SESSION["flashMessage"]);?>
<?php endif;?>
