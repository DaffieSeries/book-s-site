<?php
session_start();
include "../config.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: /auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT books.* FROM books
        JOIN favorites ON books.id = favorites.book_id
        WHERE favorites.user_id='$user_id'";

$result = mysqli_query($conn, $sql);
$hasBooks = mysqli_num_rows($result) > 0;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Избранное</title>

<style>

main {
    padding: 50px 60px;
    min-height: calc(100vh - 160px);
}

/* Заголовок */

.page-title {
    font-size: 26px;
    font-weight: 600;
    color: #5c4632;
    margin-bottom: 35px;
}

/* Контент */

.content-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 50px;
}

/* Контейнер */

.favorites-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 28px;
    flex: 1;
}

/* Карточка */

.favorite-card {
    position: relative;
    background: #fffdf9;
    border: 1px solid #eee6dc;
    border-radius: 14px;
    padding: 14px;
    display: flex;
    flex-direction: column;
    text-align: center;
    cursor: pointer;
    transition: 0.25s ease;
    opacity: 0;
    transform: translateY(15px);
    animation: fadeUp 0.4s ease forwards;
}

.favorite-card:hover {
    border-color: #e4d5c3;
    background: #fffaf3;
}

.favorite-card.selected {
    border: 1px solid #cdb79e;
    background: #f9f4ed;
}

/* Анимации появления */

@keyframes fadeUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Картинка */

.book-image {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 12px;
}

/* Текст */

.favorite-card h3 {
    font-size: 15px;
    font-weight: 500;
    margin: 6px 0 4px 0;
    color: #3b2f23;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 38px;
}

.favorite-card p {
    font-size: 13px;
    color: #7a7a7a;
    margin: 2px 0;
}

.favorite-card .price {
    font-size: 14px;
    font-weight: 600;
    color: #5c4632;
    margin-top: 6px;
}

/* Кнопка удаления */

.remove-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #f4efe9;
    border: none;
    color: #8c6a4a;
    font-size: 14px;
    cursor: pointer;
    transition: 0.2s;
}

.remove-btn:hover {
    background: #c85d5d;
    color: white;
}

/* Правая панелька */

.favorites-sidebar {
    width: 260px;
    padding: 22px;
    background: #fffdf9;
    border: 1px solid #eee6dc;
    border-radius: 14px;
    position: sticky;
    top: 120px;
}

.favorites-sidebar p {
    font-size: 15px;
    margin-bottom: 15px;
    color: #5c4632;
}

.favorites-sidebar button {
    width: 100%;
    padding: 12px;
    background: #8c6a4a;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s;
}

.favorites-sidebar button:hover {
    background: #75563c;
}

/* когда карточек нет */

.empty-state {
    text-align: center;
    padding: 100px 20px;
    color: #8c6a4a;
}

.empty-state h2 {
    font-size: 22px;
    margin-bottom: 10px;
}

.empty-state p {
    font-size: 14px;
    color: #9a8c7a;
}

</style>
</head>

<body>

<?php include "../includes/header.php"; ?>

<main>

<div class="page-title">Ваши избранные книги</div>

<?php if($hasBooks) { ?>

<form method="POST" action="/cart/add_multiple.php">

<div class="content-wrapper">

<div class="favorites-container">

<?php while($book = mysqli_fetch_assoc($result)) { ?>

<div class="favorite-card" onclick="toggleSelect(this)">

    <button type="button" 
        class="remove-btn"
        onclick="removeFavorite(event, <?php echo $book['id']; ?>)">
    ✕
    </button>

    <input type="checkbox" 
           name="selected[]" 
           value="<?php echo $book['id']; ?>" hidden>

    <img src="/images/<?php echo $book['image']; ?>" class="book-image">

    <h3><?php echo $book['title']; ?></h3>
    <p><?php echo $book['author']; ?></p>
    <p class="price"><?php echo $book['price']; ?> ₽</p>

</div>

<?php } ?>

</div>

<div class="favorites-sidebar">
    <p>Выбрано: <span id="selectedCount">0</span></p>
    <button type="submit">Добавить выбранные в корзину</button>
</div>

</div>

</form>

<?php } else { ?>

<div class="empty-state">
    <h2>В избранном пока пусто 📚</h2>
    <p>Добавляйте книги, чтобы сохранить их здесь</p>
</div>

<?php } ?>

</main>

<?php include "../includes/footer.php"; ?>

<script>
function toggleSelect(card) {
    card.classList.toggle("selected");
    const checkbox = card.querySelector("input");
    checkbox.checked = !checkbox.checked;
    updateCount();
}

function updateCount() {
    const checked = document.querySelectorAll("input[name='selected[]']:checked");
    document.getElementById("selectedCount").innerText = checked.length;
}

function removeFavorite(event, bookId) {
    event.stopPropagation();

    fetch("/favorites/toggle.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "book_id=" + bookId
    })
    .then(response => response.text())
    .then(data => {
        if(data === "removed") {
            event.target.closest(".favorite-card").remove();
            updateCount();
        }
    });
}
</script>

</body>
</html>
