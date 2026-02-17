
<style>

footer {
    background: #1f1f1f;
    color: white;
    padding: 50px 40px 30px;
    margin-top: 80px;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 30px;
}

.footer-column {
    max-width: 250px;
}

.footer-column h4 {
    margin-bottom: 15px;
    font-size: 16px;
}

.footer-column p {
    color: #bbb;
    font-size: 14px;
}

.footer-column a {
    display: block;
    text-decoration: none;
    color: #bbb;
    margin-bottom: 8px;
    font-size: 14px;
    transition: 0.3s;
}

.footer-column a:hover {
    color: white;
}

.footer-bottom {
    margin-top: 40px;
    text-align: center;
    font-size: 13px;
    color: #888;
}

</style>


<footer>

    <div class="footer-container">

        <div class="footer-column">
            <h4>📚 BookStore</h4>
            <p>Ваш онлайн-магазин книг. Читайте больше — живите ярче.</p>
        </div>

        <div class="footer-column">
            <h4>Покупателям</h4>
            <a href="#">Доставка</a>
            <a href="#">Оплата</a>
            <a href="#">Возврат</a>
        </div>

        <div class="footer-column">
            <h4>Информация</h4>
            <a href="#">О нас</a>
            <a href="#">Контакты</a>
            <a href="#">Поддержка</a>
        </div>

        <div class="footer-column">
            <h4>Соцсети</h4>
            <a href="#">VK</a>
            <a href="#">Telegram</a>
            <a href="#">YouTube</a>
        </div>

    </div>

    <div class="footer-bottom">
        © <?php echo date("Y"); ?> BookStore. Все права защищены.
    </div>

</footer>
