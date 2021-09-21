<?php

session_start();

include "inc/db.php";
//Traitement du formulaire en haut du fichier
// initialiser le taleau d'erreurs
$errors =[];

if (!empty($_GET)){
    $message = "Manipulation interdite !";
        header("HTTP/1.1 404 Not Found");
        include("404.php");
        die();
}

// 1- mon formulaire est-il soumis ?
//var_dump($_POST);
if(!empty($_POST)){
    // 2- formulaire est soumis donc ... on recupere les données dans nos propres variables
    $email = strip_tags($_POST["email"]);
    $username = strip_tags($_POST["username"]);
    $password = $_POST["password"];
    $bio = strip_tags($_POST["bio"]);

    // 3- validation des données
    // l'email est requis ... est-il vide ?
    if(empty($email)){
        $errors["email"] = "Veuillez saisir un email svp";
    // est-ce que le format de l'email est valide
    }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors["email"] = "Votre email : $email n'est pas valide";
    }

    // todo : vérifier l'unicité de l'email avec une requête SELECT à la BDD
    elseif(selectUserByEmail($email)){
        $errors["email"] = "L'email renseignée existe déja";
    }

    // username requis
    if(empty($username)){
        $errors["username"] = "Veuillez saisir un psuedo svp";
        // longueur minimal 3 caracteres
    }elseif(mb_strlen($username) < 3){
        $errors["username"] = "3 caractères minimum svp";
        // longueur maximal 30 caracteres
    }elseif(mb_strlen($username) > 30){
        $errors["username"] = "30 caractères maximum svp";
    }

    // todo : vérifier l'unicité du pseudo avec une requête SELECT à la BDD
    elseif(selectUserByUsername($username)){
        $errors["username"] = "Le pseudo renseigné existe déja";
    }

    // controler la saisie du mot de passe
    $regex = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{12,}$/";
    if (!preg_match($regex,$password)){
        $errors["password"] = "Au moins 1 lettre, 1 chiffre et sur 12 caractères svp";
    }

    // pour la bio, champ facultatif
    var_dump($errors);

    // 4- Y-a-t-il des erreurs
    if(empty($errors)){

        // hasher le mot de passe
        $hash = password_hash($password,PASSWORD_DEFAULT, [
                "cost" => 14
        ]);

        // 5- S'il n'y a pas d'erreurs alors ... création du compte en BDD
        // todo : requete INSERT en BDD
        insertUser($email, $username,$hash,$bio);

        $_SESSION["flashMessage"] =["Bienvenue sur Tweeter !", "success"];

        // Je met mon utilisateur en session
        $user = selectUserByUsername($username);
        $_SESSION["user"] =[$user["id"],$user["username"], $user["email"], $user["bio"]];
        var_dump($_SESSION);

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

<main class="section">
    <div class="container">
        <h2 class="title is-4"> Créer mon compte </h2>
        <div class="box">
            <form method="post" novalidate>
                <div class="field">
                    <label for="email_input">Votre email</label>
                    <div class="control">
                        <input name="email" value="<?= isset($email) ? $email : "" ?>" type="email" class="input <?= !empty($errors["email"]) ? "is-danger" : ""?>" id="email_input" placeholder="abc@def.fr">
                    </div>
                    <?php if (!empty($errors["email"])) :?>
                    <p class="help is-danger"><?=$errors["email"]?></p>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label for="username_input">Votre pseudo</label>
                    <div class="control">
                        <input name="username" value="<?= $username ?? "" ?>" type="text" class="input <?= !empty($errors["username"]) ? "is-danger" : ""?>" id="username_input" placeholder="clemence">
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
                    <label for="bio_input">Votre biographie</label>
                    <div class="control">
                        <textarea name="bio" class="textarea <?= !empty($errors["bio"]) ? "is-danger" : ""?>" id="bio_input" placeholder="que la vie est belle"><?= $bio ?? "" ?></textarea>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-success is-light">Créer mon compte</button>
                    </div>
                    <?php if (!empty($errors["bio"])) :?>
                        <p class="help is-danger"><?=$errors["bio"]?></p>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Fragment php partie : botom -->
<?php include "inc/bottom.php"; ?>
