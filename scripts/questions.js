
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
                    background: '#ff9aac',
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
});

function disableBtn(id) {
    var element = document.getElementById("vbtn_" + id);
    var gabarito = document.querySelector('[data-target="gabarito_' + id + '"]');
    var comments = document.querySelector('[data-target="comments_' + id + '"]');
    var chartbtn = document.querySelector('[data-target="est_' + id + '"]');

    gabarito.style.display = 'initial';
    comments.style.display = 'initial';
    chartbtn.style.display = 'initial';
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

$(document).ready(function() {
    // Função para buscar os dados da questão e renderizar o gráfico
    function loadChart1(questionID) {
        $.ajax({
            url: './actions/unique_question_chart_doughnut.php', // Substitua pelo caminho correto do script PHP
            method: 'GET',
            data: { question_ID: questionID },
            dataType: 'json',
            success: function(data) {
                var ctx = document.getElementById('chart' + questionID).getContext('2d');

                var correctCount = data.correct_count;
                var incorrectCount = data.incorrect_count;

                var total = correctCount + incorrectCount;
                var correctPercentage = (correctCount / total) * 100;
                var incorrectPercentage = (incorrectCount / total) * 100;

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Acertos', 'Erros'],
                        datasets: [{
                            data: [correctCount, incorrectCount],
                            backgroundColor: ['#4CAF50', '#F44336'], // Verde para acertos, vermelho para erros
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        var label = tooltipItem.label;
                                        var value = tooltipItem.raw;
                                        var percentage = (value / total) * 100;
                                        return label + ': ' + value + ' (' + percentage.toFixed(2) + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    }



    // Função para gerar o gráfico de coluna
    function loadChart2(questionId) {
        $.ajax({
            url: './actions/unique_question_chart_columns.php',
            type: 'GET',
            data: { question_id: questionId },
            dataType: 'json',
            success: function(data) {
                var ctx = $('#chart2' + questionId)[0].getContext('2d');
                
                // Configura o gráfico
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['A', 'B', 'C', 'D', 'E', 'Falso', 'Verdadeiro'],
                        datasets: [{
                            label: 'Porcentagem de Respostas',
                            data: [
                                data['A'] || 0,
                                data['B'] || 0,
                                data['C'] || 0,
                                data['D'] || 0,
                                data['E'] || 0,
                                data['0'] || 0,
                                data['1'] || 0
                            ],
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    }

   

    

    // Exemplo: Carrega o gráfico quando o ícone de estatísticas é clicado
    $('.stbtn').on('click', function() {
        var target = $(this).data('target'); // O ID da questão
        var questionID = target.split('_')[1]; // Extrai o question_ID do target

        loadChart1(questionID); // Carrega o gráfico para a questão
        loadChart2(questionID); 
    });
});


$(document).ready(function() {
    $('#add-note-btn').click(function() {
        var note = $('#note').val();
        var questionID = $(this).data('question-id'); // Obtém o ID da questão do data attribute

        if (note.trim() === '') {
            alert('Por favor, digite uma nota antes de adicionar.');
            return;
        }

        // Faz a requisição AJAX para adicionar a nota
        $.ajax({
            url: './actions/add_note.php',
            type: 'POST',
            data: {
                note: note,
                question_ID: questionID
            },
            success: function(response) {
                console.log(response); // Exibe a resposta do servidor no console

                // Limpa o campo de texto
                $('#note').val('');

                // Recarrega as notas
                loadNotes();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erro ao adicionar nota: ' + textStatus, errorThrown);
            }
        });
    });

    // Função para recarregar as notas
    function loadNotes() {
        var questionID = $('#add-note-btn').data('question-id'); // Obtém o ID da questão novamente

        $.ajax({
            url: './includes/get_notes2.php',
            type: 'GET',
            data: { idQuestion: questionID },
            success: function(data) {
                $('.notes-container').html(data); // Atualiza o conteúdo das notas
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erro ao carregar notas: ' + textStatus, errorThrown);
            }
        });
    }
});