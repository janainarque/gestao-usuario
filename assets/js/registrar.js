document.addEventListener('DOMContentLoaded', function() {
    // Verifica se há uma mensagem de erro e o popup está presente
    var errorPopup = document.querySelector('.error-popup');
    var successPopup = document.querySelector('.success-popup');

    if (errorPopup) {
        errorPopup.classList.add('show');

        // Adiciona um evento de clique para fechar o popup
        var closeButton = document.querySelector('.error-popup-close');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                errorPopup.classList.remove('show');
            });
        }

        // Fecha o popup automaticamente após 5 segundos
        setTimeout(function() {
            errorPopup.classList.remove('show');
        }, 5000); // Tempo em milissegundos
    }

    if (successPopup) {
        successPopup.classList.add('show');

        // Adiciona um evento de clique para fechar o popup
        var closeButton = document.querySelector('.success-popup-close');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                successPopup.classList.remove('show');
            });
        }

        // Fecha o popup automaticamente após 5 segundos
        setTimeout(function() {
            successPopup.classList.remove('show');
        }, 5000); // Tempo em milissegundos
    }
});
