document.addEventListener('DOMContentLoaded', function() {
    const loginBtns = document.querySelectorAll('.ghost-button[data-route="login"]');
    if (!loginBtns || loginBtns.length === 0) return;

    const user = localStorage.getItem('loggedInUser');
    const role = localStorage.getItem('userRole') || 'Buyer';

    if (user) {
        // Update all login buttons
        loginBtns.forEach(loginBtn => {
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
        });
    }
});