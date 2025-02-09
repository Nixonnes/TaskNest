<?php
require_once VIEWS . '/layouts/app.php';
?>
<main class="main_reg" >
    <h1><span class="task">Task</span><span class="nest">Nest</span></h1>
    <div class="auth-place">
        <h1 class="reg_header">Авторизация</h1>
        <form action="/login" method="POST">
            <div class="error-message">
                <?php if (isset($_SESSION['error'])): ?>
                    <p style="color: red;"><?php echo $_SESSION['error']; ?></p>
                    <?php unset($_SESSION['error']); // Удаляем ошибку после показа ?>
                <?php endif; ?>
            </div>
            <div class="auth-field">
                <label class="label-text" for="name">Имя пользователя</label>
                <input class="input-text" type="text" name="username" id="name">

            </div>
            <div class="auth-field">
                <label class="label-text" for="password">Пароль</label>
                <input class="input-text" type="password" name="password" id="password">

            </div>
            <div class="to-reg">
                <a href="/register">Еще не зарегистрированы?</a>
            </div>
            <div>
                <button class="primary_btn" type="submit">Войти</button>
            </div>
        </form>
    </div>
</main>
