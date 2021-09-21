<?php
session_start();

// supprime la session du user
unset($_SESSION["user"]);

$_SESSION["flashMessage"] = ["Vous êtes déconnectés","success"];

// Redirige vers connexion
header("Location: connexion.php");
die();