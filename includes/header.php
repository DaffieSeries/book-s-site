<style>

body {
    margin: 0;
    backdrop-filter: blur(6px);
    font-family: 'Segoe UI', sans-serif;
    background: #f8f5f0;
    color: #2f2f2f;
}

header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 50px;
    background: #fffdf9;
    border-bottom: 1px solid #eee6dc; /* вместо тени */
}


/* Логотип */

.logo {
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 0.5px;
    cursor: pointer;
    color: #5c4632;
    transition: 0.2s;
}

.logo:hover {
    color: #8c6a4a;
}


/* Кнопка меню */

.menu-btn {
    padding: 8px 14px;
    background: #f4efe9;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.menu-btn:hover {
    background: #ebe3da;
}


/*  Поисковик  */

.search-box {
    flex: 1;
    margin: 0 40px;
}

.search-box form {
    display: flex;
}

.search-box input {
    flex: 1;
    padding: 11px 14px;
    border: 1px solid #e4d5c3;
    border-right: none;
    border-radius: 10px 0 0 10px;
    outline: none;
    background: #fffaf3;
    font-size: 14px;
}

.search-box input:focus {
    border-color: #cdb79e;
}

.search-box button {
    padding: 11px 20px;
    border: 1px solid #e4d5c3;
    background: #8c6a4a;
    color: white;
    border-radius: 0 10px 10px 0;
    cursor: pointer;
    transition: 0.2s;
}

.search-box button:hover {
    background: #75563c;
}


/* Иконки */

.icons a {
    margin-left: 18px;
    font-size: 18px;
    text-decoration: none;
    color: #7a6a5a;
    transition: 0.2s;
}

.icons a:hover {
    color: #8c6a4a;
}


/* Менюшка */

.menu {
    display: none;
    flex-direction: column;
    background: #fffdf9;
    padding: 20px 50px;
    border-bottom: 1px solid #eee6dc;
}

.menu a {
    padding: 8px 0;
    text-decoration: none;
    color: #5c4632;
    transition: 0.2s;
}

.menu a:hover {
    color: #8c6a4a;
}

.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    width: 350px;
    position: relative;
}

.modal-buttons a {
    display: inline-block;
    margin: 10px;
    padding: 8px 15px;
    background: #925f34;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.modal-buttons a:hover {
    background: #ebae69;
}

.close {
    position: absolute;
    top: 10px;
    right: 15px;
    cursor: pointer;
    font-size: 20px;
}


</style>


<header>

    <div class="logo" onclick="window.location='/index.php'">
        📚 BookStore
    </div>

    <div class="menu-btn" onclick="toggleMenu()">
        ☰ Меню
    </div>

    <div class="search-box">
        <form method="GET" action="/index.php">
            <input type="text" name="search" placeholder="Поиск книги...">
            <button type="submit">Найти</button>
        </form>
    </div>

    <div class="icons">
        <a href="/favorites/favorites.php">❤️</a>

        <?php if(isset($_SESSION['user_id'])) { ?>
            <a href="/cart/cart.php">🛒</a>
        <?php } else { ?>
            <a href="#" onclick="openAuthModal()">🛒</a>
        <?php } ?>


        <?php if(isset($_SESSION['user_id'])) { ?>
            <a href="/profile.php">👤</a>
        <?php } else { ?>
            <a href="/auth/login.php">👤</a>
        <?php } ?>
    </div>

</header>

<div class="menu" id="menu">
    <a href="/index.php">Главная</a>
    <a href="#">Жанры</a>
    
    <?php if(isset($_SESSION['user_id'])) { ?>
        <a href="/cart/cart.php">Корзина</a>
    <?php } else { ?>
        <a href="#" onclick="openAuthModal()">Корзина</a>
    <?php } ?>


    <?php if(isset($_SESSION['user_id'])) { ?>
        <a href="/profile.php">Профиль</a>
        <a href="/auth/logout.php">Выйти</a>
    <?php } else { ?>
        <a href="/auth/login.php">Войти</a>
    <?php } ?>
</div>

<script>
function toggleMenu() {
    var menu = document.getElementById("menu");

    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

//диалоговое меню для реги

</script>

<div class="modal" id="authModal">
    <div class="modal-content">

        <div class="modal-header">
            <span class="close" onclick="closeAuthModal()">×</span>
        </div>

        <h3>Требуется вход</h3>
        <p>Чтобы посмотреть товары в корзине, войдите или зарегистрируйтесь.</p>

        <div class="modal-buttons">
            <a href="/auth/login.php">Войти</a>
            <a href="/auth/register.php">Регистрация</a>
        </div>

    </div>
</div>

<script>
function openAuthModal() {
    document.getElementById("authModal").style.display = "flex";
}

function closeAuthModal() {
    document.getElementById("authModal").style.display = "none";
}

// закрытие вне окна
window.onclick = function(event) {
    const modal = document.getElementById("authModal");
    if (event.target === modal) {
        closeAuthModal();
    }
}

// закрытие по esc
document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") {
        closeAuthModal();
    }
});
</script>


