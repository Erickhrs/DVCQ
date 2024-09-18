
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
        const icon = this.querySelector('ion-icon');
        const questionId = this.getAttribute('data-id');
        
        // Alterna a classe 'liked' no botão
        const alreadyLiked = this.classList.contains('liked');
        this.classList.toggle('liked');

        // Envia a requisição AJAX para adicionar/remover a curtida
        fetch('./actions/handle_like.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'question_id': questionId,
                'action': alreadyLiked ? 'unlike' : 'like' // Adiciona uma ação para o servidor saber se é para curtir ou desfazer a curtida
            })
        })
        .then(response => response.text()) // Receba a resposta como texto
        .then(data => {
            try {
                const jsonData = JSON.parse(data); // Tente analisar o JSON

                // Exibe o toast com a mensagem apropriada
                Swal.fire({
                    title: alreadyLiked ? 'Curtida removida!' : 'Curtida salva!',
                    icon: alreadyLiked ? 'error' : 'success',
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
            } catch (e) {
                console.error('Erro ao analisar JSON:', e);
            }
        })
        .catch(error => console.error('Erro na requisição:', error));
    });
});






document.addEventListener('DOMContentLoaded', function() {
    // Obtém todos os botões de feedback com a classe 'feedback_btn'
    const feedbackButtons = document.querySelectorAll('.feedback_btn');

    feedbackButtons.forEach(button => {
        button.addEventListener('click', async function() {
            // Obtém o session_id e question_id dos atributos data-*
            const sessionId = this.dataset.sessionId;
            const questionId = this.dataset.questionId;

            // Usa o SweetAlert2 para solicitar o feedback do usuário
            const { value: text } = await Swal.fire({
                input: 'textarea',
                inputLabel: 'Message',
                inputPlaceholder: 'Type your message here...',
                inputAttributes: {
                    'aria-label': 'Type your message here'
                },
                showCancelButton: true
            });

            if (text) {
                // Envia o feedback para o servidor
                try {
                    const response = await fetch('./actions/process_feedback.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            user_ID: sessionId, // Usa o session_id obtido
                            question_ID: questionId, // Usa o question_id obtido
                            feedback: text
                        })
                    });

                    if (response.ok) {
                        Swal.fire('Feedback enviado com sucesso!');
                    } else {
                        Swal.fire('Erro ao enviar feedback.');
                    }
                } catch (error) {
                    Swal.fire('Erro ao enviar feedback.');
                    console.error('Erro:', error);
                }
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

function disableBtn(id) {
    var element = document.getElementById("vbtn_" + id);
    element.innerHTML = "Respondido";
    element.style.backgroundColor = "#8080804f";
    element.style.cursor = "not-allowed";
    setTimeout(function() {
        element.disabled = true;
    }, 1000); // Atraso de 1 segundo (1000 milissegundos)
}


function editNote(id) {
    let newNote = prompt("Editar nota:");

    if (newNote) {
        $.ajax({
            url: './actions/edit_note.php',
            type: 'POST',
            data: { id: id, note: newNote },
            success: function(response) {
                alert(response);
                location.reload(); // Recarrega a página para atualizar as notas
            }
        });
    }
}

function deleteNote(id) {
    if (confirm("Tem certeza de que deseja excluir esta nota?")) {
        $.ajax({
            url: './actions/delete_note.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                alert(response);
                $('div[data-id="'+id+'"]').remove(); // Remove o item da página sem recarregar
            }
        });
    }
}