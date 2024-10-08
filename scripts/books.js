document.getElementById('searchInput').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let notebookItems = document.querySelectorAll('.notebook-item');

    notebookItems.forEach(function(item) {
        let title = item.querySelector('p').textContent.toLowerCase();
        if (title.includes(filter)) {
            item.style.display = ''; // Mostrar o item
        } else {
            item.style.display = 'none'; // Ocultar o item
        }
    });
});

$(document).ready(function() {
    // Abre o modal ao clicar no botão "Criar"
    $('.create-button').on('click', function() {
        $('#createBookModal').show();
    });

    // Fecha o modal ao clicar no "x"
    $('.close').on('click', function() {
        $('#createBookModal').hide();
    });

    // Fecha o modal ao clicar fora do conteúdo
    $(window).on('click', function(event) {
        if ($(event.target).is('#createBookModal')) {
            $('#createBookModal').hide();
        }
    });

    // Envio do formulário
    $('#createNotebookForm').on('submit', function(event) {
        event.preventDefault(); // Evita o envio padrão do formulário

        const notebookName = $('#notebookName').val();

        $.ajax({
            url: './actions/create_book.php', // URL do script para processar a criação
            type: 'POST',
            data: { name: notebookName },
            success: function(response) {
                // Aqui você pode manipular a resposta do servidor
                if (response.trim() === 'success') {
                    $('#notebookList').html('');
                    $('#notebookList').append(`
                        <li class="notebook-item">
                            <div class="notebook-details">
                                <i>📓</i>
                                <div>
                                    <p>${notebookName}</p>
                                    <span class="date">Criado recentemente | 0 questões</span>
                                </div>
                            </div>
                            <div class="options">⋮</div>
                        </li>
                    `);
                    // Limpa o campo de entrada e fecha o modal
                    $('#notebookName').val('');
                    $('#createNotebookModal').hide();
                } else {
                    alert('Erro ao criar caderno. Tente novamente.');
                }
            },
            error: function() {
                alert('Ocorreu um erro ao criar o caderno.');
            }
        });
    });
});