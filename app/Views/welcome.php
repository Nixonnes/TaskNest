<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title ?? 'Главная'?></title>
    <link rel="stylesheet" href="<?=PATH?>/assets/css/css.css">
</head>
<body>
<div class="wrapper">
    <div class="app">
        <header>
            <div>
                <nav>
                    <ul>
                        <li>О нас</li>
                        <li>Цены</li>
                        <li>Поддержка</li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <div class="hero">
                <h1 class="hero_head">
                    <span class="task">Task</span><span class="nest">Nest</span>
                </h1>
                <p class="hero_text">Место, где задачи превращаются в достижения!</p>
                <div class="cta-container">
                    <button class="cta-button register">Регистрация</button>
                    <button class="cta-button login">Войти</button>
                </div>
            </div>
        </main>

    </div>
</div>
</body>
</html>