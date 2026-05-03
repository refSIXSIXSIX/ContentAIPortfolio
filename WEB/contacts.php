<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Контакты - Гестион</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-user-id="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
    <header>
        <h1>Юридическая компания «Гестион»</h1>
        <p>Напишите нам</p>
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
    <main>
        <h2>Напишите нам</h2>

        <form action="#" method="post">
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" required placeholder="Введите ваше имя">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="example@mail.ru">

            <label for="subject">Тема:</label>
            <input type="text" id="subject" name="subject" placeholder="Кратко о чем вопрос">

            <label for="message">Сообщение:</label>
            <textarea id="message" name="message" rows="5" required placeholder="Напишите ваш вопрос..."></textarea>

            <label for="phone">Телефон:</label>
            <input type="tel" id="phone" name="phone" placeholder="+7 (___) ___-__-__">

            <input type="submit" value="Отправить">
            <input type="reset" value="Очистить">
        </form>

        <div class="contact-info">
            <h2>Адрес</h2>
            <p><strong>🏢 Телефон:</strong> +7 (495) 123-45-67</p>
            <p><strong>📍 Адрес:</strong> г. Москва, ул. Тверская, д. 1, офис 321</p>
            <p><strong>✉️ Email:</strong> info@gestrion.ru</p>
            <p><strong>⏰ Режим работы:</strong> пн-пт 10:00-20:00, сб 11:00-16:00</p>
        </div>

        <h2>Как нас найти</h2>
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.373141175509!2d37.6156!3d55.7522!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54a5a7f5f5f5f%3A0x0!2z0JzQvtGB0LrQstCw!5e0!3m2!1sru!2sru!4v1234567890" 
                width="600" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy"
                title="Карта проезда">
            </iframe>
            <p><i>г. Москва, ул. Тверская, д. 1 (центр города)</i></p>
        </div>

        <div class="image-map-container">
            <img src="logo.jpg" alt="Схема проезда" usemap="#contactmap" width="800" height="120" onerror="this.style.display='none'">
            <map name="contactmap">
                <area shape="circle" coords="150,60,50" href="tel:+74951234567" alt="Позвонить" title="Позвонить нам">
                <area shape="rect" coords="300,20,500,100" href="mailto:info@gestrion.ru" alt="Email" title="Написать нам">
                <area shape="poly" coords="600,20,700,100,650,100,550,20" href="https://maps.yandex.ru" target="_blank" alt="Карта" title="Открыть карту">
            </map>
            <div class="image-map-caption">
                📞 Круг - позвонить, прямоугольник - email, ромб - карта
            </div>
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

    <script src="cart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let name = document.getElementById('name').value;
                    let email = document.getElementById('email').value;
                    let message = document.getElementById('message').value;
                    
                    if (name.trim() === '') {
                        alert('Пожалуйста, введите имя');
                        return;
                    }
                    if (!email.includes('@') || !email.includes('.')) {
                        alert('Пожалуйста, введите корректный email');
                        return;
                    }
                    if (message.trim() === '') {
                        alert('Пожалуйста, введите сообщение');
                        return;
                    }
                    
                    alert(`Спасибо, ${name}! Ваше сообщение отправлено. Мы ответим вам на ${email} в ближайшее время.`);
                    form.reset();
                });
            }
        });
    </script>
</body>
</html>