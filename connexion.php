<?php

session_start();

include "inc/db.php";
//Traitement du formulaire en haut du fichier
// initialiser le taleau d'erreurs
$errors=false;

// 1- mon formulaire est-il soumis ?
//var_dump($_POST);
if(!empty($_POST)){
    // 2- formulaire est soumis donc ... on recupere les données dans nos propres variables
    $username = strip_tags($_POST["username"]);
    $password = $_POST["password"];

    // 3- validation des données

    // on vérifie qure l'utilisateur existe en BDD
    $user = selectUserByUsername($username);

    if($user == null){
        $errors = true;
    }else {
        (password_verify($password,$user["password"])? $errors = false : $errors= true);
    }

    // 4- Y-a-t-il des erreurs
    if(!$errors){

        $_SESSION["flashMessage"] =["Bienvenue " . $user["username"], "success"];

        $_SESSION["user"] =$user;
        unset($_SESSION["user"]["password"]);

        // 6- Rediriger vers la page d'accueil
        header("Location: index.php");
        // on doit arreter l'éxecution du script
        die();

    } else {
        $_SESSION["flashMessage"] = ["Identifiants incorrects", "danger"];
    }

}
?>

<!-- Fragment php partie : top -->
<?php include "inc/top.php"; ?>

<main class="section">
    <div class="container">
        <h2 class="title is-4"> Connexion </h2>
        <div class="box">
            <form method="post" novalidate>
                <div class="field">
                    <label for="username_input">Votre pseudo</label>
                    <div class="control">
                        <input name="username" value="<?= $username ?? "" ?>" type="text" class="input <?= !empty($errors["username"]) ? "is-danger" : ""?>" id="username_input">
                    </div>
                    <?php if (!empty($errors["username"])) :?>
                        <p class="help is-danger"><?=$errors["username"]?></p>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="password_input">Votre mot de passe</label>
                    <div class="control">
                        <input name="password" type="password" class="input <?= !empty($errors["password"]) ? "is-danger" : ""?>" id="password_input">
                    </div>
                    <?php if (!empty($errors["password"])) :?>
                        <p class="help is-danger"><?=$errors["password"]?></p>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-success is-light">Me connecter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Fragment php partie : botom -->
<?php include "inc/bottom.php"; ?>

