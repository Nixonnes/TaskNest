<?php
require_once VIEWS . '/layouts/app.php';
?>
<div class="auth-app">
    <div class="sidebar">
        <div>
            <a href="/tasks">Мои задачи</a>
        </div>
    </div>

<main class="main">
    <div>
        <h1>Список задач</h1>
            <div>
                <h2><?=$tasks?></h2>
            </div>
    </div>
</main>
</div>
