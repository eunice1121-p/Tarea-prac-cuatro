import './bootstrap';

document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-password-toggle]');

    if (!button) {
        return;
    }

    const input = document.getElementById(button.getAttribute('aria-controls'));

    if (!input) {
        return;
    }

    const isVisible = input.type === 'password';
    input.type = isVisible ? 'text' : 'password';
    button.setAttribute('aria-pressed', String(isVisible));
    button.setAttribute('aria-label', isVisible ? 'Ocultar contraseña' : 'Mostrar contraseña');
});
