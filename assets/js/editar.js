document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('editProfileForm');
    const profileCircle = document.querySelector('.profile-circle');
    const sidebarCPF = document.querySelector('.contact-link.cpf');
    const sidebarEmail = document.querySelector('.contact-link.email');
    const sidebarTelefone = document.querySelector('.contact-link.telefone');
    const sidebarAniversario = document.querySelector('.contact-item time.aniversario');

    const abilityItems = document.querySelectorAll('[data-ability-item]');
    const modalContainer = document.querySelector('[data-modal-container]');
    const modalCloseBtn = document.querySelector('[data-modal-close-btn]');
    const overlay = document.querySelector('[data-overlay]');
    const modalTitle = document.querySelector('[data-modal-title]');
    const modalText = document.querySelector('[data-modal-text]');

    // Formatação do CPF
    function formatCPF(cpf) {
        return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    }

    // Formatação da data
    function formatDate(dateStr) {
        if (!dateStr || dateStr === '0000-00-00') {
            return '';
        }
        const [year, month, day] = dateStr.split('-');
        if (!year || !month || !day) {
            return '';
        }
        return `${day}/${month}/${year}`;
    }

    // Obtenção das iniciais do nome
    function getInitials(name) {
        const words = name.split(' ');
        let initials = '';
        for (let word of words) {
            if (word.length > 0) {
                initials += word[0].toUpperCase();
            }
        }
        return initials;
    }

    // Manipulação do formulário de edição
    if (form) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Perfil atualizado com sucesso!");
                    const { nome, email, telefone, cpf, data_nascimento } = data.user;
                    const formattedCPF = formatCPF(cpf);
                    const formattedDate = formatDate(data_nascimento);
                    const formattedTelefone = telefone ? telefone : '';
                    const initials = getInitials(nome);

                    document.querySelector('.name').textContent = nome;
                    document.querySelector('.profile-initials').textContent = initials;
                    if (sidebarCPF) sidebarCPF.textContent = formattedCPF;
                    if (sidebarEmail) sidebarEmail.textContent = email;
                    if (sidebarTelefone) sidebarTelefone.textContent = formattedTelefone;
                    if (sidebarAniversario) sidebarAniversario.textContent = formattedDate;
                } else {
                    alert(data.message || "Erro ao atualizar perfil. Tente novamente.");
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert("Erro ao atualizar perfil. Tente novamente.");
            });
        });
    }

    // Efeito de aumentar o círculo do perfil ao passar o mouse
    if (profileCircle) {
        profileCircle.addEventListener('mouseover', () => {
            profileCircle.style.transform = 'scale(1.1)';
        });
        profileCircle.addEventListener('mouseout', () => {
            profileCircle.style.transform = 'scale(1)';
        });
    }

    // Funcionalidade de mudança de abas no navbar
    const navbarLinks = document.querySelectorAll('.navbar-link');
    const pages = document.querySelectorAll('[data-page]');
    navbarLinks.forEach((link, index) => {
        link.addEventListener('click', () => {
            navbarLinks.forEach(nav => nav.classList.remove('active'));
            link.classList.add('active');
            pages.forEach(page => page.classList.remove('active'));
            pages[index].classList.add('active');
        });
    });

    // Funcionalidade de abrir e fechar modais
    // const modalContainer = document.querySelector('[data-modal-container]');
    // const modalCloseBtn = document.querySelector('[data-modal-close-btn]');
    // const overlay = document.querySelector('[data-overlay]');
    // if (modalContainer && modalCloseBtn && overlay) {
    //     modalCloseBtn.addEventListener('click', () => {
    //         modalContainer.classList.remove('active');
    //     });
    //     overlay.addEventListener('click', () => {
    //         modalContainer.classList.remove('active');
    //     });
    // }

    // Funcionalidade de abrir e fechar modais
    // const modalContainer = document.querySelector('[data-modal-container]');
    // const modalCloseBtn = document.querySelector('[data-modal-close-btn]');
    // const overlay = document.querySelector('[data-overlay]');
    // const openModalBtns = document.querySelectorAll('[data-open-modal]');

    // if (modalContainer && modalCloseBtn && overlay) {
    //     openModalBtns.forEach(btn => {
    //         btn.addEventListener('click', () => {
    //             modalContainer.classList.add('active');
    //         });
    //     });

    //     modalCloseBtn.addEventListener('click', () => {
    //         modalContainer.classList.remove('active');
    //     });
    //     overlay.addEventListener('click', () => {
    //         modalContainer.classList.remove('active');
    //     });
    // }

    abilityItems.forEach(item => {
        item.addEventListener('click', () => {
            const title = item.querySelector('[data-ability-title]').textContent;
            const text = item.querySelector('[data-ability-text]').innerHTML;

            modalTitle.textContent = title;
            modalText.innerHTML = text;

            modalContainer.classList.add('active');
            overlay.classList.add('active');
        });
    });

    if (modalCloseBtn && overlay) {
        modalCloseBtn.addEventListener('click', () => {
            modalContainer.classList.remove('active');
            overlay.classList.remove('active');
        });
        overlay.addEventListener('click', () => {
            modalContainer.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

});
