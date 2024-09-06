document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.question');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Evita o envio do formulário

            const questionID = form.querySelector('.span_number_list').textContent.replace('#',
                '');
            const selectedOption = form.querySelector('input[type="radio"]:checked');

            if (selectedOption) {
                const alternative = selectedOption.value;

                // Envia via AJAX para validação
                const xhr = new XMLHttpRequest();
                xhr.open('POST', './actions/validate_answer.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert(xhr.responseText); // Exibe a mensagem de correto ou errado
                    }
                };
                xhr.send(`question_id=${questionID}&alternative=${alternative}`);
            } else {
                alert('Por favor, selecione uma alternativa.');
            }
        });
    });
});