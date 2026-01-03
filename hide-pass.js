
    const passwordInput = document.getElementById('passwordView');
    const toggleBtn = document.getElementById('togglePassword');
    let hideTimer = null;

    toggleBtn.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
        // Show password
        passwordInput.type = 'text';
        toggleBtn.textContent = 'visibility_off';
        toggleBtn.style.color = '#009688';

        // Re-hide after 5 seconds
        clearTimeout(hideTimer);
        hideTimer = setTimeout(() => {
            passwordInput.type = 'password';
            toggleBtn.textContent = 'visibility';
            toggleBtn.style.color = 'var(--error)';
        }, 5000);
        } else {
        // Immediately hide if clicked again
        passwordInput.type = 'password';
        toggleBtn.textContent = 'visibility';
        toggleBtn.style.color = 'var(--error)';
        clearTimeout(hideTimer);
        }
    });
