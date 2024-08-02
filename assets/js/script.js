document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('login-form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('senha');
    const errorMessage = document.getElementById('error-message');
    const togglePasswordIcon = document.getElementById('toggle-password');

    // Função para alternar a visibilidade da senha e atualizar o ícone
    togglePasswordIcon.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        if (type === 'password') {
            togglePasswordIcon.innerHTML = '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>';
        } else {
            togglePasswordIcon.innerHTML = '<svg class="icon-right" id="toggle-password" stroke="currentColor" fill="none" stroke-width="0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="text-gray-500" width="24" height="24"><path d="M18.3333 6.66675C18.3333 6.66675 15 11.6667 10 11.6667C5 11.6667 1.66666 6.66675 1.66666 6.66675" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"></path><path d="M12.5 11.25L13.75 13.3333" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path><path d="M16.6667 9.16675L18.3333 10.8334" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path><path d="M1.66666 10.8334L3.33333 9.16675" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.5 11.25L6.25 13.3333" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
        }
    });

    // Função para validar o e-mail
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    // Validação do formulário antes de enviar
    form.addEventListener('submit', function(event) {
        let valid = true;
        errorMessage.style.display = 'none';
        errorMessage.innerText = '';

        if (!emailInput.value) {
            valid = false;
            errorMessage.innerText = 'Por favor preencha seu e-mail abaixo';
        } else if (!validateEmail(emailInput.value)) {
            valid = false;
            errorMessage.innerText = 'Insira um e-mail válido';
        }

        if (!passwordInput.value) {
            valid = false;
            errorMessage.innerText = 'Por favor preencha sua senha abaixo';
        }

        if (!valid) {
            event.preventDefault();
            errorMessage.style.display = 'block';
        }
    });

    emailInput.setAttribute('autocomplete', 'off');
});
