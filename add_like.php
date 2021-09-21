<?php

session_start();

include "inc/db.php";

// tester le passage de parametre dans l'url directement
if (empty($_GET)) {
    $message = "Manipulation interdite !";
    header("HTTP/1.1 404 Not Found");
    include("404.php");
    die();
} elseif (!isset($_GET["id"])) {
    $message = "Manipulation interdite !";
    header("HTTP/1.1 404 Not Found");
    include("404.php");
    die();
}

// recuperer l'id passé en paramètre dans la chaine d'interrogation de la requete

$id = $_GET["id"];

// recuperer les informations de cet utilisateur
$tweet = selectTweetById($id);

if (!isset($tweet)) {
    $message = "Manipulation interdite !";
    header("HTTP/1.1 404 Not Found");
    include("404.php");
    die();
}

incrementLikesTweet($id);

// Permet de récupèrer la page actuelle et rediriger vers cette page
header("Location: " . $_SERVER["HTTP_REFERER"]);
die();

?>
