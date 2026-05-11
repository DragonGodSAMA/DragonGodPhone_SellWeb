document.addEventListener('DOMContentLoaded', function() {
    const loginBtns = document.querySelectorAll('.ghost-button[data-route="login"]');
    let cartBadges = document.querySelectorAll('.cart-badge');
    const user = localStorage.getItem('loggedInUser');
    const role = localStorage.getItem('userRole') || 'Buyer';

    function readCart() {
        try {
            const parsed = JSON.parse(localStorage.getItem('shoppingCart') || '[]');
            return Array.isArray(parsed) ? parsed : [];
        } catch (error) {
            return [];
        }
    }

    function getCartItemTotal(item) {
        const directTotal = Number(item && item.total);
        if (Number.isFinite(directTotal) && directTotal > 0) {
            return directTotal;
        }

        return (Number(item && item.price) || 0) * (Number(item && item.quantity) || 1);
    }

    function updateCartBadges() {
        const total = readCart().reduce((sum, item) => sum + getCartItemTotal(item), 0);
        cartBadges = document.querySelectorAll('.cart-badge');
        cartBadges.forEach((badge) => {
            badge.textContent = `¥${total.toLocaleString()}`;
        });
    }

    function hasActionLink(container, token) {
        return Array.from(container.querySelectorAll('a[href]')).some((anchor) => {
            const href = anchor.getAttribute('href') || '';
            return href.includes(token);
        });
    }

    function getActionClass(container, sharedType) {
        if (container.matches('.header-actions')) {
            return sharedType === 'cart' ? 'ghost-button shared-cart-link' : 'ghost-button';
        }

        return sharedType === 'cart' ? 'channel-header-action shared-cart-link' : 'channel-header-action';
    }

    function getInsertTarget(container) {
        return container.querySelector('.ghost-button[data-route="login"], .btn-reserve, button[data-route="login"]');
    }

    function injectHeaderActions() {
        const headerContainers = document.querySelectorAll('.channel-header-actions, .nav-actions, .header-actions');
        const isSeller = String(role).trim().toLowerCase() === 'seller';

        headerContainers.forEach((container) => {
            if (isSeller && !hasActionLink(container, 'Sell_Product.html')) {
                const addProductAnchor = document.createElement('a');
                addProductAnchor.className = getActionClass(container, 'action');
                addProductAnchor.href = '/HTML/Sell_Product/Sell_Product.html';
                addProductAnchor.textContent = 'Add Product';

                if (container.matches('.header-actions')) {
                    const insertTarget = getInsertTarget(container);
                    if (insertTarget) {
                        container.insertBefore(addProductAnchor, insertTarget);
                    } else {
                        container.appendChild(addProductAnchor);
                    }
                } else {
                    container.insertBefore(addProductAnchor, container.firstChild);
                }
            }

            if (!hasActionLink(container, 'Cart.html')) {
                const cartAnchor = document.createElement('a');
                cartAnchor.className = getActionClass(container, 'cart');
                cartAnchor.href = '/HTML/SellPage(addcar)/Cart.html';
                cartAnchor.innerHTML = 'Cart <span class="cart-badge">¥0</span>';

                const insertTarget = getInsertTarget(container);
                if (insertTarget) {
                    container.insertBefore(cartAnchor, insertTarget);
                } else {
                    container.appendChild(cartAnchor);
                }
            }
        });
    }

    if (user && loginBtns.length > 0) {
        loginBtns.forEach((loginBtn) => {
            loginBtn.innerText = `${user} (${role})`;
            loginBtn.onclick = function() {
                if (confirm('Do you want to log out?')) {
                    localStorage.removeItem('loggedInUser');
                    localStorage.removeItem('userRole');
                    alert('Logged out successfully!');
                    location.reload();
                }
            };
        });
    }

    injectHeaderActions();
    updateCartBadges();
    window.addEventListener('focus', updateCartBadges);
    window.addEventListener('storage', updateCartBadges);
    window.DG_updateCartBadges = updateCartBadges;
});