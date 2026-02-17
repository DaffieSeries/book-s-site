<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<?php include "../includes/header.php"; ?>

<main>

<div class="auth-wrapper">

    <div class="auth-card">
        <h2>Регистрация</h2>

        <form method="post" action="register_form.php">

            <div class="form-group">
                <label>Никнейм</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Почта</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="main-btn">Зарегистрироваться</button>

        </form>

        <p class="auth-link">
            Уже есть аккаунт? <a href="login.php">Войти</a>
        </p>
    </div>

</div>

</main>

<?php include "../includes/footer.php"; ?>

</body>
</html>
