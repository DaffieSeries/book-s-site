<?php
session_start();
include "../config.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: /cart/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// обновление кол. товара +-
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    $book_id = intval($_POST['book_id']);
    $action = $_POST['action'];

    $check = mysqli_query($conn, 
        "SELECT quantity FROM cart WHERE user_id='$user_id' AND book_id='$book_id'"
    );

    if($row = mysqli_fetch_assoc($check)) {

        $quantity = $row['quantity'];

        if($action === "plus") {
            $quantity++;
        }

        if($action === "minus" && $quantity > 1) {
            $quantity--;
        }

        mysqli_query($conn, 
            "UPDATE cart SET quantity='$quantity' 
             WHERE user_id='$user_id' AND book_id='$book_id'"
        );
    }

    header("Location: cart.php");
    exit();
}


$query = "SELECT books.title, books.price, books.image, cart.quantity, books.id
          FROM cart
          JOIN books ON cart.book_id = books.id
          WHERE cart.user_id='$user_id'";

$result = mysqli_query($conn, $query);

$total = 0;
$total_items = 0;
$has_items = mysqli_num_rows($result) > 0;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Корзина</title>

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

.page-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* ЗАГОЛОВОК */
.page-title {
    padding: 50px 40px 10px;
    font-size: 32px;
    font-weight: 500;
}

/* ОСНОВНАЯ СЕТКА */
.cart-wrapper {
    display: grid;
    grid-template-columns: 3fr 1fr;
    gap: 40px;
    padding: 30px 40px 60px;
}

/* ЛЕВАЯ ЧАСТЬ */
.cart-items {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* КАРТОЧКА */
.cart-item {
    display: grid;
    grid-template-columns: 100px 1fr auto auto;
    gap: 20px;
    align-items: center;
    background: #ffffff;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
    opacity: 0;
    transform: translateY(15px);
    animation: fadeIn 0.5s ease forwards;
}

@keyframes fadeIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.cart-image {
    width: 100px;
    height: 140px;
    object-fit: cover;
    border-radius: 8px;
}

/* НАЗВАНИЕ */
.cart-title {
    font-size: 18px;
}

/* КОЛИЧЕСТВО */
.quantity-form {
    display: flex;
    align-items: center;
    gap: 8px;
}

.quantity-form button {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    border: 1px solid #ddd;
    background: #fafafa;
    cursor: pointer;
    font-size: 16px;
}

.quantity-form button:hover {
    background: #ece7df;
}

.quantity-number {
    min-width: 20px;
    text-align: center;
}

/* ЦЕНА */
.cart-price {
    font-weight: 600;
    font-size: 18px;
}

/* УДАЛИТЬ */
.remove-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 18px;
}

/* ПРАВАЯ ПАНЕЛЬ */
.checkout {
    background: #ffffff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
    height: fit-content;
}

.checkout h3 {
    margin-top: 0;
    font-weight: 500;
}

.checkout button {
    width: 100%;
    padding: 14px;
    margin-top: 20px;
    background: #5a4b3c;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 15px;
    transition: 0.3s;
}

.checkout button:hover {
    background: #3e3328;
}

/* ПУСТОЕ СОСТОЯНИЕ */
.empty-state {
    background: #ffffff;
    padding: 80px 20px;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.05);
}

.empty-state h3 {
    font-weight: 500;
    margin-bottom: 10px;
}

.empty-state a {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    border-radius: 8px;
    background: #5a4b3c;
    color: white;
    text-decoration: none;
}

.empty-state a:hover {
    background: #3e3328;
}

.back-btn {
    display: inline-block;
    margin: 30px 40px 0;
    text-decoration: none;
    color: #5a4b3c;
}

</style>

</head>

<body>

<?php include "../includes/header.php"; ?>

<div class="page-content">

<a href="../index.php" class="back-btn">← На главную</a>

<h2 class="page-title">Ваша корзина</h2>

<?php if(!$has_items): ?>

<div style="padding: 30px 40px 60px;">
    <div class="empty-state">
        <h3>Корзина пока пуста</h3>
        <p>Самое время выбрать что-нибудь уютное для чтения 📖</p>
        <a href="../index.php">Перейти к книгам</a>
    </div>
</div>

<?php else: ?>

<div class="cart-wrapper">

<div class="cart-items">

<?php 
while($row = mysqli_fetch_assoc($result)) { 
    $sum = $row['price'] * $row['quantity'];
    $total += $sum;
    $total_items += $row['quantity'];
?>

<div class="cart-item">

    <img src="../images/<?php echo $row['image']; ?>" class="cart-image">

    <div class="cart-title">
        <?php echo $row['title']; ?>
    </div>

    <form method="POST" class="quantity-form">

        <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">

        <button type="submit" name="action" value="minus">−</button>

        <div class="quantity-number">
            <?php echo $row['quantity']; ?>
        </div>

        <button type="submit" name="action" value="plus">+</button>
    </form>

    <div class="cart-price">
        <?php echo $sum; ?> ₽
    </div>

    <form method="POST" action="remove_from_cart.php">
        <input type="hidden" name="book_id" value="<?php echo $row['id']; ?>">
        <button class="remove-btn">🗑</button>
    </form>

</div>

<?php } ?>

</div>

<div class="checkout">
    <h3>Оформление заказа</h3>

    <p>Товаров: <?php echo $total_items; ?></p>
    <p><strong>Итого: <?php echo $total; ?> ₽</strong></p>

    <button>Оформить заказ</button>
</div>

</div>

<?php endif; ?>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>
