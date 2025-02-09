<?php

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

require_once VIEWS . '/layouts/app.php';
?>
<main class="main_reg" >
    <h1><span class="task">Task</span><span class="nest">Nest</span></h1>
    <div class="reg-place">
    <h1 class="reg_header">Регистрация</h1>
    <form action="/register" method="POST">
        <div class="reg-field">
            <label for="name">Имя пользователя</label>
            <input class="input-text" type="text" name="username" id="name">
            <div class="error-message">
            <?php if (!empty($errors['username'])): ?>
                    <p style="color: red;"><?= htmlspecialchars($errors['username']) ?></p>
            <?php endif; ?>
            </div>
        </div>
        <div class="reg-field">
            <label for="email">Email</label>
            <input class="input-text" type="email" name="email" id="email">
            <div class="error-message">
            <?php if (!empty($errors['email'])): ?>
                    <p style="color: red;"><?= htmlspecialchars($errors['email']) ?></p>
            <?php endif; ?>
            </div>
        </div>
        <div class="reg-field">
            <label for="password">Пароль</label>
            <input class="input-text" type="password" name="password" id="password">
            <div class="error-message">
            <?php if (!empty($errors['password'])): ?>
                    <p style="color: red;"><?= htmlspecialchars($errors['password']) ?></p>
            <?php endif; ?>
            </div>
        </div>
        <div class="reg-field">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input class="input-text" type="password" name="password_confirmation" id="password_confirmation">

        </div>
        <div >
            <button class="primary_btn" type="submit">Регистрация</button>
        </div>
    </form>
    </div>
</main>
