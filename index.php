<?php
session_start();
include "config.php";

$search = "";

if(isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM books WHERE title LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM books";
}

$result = mysqli_query($conn, $sql);

/* получение данных об избранном юзера */

$favorites = [];

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $fav_query = mysqli_query($conn, 
        "SELECT book_id FROM favorites WHERE user_id='$user_id'"
    );

    while($row = mysqli_fetch_assoc($fav_query)) {
        $favorites[] = $row['book_id'];
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>BookStore</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php include "includes/header.php"; ?>

<main>

<section class="hero">

    <div class="hero-track">

        <div class="hero-slide">
            <div class="hero-content">
                <h1>Новинки сезона</h1>
                <p>Самые свежие книги уже в каталоге</p>
                <a href="#" class="hero-btn">Смотреть</a>
            </div>
        </div>

        <div class="hero-slide">
            <div class="hero-content">
                <h1>Бестселлеры</h1>
                <p>Книги, которые читают все</p>
                <a href="#" class="hero-btn">Перейти</a>
            </div>
        </div>

        <div class="hero-slide">
            <div class="hero-content">
                <h1>Скидки до 30%</h1>
                <p>Популярные книги по выгодной цене</p>
                <a href="#" class="hero-btn">Купить</a>
            </div>
        </div>

    </div>

    <button class="hero-arrow prev">&#10094;</button>
    <button class="hero-arrow next">&#10095;</button>

</section>


<div class="book-container">

<?php while($book = mysqli_fetch_assoc($result)) { ?>

<div class="book-card">

    <img src="/images/<?php echo $book['image']; ?>" 
         alt="<?php echo $book['title']; ?>" 
         class="book-image">

    <p class="price"><?php echo $book['price']; ?> ₽</p>
    <h3><?php echo $book['title']; ?></h3>
    <p><?php echo $book['author']; ?></p>

    <div class="actions">

        <form method="POST" action="/cart/add_to_cart.php">
            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
            <button type="submit" class="cart-btn">В корзину</button>
        </form>

        <div class="favorite-btn 
            <?php if(in_array($book['id'], $favorites)) echo 'active'; ?>"
             onclick="toggleFavorite(event, <?php echo $book['id']; ?>)">

            <svg viewBox="0 0 24 24" class="heart-icon">
                <path d="M12 21
                         C10 19.2 4 14.5 4 9
                         A4 4 0 0 1 8 5
                         C10 5 12 7 12 7
                         C12 7 14 5 16 5
                         A4 4 0 0 1 20 9
                         C20 14.5 14 19.2 12 21Z"/>
            </svg>

        </div>

    </div>

</div>

<?php } ?>

</div>

</main>

<script>
function toggleFavorite(event, bookId) {
    event.stopPropagation();

    const btn = event.currentTarget;

    fetch("/favorites/toggle.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "book_id=" + bookId
    })
    .then(response => response.text())
    .then(data => {

        if(data === "not_logged") {
            openAuthModal();
            return;
        }

        if(data === "added") {
            btn.classList.add("active");
        }

        if(data === "removed") {
            btn.classList.remove("active");
        }

        btn.classList.add("pulse");
        setTimeout(() => {
            btn.classList.remove("pulse");
        }, 400);
    });
}
</script>

<script>

const track = document.querySelector('.hero-track');
const slides = document.querySelectorAll('.hero-slide');
const nextBtn = document.querySelector('.next');
const prevBtn = document.querySelector('.prev');

let index = 0;
const totalSlides = slides.length;

function updateSlider() {
    track.style.transform = `translateX(-${index * 100}%)`;
}

nextBtn.addEventListener('click', () => {
    index++;
    if(index >= totalSlides) {
        index = 0;
    }
    updateSlider();
});

prevBtn.addEventListener('click', () => {
    index--;
    if(index < 0) {
        index = totalSlides - 1;
    }
    updateSlider();
});

/* само переключается */
setInterval(() => {
    index++;
    if(index >= totalSlides) {
        index = 0;
    }
    updateSlider();
}, 5000);

</script>

<?php include "includes/footer.php"; ?>

</body>
</html>
