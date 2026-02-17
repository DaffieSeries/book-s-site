<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Личный кабинет</title>


<style>

html, body {
    height: 100%;
}

body {
    margin: 0;
    display: flex;
    flex-direction: column;
    font-family: 'Georgia', serif;
    background: #f7f5f2;
    color: #2c2c2c;
}

main {
    flex: 1;
    display: flex;
    flex-direction: column;
}


/* ЗАГОЛОВОК */
.page-title {
    padding: 60px 40px 10px;
    font-size: 32px;
    font-weight: 500;
}

/* ОБЁРТКА */
.profile-wrapper {
    max-width: 1000px;
    margin: 30px auto 80px;
    padding: 0 40px;
}

/* КАРТОЧКА */
.profile-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 50px;
    display: flex;
    gap: 50px;
    align-items: center;
    box-shadow: 0 12px 35px rgba(0,0,0,0.06);
    opacity: 0;
    transform: translateY(20px);
    animation: fadeIn 0.6s ease forwards;
}

@keyframes fadeIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* АВАТАР */
.profile-avatar {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    background: #5a4b3c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 60px;
    color: white;
    letter-spacing: 2px;
}

/* ИНФО */
.profile-info {
    flex: 1;
}

.profile-info h2 {
    margin: 0 0 25px 0;
    font-weight: 500;
    font-size: 28px;
}

.profile-info p {
    font-size: 16px;
    margin-bottom: 12px;
    color: #555;
}

/* КНОПКИ */
.profile-actions {
    margin-top: 30px;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.profile-btn {
    padding: 12px 22px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 15px;
    transition: 0.3s;
}

.primary-btn {
    background: #5a4b3c;
    color: white;
}

.primary-btn:hover {
    background: #3e3328;
}

.secondary-btn {
    background: #ece7df;
    color: #5a4b3c;
}

.secondary-btn:hover {
    background: #ddd6cb;
}

/* БЛОК СТАТИСТИКИ */
.profile-stats {
    margin-top: 40px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 20px;
}

.stat-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.04);
}

.stat-card h3 {
    margin: 0;
    font-size: 22px;
}

.stat-card p {
    margin-top: 6px;
    font-size: 14px;
    color: #777;
}

@media (max-width: 768px) {
    .profile-card {
        flex-direction: column;
        text-align: center;
        padding: 40px 25px;
    }
}

</style>
</head>

<body>

<?php include "includes/header.php"; ?>

<main>

<h2 class="page-title">Личный кабинет</h2>

<div class="profile-wrapper">

    <div class="profile-card">

        <div class="profile-avatar">
            <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
        </div>

        <div class="profile-info">
            <h2><?php echo $user['username']; ?></h2>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>

            <div class="profile-actions">
                <a href="/cart/cart.php" class="profile-btn secondary-btn">
                    Моя корзина
                </a>

                <a href="/auth/logout.php" class="profile-btn primary-btn">
                    Выйти
                </a>
            </div>
        </div>

    </div>

    <!-- Блок можно потом подключить к реальным данным -->
    <div class="profile-stats">
        <div class="stat-card">
            <h3>0</h3>
            <p>Заказов</p>
        </div>

        <div class="stat-card">
            <h3>0</h3>
            <p>Книг куплено</p>
        </div>

        <div class="stat-card">
            <h3>0 ₽</h3>
            <p>Общая сумма</p>
        </div>
    </div>

</div>

</main>

<?php include "includes/footer.php"; ?>

</body>
</html>
