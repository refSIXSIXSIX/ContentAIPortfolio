// cart.js - Корзина

const CART_KEY = 'gestrion_cart';

function getCart() {
    const cart = localStorage.getItem(CART_KEY);
    return cart ? JSON.parse(cart) : [];
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    updateCartUI();
    if (isUserLoggedIn()) syncCartWithDB();
}

function isUserLoggedIn() {
    const userId = document.body.getAttribute('data-user-id');
    return userId && userId !== '';
}

function addToCart(id, name, price, image) {
    let cart = getCart();
    let existing = cart.find(item => item.id == id);
    if (existing) {
        existing.quantity++;
    } else {
        cart.push({ id: id, name: name, price: parseFloat(price), image: image, quantity: 1 });
    }
    saveCart(cart);
    alert('✅ Добавлено в корзину');
}

function removeFromCart(id) {
    let cart = getCart();
    cart = cart.filter(item => item.id != id);
    saveCart(cart);
    alert('🗑️ Удалено из корзины');
}

function updateQuantity(id, qty) {
    if (qty < 1) { removeFromCart(id); return; }
    let cart = getCart();
    let item = cart.find(item => item.id == id);
    if (item) { item.quantity = qty; saveCart(cart); }
}

function getCartTotal() {
    return getCart().reduce((sum, item) => sum + (item.price * item.quantity), 0);
}

function formatPrice(p) {
    return p.toLocaleString('ru-RU');
}

function updateCartUI() {
    let cart = getCart();
    let count = cart.reduce((s, i) => s + i.quantity, 0);
    let cntSpan = document.getElementById('cartCount');
    if (cntSpan) cntSpan.textContent = count;
    
    let itemsDiv = document.getElementById('cartItems');
    let footerDiv = document.getElementById('cartFooter');
    let totalSpan = document.getElementById('cartTotal');
    
    if (!itemsDiv) return;
    
    if (cart.length === 0) {
        itemsDiv.innerHTML = '<div class="cart-empty">Корзина пуста</div>';
        if (footerDiv) footerDiv.style.display = 'none';
        return;
    }
    
    if (footerDiv) footerDiv.style.display = 'block';
    
    let html = '';
    for (let item of cart) {
        html += `
            <div class="cart-item">
                <div class="cart-item-info">
                    <div class="cart-item-title">${escapeHtml(item.name)}</div>
                    <div class="cart-item-price">${formatPrice(item.price)} ₽</div>
                    <div>
                        <button class="cart-qty" onclick="updateQuantity(${item.id}, ${item.quantity-1})">-</button>
                        <span style="margin:0 10px">${item.quantity}</span>
                        <button class="cart-qty" onclick="updateQuantity(${item.id}, ${item.quantity+1})">+</button>
                    </div>
                </div>
                <button class="cart-item-remove" onclick="removeFromCart(${item.id})">&times;</button>
            </div>
        `;
    }
    
    // Добавляем кнопку "Сохранить корзину" если пользователь авторизован
    if (isUserLoggedIn()) {
        html += `
            <div style="text-align: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                <button onclick="saveCartToDB()" style="background-color: #0b3b5c; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                    💾 Сохранить корзину
                </button>
            </div>
        `;
    }
    
    itemsDiv.innerHTML = html;
    if (totalSpan) totalSpan.textContent = formatPrice(getCartTotal()) + ' ₽';
}

function escapeHtml(str) {
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Сохранение корзины в БД (вручную по кнопке)
// Сохранение корзины в БД (вручную по кнопке)
// Сохранение корзины в БД (вручную по кнопке)
function saveCartToDB() {
    let cart = getCart();
    if (cart.length === 0) {
        alert('Корзина пуста, нечего сохранять');
        return;
    }
    
    fetch('cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'sync', cart: cart })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'ok') {
            alert('✅ Корзина сохранена в базу данных!');
        } else {
            alert('❌ Ошибка: ' + (data.message || 'неизвестная ошибка'));
        }
    })
    .catch(error => {
        alert('❌ Ошибка запроса: ' + error);
    });
}

// Автоматическая синхронизация с БД (для авторизованных)
function syncCartWithDB() {
    let cart = getCart();
    if (cart.length === 0) return;
    
    fetch('cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'sync', cart: cart })
    })
    .catch(err => console.error('Ошибка автосинхронизации:', err));
}

// Загрузка корзины из БД
function loadCartFromDB() {
    fetch('cart.php?action=load')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'ok' && data.cart && data.cart.length > 0) {
            localStorage.setItem(CART_KEY, JSON.stringify(data.cart));
            updateCartUI();
            console.log('Корзина загружена из БД');
        }
    })
    .catch(err => console.error('Ошибка загрузки корзины:', err));
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    // Если пользователь авторизован - загружаем корзину из БД
    if (isUserLoggedIn()) {
        loadCartFromDB();
    }
    
    updateCartUI();
    
    // Открытие модального окна
    const cartBtn = document.getElementById('cartBtn');
    const cartModal = document.getElementById('cartModal');
    const cartClose = document.getElementById('cartClose');
    
    if (cartBtn && cartModal) {
        cartBtn.onclick = () => {
            cartModal.classList.add('open');
            updateCartUI();
        };
    }
    
    if (cartClose && cartModal) {
        cartClose.onclick = () => cartModal.classList.remove('open');
        cartModal.onclick = (e) => {
            if (e.target === cartModal) cartModal.classList.remove('open');
        };
    }
    
    // Оформление заказа
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.onclick = () => {
            if (getCart().length === 0) {
                alert('Корзина пуста');
                return;
            }
            alert('Спасибо за заказ! Мы свяжемся с вами в ближайшее время.');
        };
    }
});