<?php

//préviens php que je vais utiliser les sessions
//cette fonction doit être appelée avant tout echo, var_dump(), html
session_start();

include "inc/db.php";

//la variable $_SESSION contient toytes les infos de sessions
//c'est un tableau associatif

/*
//si c'est la 1ère visite...
if(empty($_SESSION["pageHomeView"])){
    $_SESSION["pageHomeView"] =1;
}else {
    $_SESSION["pageHomeView"] ++;
}

//suppression de cette seule donnée de la session
unset($_SESSION["pageHomeView"]);

//suppression de toutes les onnées de la session
session_destroy();
*/


$tweets = select10LastTweets();
?>


<!-- Fragment php partie : top -->
<?php include "inc/top.php"; ?>

<main class="section">
    <div class="container has-text-centered">
        <img src="img/imageTweeter.jpg" class="imgBottom" alt="image principale">

    </div>

    <div class="container">
        <h3 class="title is-4">Les 10 derniers tweets</h3>
        <!-- Fragment php partie : tweet -->
        <?php include "inc/show_tweet.php"; ?>

        </div>
</main>

<!-- Fragment php partie : botom -->
<?php include "inc/bottom.php"; ?>
