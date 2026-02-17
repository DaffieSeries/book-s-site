<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<?php include "../includes/header.php"; ?>

<main>

<div class="auth-wrapper">

    <div class="auth-card">
        <h2>Вход в аккаунт</h2>

        <form method="post" action="login_form.php">

            <div class="form-group">
                <label>Почта</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="main-btn">Войти</button>

        </form>

        <p class="auth-link">
            Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
        </p>
    </div>

</div>

</main>

<?php include "../includes/footer.php"; ?>

</body>
</html>
