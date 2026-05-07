document.addEventListener('DOMContentLoaded', function() {
    const loginBtn = document.querySelector('.ghost-button[data-route="login"]');
    if (!loginBtn) return;

    const user = localStorage.getItem('loggedInUser');

    if (user) {
        loginBtn.innerText = user;
        loginBtn.onclick = function() {
            if (confirm('Do you want to log out?')) {
                localStorage.removeItem('loggedInUser');
                alert('Logged out successfully!');
                location.reload();
            }
        };
    }
});