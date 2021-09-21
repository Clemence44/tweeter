<?php foreach ($tweets as $tweet) :?>
    <article class="media box">
        <figure class="media-left">
            <p class="image is-64x64">
                <img src="https://bulma.io/images/placeholders/128x128.png">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>
                    <a href="detail_profil.php?user_id=<?=$tweet["user_id"]?>">
                        <strong><?= $tweet["username"] ?></strong> <small><?=$tweet["email"]?></small>
                    </a>
                    <br>
                    <?= $tweet["message"] ?>
                </p>
            </div>
            <nav class="level is-mobile">
                <div class="level-left">
                    <a class="level-item">
                        <span class="icon is-small"><i class="fas fa-reply"></i></span>
                    </a>
                    <a class="level-item">
                        <span class="icon is-small"><i class="fas fa-retweet"></i></span>
                    </a>
                    <a href="add_like.php?id=<?=$tweet["id"]?>" class="level-item">
                        <span class="icon is-small"><i class="fas fa-heart"></i><?=$tweet["likes_quantity"]?></span>
                    </a>
                </div>
            </nav>
        </div>
    </article>
<?php endforeach;?>