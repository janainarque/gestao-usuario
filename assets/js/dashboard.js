(function() {
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('editProfileForm');
        const profileCircle = document.querySelector('.profile-circle');
        const sidebarCPF = document.querySelector('.contact-item .contact-link[data-type="cpf"]');
        const sidebarEmail = document.querySelector('.contact-item .contact-link[data-type="email"]');
        const sidebarTelefone = document.querySelector('.contact-item .contact-link[data-type="telefone"]');
        const sidebarAniversario = document.querySelector('.contact-item time[data-type="aniversario"]');
        const profileName = document.querySelector('.info-content .name');
        const profileInitials = document.querySelector('.profile-circle .profile-initials');

        function formatCPF(cpf) {
            return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        }

        function formatDate(dateStr) {
            const [year, month, day] = dateStr.split('-');
            return `${day}/${month}/${year}`;
        }

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
                        //const formattedDate = formatDate(data_nascimento);
                        const formattedDate = data_nascimento ? formatDate(data_nascimento) : '';
                        const formattedTelefone = telefone ? telefone : '';
                        const initials = getInitials(nome);

                        // Atualizar os campos no sidebar
                        if (profileName) {
                            profileName.textContent = nome;
                        }
                        if (profileInitials) {
                            profileInitials.textContent = initials;
                        }
                        if (sidebarCPF) {
                            sidebarCPF.textContent = formattedCPF;
                        }
                        if (sidebarEmail) {
                            sidebarEmail.textContent = email;
                        }
                        if (sidebarTelefone) {
                            sidebarTelefone.textContent = formattedTelefone;
                        }
                        if (sidebarAniversario) {
                            sidebarAniversario.textContent = formattedDate;
                        }
                    } else {
                        alert("Erro ao atualizar perfil. Tente novamente.");
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert("Erro ao atualizar perfil. Tente novamente.");
                });
            });
        }

        if (profileCircle) {
            profileCircle.addEventListener('mouseover', () => {
                profileCircle.style.transform = 'scale(1.1)';
            });

            profileCircle.addEventListener('mouseout', () => {
                profileCircle.style.transform = 'scale(1)';
            });
        }
    });
})();
