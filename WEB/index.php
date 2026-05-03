<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Гестион - Главная</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-user-id="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
    <header>
        <h1>Юридическая компания «Гестион»</h1>
        <p>Добро пожаловать на наш сайт!</p>
    </header>
    <hr>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="catalog_db.php">Каталог</a></li>
            <li><a href="contacts.php">Контакты</a></li>
            <li><a href="login.php">Личный кабинет</a></li>
        </ul>
    </nav>
    <hr>

    <!-- СЛАЙДЕР -->
    <div class="slider-container">
        <div class="slider">
            <div class="slide fade">
                <img src="slide1.jpg" alt="Юридические услуги" onerror="this.src='https://via.placeholder.com/1000x400/0b3b5c/ffffff?text=Юридические+услуги'">
                <div class="slide-text"><h3>Профессиональная юридическая помощь</h3><p>Более 10 лет на рынке</p></div>
            </div>
            <div class="slide fade">
                <img src="slide2.jpg" alt="Регистрация бизнеса" onerror="this.src='https://via.placeholder.com/1000x400/1a5f8a/ffffff?text=Регистрация+бизнеса'">
                <div class="slide-text"><h3>Регистрация бизнеса под ключ</h3><p>ООО и ИП от 3 дней</p></div>
            </div>
            <div class="slide fade">
                <img src="slide3.jpg" alt="Представительство в суде" onerror="this.src='https://via.placeholder.com/1000x400/0b3b5c/ffffff?text=Представительство+в+суде'">
                <div class="slide-text"><h3>Представительство в суде</h3><p>Защита ваших интересов</p></div>
            </div>
            <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
            <a class="next" onclick="changeSlide(1)">&#10095;</a>
        </div>
        <div class="dots">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>
    <!-- БЛОК ПОИСКА -->
<div style="background: #f0f4f8; padding: 25px; border-radius: 10px; margin: 20px 0; text-align: center;">
    <h3>🔍 Поиск услуг</h3>
    <p>Введите название услуги</p>
    <form action="search.php" method="get" style="display: flex; justify-content: center; gap: 10px; background: none; padding: 0; box-shadow: none;">
        <input type="text" name="q" placeholder="Введите название услуги..." style="width: 300px; padding: 12px; border-radius: 5px; border: 1px solid #ccc;">
        <input type="submit" value="🔍 Найти" style="background: #0b3b5c; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer;">
    </form>
</div>

    <main>
        <h2>О нас</h2>
        <img src="logo.jpg" alt="Логотип" width="800" height="120" style="display:block; margin:0 auto;" onerror="this.style.display='none'">
        <p>Юридическая компания «Гестион» работает с 2010 года. Мы предоставляем полный спектр юридических услуг.</p>

        <h2>История фирмы</h2>
        <p>2005 год — основание компании.<br>2009 год — создана коллегия адвокатов «Гестион».<br>2013 год — открыт офис в Москве.</p>

        <h2>Сотрудники</h2>
        <table>
            <tr><th>ФИО</th><th>Должность</th><th>Стаж</th></tr>
            <tr><td>Иванов Александр Алексеевич</td><td>Адвокат</td><td>15 лет</td></tr>
            <tr><td>Петрова Елена Сергеевна</td><td>Юрист</td><td>10 лет</td></tr>
            <tr><td>Сидоров Дмитрий Николаевич</td><td>Старший юрист</td><td>12 лет</td></tr>
        </table>

        <div class="image-map-container">
            <img src="logo.jpg" alt="Навигация" usemap="#navmap" width="800" height="120" onerror="this.style.display='none'">
            <map name="navmap">
                <area shape="rect" coords="0,0,200,120" href="index.php" alt="Главная">
                <area shape="rect" coords="200,0,400,120" href="catalog_db.php" alt="Каталог">
                <area shape="rect" coords="400,0,600,120" href="contacts.php" alt="Контакты">
            </map>
        </div>
    </main>
    <hr>
    <footer>
        <p>&copy; 2026 Юридическая компания «Гестион». Все права защищены.</p>
        <p style="margin-top:10px; font-size:0.9em;">
            ✉️ <a href="mailto:info@gestrion.ru" style="color:#ccc;">info@gestrion.ru</a> | 
            📞 +7 (495) 123-45-67
        </p>
        <p style="margin-top:15px;">
            <a href="#" onclick="window.open('privacy.txt', '_blank', 'width=700,height=500,resizable=1,toolbar=1'); return false;" style="color:#ccc;">📄 Политика конфиденциальности</a>
            &nbsp;|&nbsp;
            <a href="privacy.txt" download style="color:#ccc;">⬇️ Скачать</a>
        </p>
    </footer>

    <!-- Корзина -->
    <button class="cart-btn" id="cartBtn">🛒<span class="cart-count" id="cartCount">0</span></button>
    <div class="cart-modal" id="cartModal">
        <div class="cart-modal-content">
            <div class="cart-modal-header"><h3>🛒 Моя корзина</h3><span class="cart-close" id="cartClose">&times;</span></div>
            <div class="cart-modal-body" id="cartItems"><div class="cart-empty">Корзина пуста</div></div>
            <div class="cart-modal-footer" id="cartFooter" style="display:none;">
                <div class="cart-total"><span>Итого:</span><span id="cartTotal">0 ₽</span></div>
                <button class="cart-checkout" id="checkoutBtn">Оформить заказ</button>
            </div>
        </div>
    </div>

    <script>
        let slideIndex = 1;
        function showSlides(n) {
            let slides = document.getElementsByClassName("slide");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) slideIndex = 1;
            if (n < 1) slideIndex = slides.length;
            for (let i = 0; i < slides.length; i++) slides[i].style.display = "none";
            for (let i = 0; i < dots.length; i++) dots[i].className = dots[i].className.replace(" active", "");
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }
        function changeSlide(n) { showSlides(slideIndex += n); }
        function currentSlide(n) { showSlides(slideIndex = n); }
        showSlides(slideIndex);
        setInterval(function() { changeSlide(1); }, 5000);
    </script>
    <script src="cart.js"></script>
</body>
</html>