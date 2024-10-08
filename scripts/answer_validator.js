$(document).ready(function() {
    // Inicializa as variáveis de contagem
    var corrects = 0;
    var wrongs = 0;

    // Manipulador de envio de formulário
    $('.question').on('submit', function(event) {
        event.preventDefault(); // Evita o envio do formulário

        const $form = $(this);
        const questionID = $form.find('.span_number_list').text().replace('#', ''); // Obtém o ID da questão
        const selectedOption = $form.find('input[type="radio"]:checked'); // Verifica a opção selecionada

        if (selectedOption.length > 0) {
            const alternative = selectedOption.val(); // Obtém o valor da alternativa selecionada

            // Envia a requisição AJAX
            $.ajax({
                url: './actions/validate_answer.php',
                type: 'POST',
                data: {
                    question_id: questionID,
                    alternative: alternative
                },
                success: function(response) {
                    // Verifica a resposta do servidor
                    if (response.trim() === 'correct') {
                        // Incrementa a contagem de respostas corretas
                        corrects += 1;
                        console.log('Corretas: ' + corrects);

                        // Exibe a mensagem de resposta correta
                        $('#cmsg_' + questionID).show();
                        $('#wmsg_' + questionID).hide();
                    } else if (response.trim() === 'wrong') {
                        // Incrementa a contagem de respostas erradas
                        wrongs += 1;
                        console.log('Erradas: ' + wrongs);

                        // Exibe a mensagem de resposta errada
                        $('#wmsg_' + questionID).show();
                        $('#cmsg_' + questionID).hide();
                    }
                },
                error: function(xhr, status, error) {
                    alert('Ocorreu um erro ao enviar a resposta.');
                }
            });
        } else {
            alert('Por favor, selecione uma alternativa.');
        }
    });
});
