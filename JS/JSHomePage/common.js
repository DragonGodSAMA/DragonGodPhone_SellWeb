document.addEventListener('DOMContentLoaded', function() {
    const loginBtns = document.querySelectorAll('.ghost-button[data-route="login"]');
    let cartBadges = document.querySelectorAll('.cart-badge');
    const user = localStorage.getItem('loggedInUser');
    const role = localStorage.getItem('userRole') || 'Buyer';

    // Update cart badges from localStorage
    function updateCartBadges() {
        const cart = JSON.parse(localStorage.getItem('shoppingCart') || '[]');
        const total = cart.reduce((s, it) => s + (Number(it.total || 0) || 0), 0);
        // refresh NodeList in case badges were injected after DOMContentLoaded
        cartBadges = document.querySelectorAll('.cart-badge');
        cartBadges.forEach(b => b.textContent = `¥${total.toLocaleString()}`);
    }

    // If logged in, replace login button behaviour to link to profile page
    if (user && loginBtns && loginBtns.length > 0) {
        loginBtns.forEach(loginBtn => {
            loginBtn.innerText = `${user} (${role})`;
            // navigate to profile page instead of direct logout
            loginBtn.addEventListener('click', function() {
                window.location.href = '/HTML/Login&Registration/UserProfile.html';
            });
        });

        // If user is a seller, inject an Add Product button into header areas
        if (role.toLowerCase() === 'seller') {
            // try to find common header action containers
            const headerContainers = document.querySelectorAll('.channel-header-actions, .nav-actions, .channel-header-actions');
            headerContainers.forEach(container => {
                const anchor = document.createElement('a');
                anchor.className = 'channel-header-action';
                anchor.href = '/HTML/Sell_Product/Sell_Product.html';
                anchor.textContent = 'Add Product';
                container.insertBefore(anchor, container.firstChild);
            });
        }

        // If there's no cart-badge anywhere, try to inject a small cart link into the first header actions container
        if (!document.querySelector('.cart-badge')) {
            const firstHeader = document.querySelector('.channel-header-actions, .nav-actions');
            if (firstHeader) {
                const cartAnchor = document.createElement('a');
                cartAnchor.className = 'channel-header-action';
                cartAnchor.href = '/HTML/SellPage(addcar)/Cart.html';
                cartAnchor.innerHTML = `Cart <span class="cart-badge">¥0</span>`;
                firstHeader.appendChild(cartAnchor);
                // refresh cached NodeList
                cartBadges = document.querySelectorAll('.cart-badge');
            }
        }
    }

    // Ensure cart badge is up-to-date on pages that include it
    updateCartBadges();

    // Expose function to update cart badges globally
    window.DG_updateCartBadges = updateCartBadges;
});