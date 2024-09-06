
document.addEventListener('DOMContentLoaded', (event) => {
    // Seleciona todos os spans que devem acionar o modal
    const toolItems = document.querySelectorAll('.tool-item');
    // Seleciona o modal e o botão de fechar
    const modal = document.getElementById('notConnectedModal');
    const closeButton = document.getElementById('closeModal');
    const answerValidateButton = document.getElementById('answerValidate');

    // Adiciona o evento de clique para mostrar o modal
    toolItems.forEach(item => {
        item.addEventListener('click', () => {
            modal.style.display = 'block';
        });
    });

    // Adiciona o evento de clique para mostrar o modal quando o botão "Responder" for clicado
    if (answerValidateButton) {
        answerValidateButton.addEventListener('click', () => {
            modal.style.display = 'block';
        });
    }

    // Adiciona o evento de clique para esconder o modal
    closeButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Fecha o modal se o usuário clicar fora da área do modal
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});



document.querySelectorAll('.likeBtn').forEach(button => {
    button.addEventListener('click', function() {
        // Seleciona o ícone dentro do botão
        const icon = this.querySelector('ion-icon');

        // Verifica se o ícone já tem a classe 'liked'
        const alreadyLiked = icon.classList.contains('liked');

        // Alterna a classe 'liked' no ícone
        icon.classList.toggle('liked');

        // Exibe o toast com a mensagem apropriada
        Swal.fire({
            title: alreadyLiked ? 'Curtida removida!' : 'Curtida salva!',
            icon: 'success',
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            toast: true,
            background: '#1d3969',
            color: 'white',
            timerProgressBar: true,
            customClass: {
                container: 'toast-container'
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    // Seleciona todos os botões de Gabarito
    document.querySelectorAll('.toggle').forEach(button => {
        button.addEventListener('click', function() {
            // Obtém o ID do target a partir do atributo data-target
            const targetId = this.getAttribute('data-target');
            const targetElement = document.getElementById(targetId);

            // Alterna o display do elemento alvo
            if (targetElement.style.display === 'none' || targetElement.style.display === '') {
                targetElement.style.display = 'block';
            } else {
                targetElement.style.display = 'none';
            }
        });
    });

    // Configura gráficos para todos os elementos <canvas> com IDs únicos
    document.querySelectorAll('canvas').forEach((canvas) => {
        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Tipo do gráfico
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'Dataset',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
});

