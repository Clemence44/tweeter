<?php

session_start();

include "inc/db.php";

    // tester le passage de parametre dans l'url directement
    if(empty($_GET)){
        $message = "Manipulation interdite !";
        header("HTTP/1.1 404 Not Found");
        include("404.php");
        die();
    }elseif (!isset($_GET["user_id"])){
        $message = "Manipulation interdite !";
        header("HTTP/1.1 404 Not Found");
        include("404.php");        die();
    }

    // recuperer l'id passé en paramètre dans la chaine d'interrogation de la requete
    $userId = $_GET["user_id"];

    // recuperer les informations de cet utilisateur
    $user = selectUserById($userId);

    if (!isset($user)){
        $message = "Manipulation interdite !";
        header("HTTP/1.1 404 Not Found");
        include("404.php");
        die();
    }

    $tweets = selectUserTweets($userId);

?>

<!-- Fragment php partie : top -->
<?php include "inc/top.php"; ?>

<div class="section">
    <div class="container has-text-centered">
        <h2 class="title is-4">Profil de <?=$user["username"]?></h2>
        <p><?= !empty ($user["bio"]) ? "Biographie : " . $user["bio"] : "" ?></p>
    </div>
</div>

<!-- Fragment php partie : tweet -->
<?php include "inc/show_tweet.php"; ?>

<!-- Fragment php partie : botom -->
<?php include "inc/bottom.php"; ?>
