<?php
require_once VIEWS . '/layouts/app.php';
?>
<main>
    <div>
        <h1>Пользователи</h1>
        <?php foreach($users as $user): ?>
        <div>
            <h2><?=$user['username']?></h2>
            <p><?=$user['email']?></p>
        </div>
        <?php endforeach;?>
    </div>
</main>
