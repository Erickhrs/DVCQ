$(document).ready(function() {
    $('.question').on('submit', function(event) {
        event.preventDefault(); // Evita o envio do formulário

        const $form = $(this);
        const questionID = $form.find('.span_number_list').text().replace('#', '');
        const selectedOption = $form.find('input[type="radio"]:checked');

        if (selectedOption.length > 0) {
            const alternative = selectedOption.val();

            $.ajax({
                url: './actions/validate_answer.php',
                type: 'POST',
                data: {
                    question_id: questionID,
                    alternative: alternative
                },
                success: function(response) {
                    alert(response); // Exibe a mensagem de correto ou errado
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