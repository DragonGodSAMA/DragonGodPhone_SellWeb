document.addEventListener('DOMContentLoaded', function() {
    const loginBtn = document.querySelector('.ghost-button[data-route="login"]');
    if (!loginBtn) return;

    const user = localStorage.getItem('loggedInUser');
    const role = localStorage.getItem('userRole') || 'Buyer';

    if (user) {
        // 显示格式：用户名 (Buyer) / 用户名 (Seller)
        loginBtn.innerText = `${user} (${role})`;

        loginBtn.onclick = function() {
            if (confirm('Do you want to log out?')) {
                // 退出同时清空身份
                localStorage.removeItem('loggedInUser');
                localStorage.removeItem('userRole');
                alert('Logged out successfully!');
                location.reload();
            }
        };
    }
});