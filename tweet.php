<?php

session_start();

include "inc/db.php";

// on ne doit pas pouvoir tweeter si on n'est pas connecté
if (empty($_SESSION["user"])){
        header("Location: connexion.php");
    die();
}


// initialiser le taleau d'erreurs
$errors =[];

// on ne doit pas pouvoir envoyer des données en get depuis l'url
if (!empty($_GET)){
    $message = "Manipulation interdite !";
    header("HTTP/1.1 404 Not Found");
    include("404.php");
    die();
}

// formulaire soumis ?
if(!empty($_POST)){
    // récupère notre variable
    $tweet = strip_tags($_POST["tweet"]);

    // validation
    if(empty($tweet)) {
        $errors["tweet"] = "Veuillez rédiger un message svp";
    } elseif (mb_strlen($tweet) < 3){
        $errors["tweet"] = "Veuillez saisir 3 caractères minimum svp";
    } elseif (mb_strlen($tweet) > 255){
        $errors["tweet"] = "Veuillez saisir 255 caractères maximum svp";
}

    var_dump($errors);

    // 4- Y-a-t-il des erreurs
    if(empty($errors)){

        //todo : insérer le message en bdd si le message saisit est valide
        $useId = $_SESSION["user"]["id"];
        insertTweet($tweet,$useId);

        /***** démonstration SELECT
        $result = selectTweetById(1);

        $results = selectAllTweets();
        foreach ($results as $result){

        }
         *****/

        // todo : mettre un message ok en session
        $_SESSION["flashMessage"] =["Merci pour votre tweet !", "success"];

        // 6- Rediriger vers la page d'accueil
        header("Location: index.php");
        // on doit arreter l'éxecution du script
        die();

    } else {
        $_SESSION["flashMessage"] = ["Il y a des erreurs, veuillez les corriger svp","danger"];
    }

}
?>

<!-- Fragment php partie : top -->
<?php include "inc/top.php"; ?>

<!--formulaire de création de tweet -->
<main class="section">
    <div class="container">
        <h2 class="title is-4"> A vous de tweeter ! </h2>
        <div class="box">
            <form method="post">
                <div class="field">
                    <label for="tweet_input" class="label">Votre message</label>
                    <div class="control">
                        <textarea name="tweet" id="tweet_input" class="textarea <?= !empty($errors["tweet"]) ? "is-danger" : ""?>" placeholder="Que la vie est belle aujourd'hui !" ><?= $tweet ?? "" ?></textarea>
                    </div>
                    <?php if (!empty($errors["tweet"])) :?>
                        <p class="help is-danger"><?=$errors["tweet"]?></p>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-success is-light">Envoyer !</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<!-- Fragment php partie : botom -->
<?php include "inc/bottom.php"; ?>
