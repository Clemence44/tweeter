<?php

function connect()
{
    //todo: insérer le message en bdd si le message saisi est valide
    $dbName = "tweeter"; //nom de la base de donnée
    $dbUser = "root"; //nom d'utilisateur MySQL
    $dbPass = ""; //son mot de passe
    $dbHost = "localhost"; //l'adresse ip du serveur mysql

    //ajoutez ;port=8989 à la fin si vous devez spécifier le port de MySQL
    $dsn = "mysql:dbname=$dbName;host=$dbHost;charset=utf8";

    //cette variable $pdo contient notre connexion à la bdd \o/
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
    //affiche les messages d'erreurs SQL
    //repasser à ERRMODE_SILENT en prod !!!!
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    //pour récupérer les données uniquement sous forme de tableau associatif
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    //équivalent à cnx en java
    return $pdo;
}

function insertTweet($message,$user_id){
    $sql = "INSERT INTO tweets (user_id, message, likes_quantity, date_created)
                VALUES(:user_id,:message,0,now());"; //:message protège des attaques SQL
    $pdo = connect();
    $pstmt = $pdo->prepare($sql); // j'informe le serveur mysql que je prépare une requete et lui me renvoie un objet de type PDOStatement
    //$pstmt->bindValue(':message',$message);
    //$pstmt->execute();
    $pstmt->execute([
        ':message' => $message,
        ':user_id'=>$user_id,
    ]);

}

function insertUser($email, $username, $password, $bio){
    $sql = "INSERT INTO users (email, username, password,bio, date_created)
                VALUES(:email, :username, :password,null, now());";
    $sqlWithBio = "INSERT INTO users (email, username, password, bio, date_created)
                VALUES(:email, :username, :password, :bio, now());";

    $pdo = connect();

    if($bio != ''){
        $pstmt = $pdo->prepare($sqlWithBio);
        $pstmt->execute([
            ':email' => $email,
            ':username' => $username,
            ':password' => $password,
            ':bio' => $bio,
        ]);
    }else {
        $pstmt = $pdo->prepare($sql);
        $pstmt->execute([
            ':email' => $email,
            ':username' => $username,
            ':password' => $password,
        ]);
    }
}

function selectTweetById($id){
    $sql = "SELECT * FROM tweets WHERE id= :id ;";
    $pdo = connect();
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute([
        ':id' => $id,
    ]);

    $rs = $pstmt->fetch(); // retourne un tableau associatif
    return $rs;
}

function selectAllTweets(){
    $sql = "SELECT * FROM tweets;";
    $pdo = connect();
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute();

    $rs = $pstmt->fetchAll(); // retourne un tableau indices numériques ordonnés et consécutifs -> chaque indice un tableau associatif
    return $rs;
}

function selectUserByEmail($email){
    $sql = "SELECT * FROM users WHERE email = :email;";
    $pdo = connect();
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute([
        ':email' => $email,
    ]);

    $rs = $pstmt->fetch(); // retourne un tableau associatif
    return $rs ? $rs : null;
}

function selectUserByUsername($username){
    $sql = "SELECT * FROM users WHERE username = :username;";
    $pdo = connect();
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute([
        ':username' => $username,
    ]);

    $rs = $pstmt->fetch(); // retourne un tableau associatif
    return $rs ? $rs : null;
}

function selectUserById($id){
    $sql = "SELECT * FROM users WHERE id = :id;";
    $pdo = connect();
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute([
        ':id' => $id,
    ]);

    $rs = $pstmt->fetch(); // retourne un tableau associatif
    return $rs ? $rs : null;
}

function select10LastTweets(){
    $sql = "SELECT t.*, u.username, u.email FROM tweets t JOIN users u ON t.user_id = u.id ORDER BY date_created DESC LIMIT 5;";
    $pdo = connect();
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute();

    $rs = $pstmt->fetchAll();
    return $rs;
}

function selectUserTweets($id){
    $sql = "SELECT t.*, u.username, u.email, u.bio FROM users u JOIN tweets t ON t.user_id = u.id WHERE u.id= :id ORDER BY date_created DESC LIMIT 100;";
    $pdo = connect();
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute([
        ':id' => $id,
    ]);
    $rs = $pstmt->fetchAll();
    return $rs;
}

function incrementLikesTweet($id){
    $sql = "UPDATE tweets SET likes_quantity = (likes_quantity+1) WHERE id = :id;";
    $pdo = connect();
    $pstmt = $pdo->prepare($sql);
    $pstmt->execute([
        ':id' => $id,
    ]);

}
?>
