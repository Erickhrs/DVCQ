const urlPath = window.location.pathname;
const fileName = urlPath.substring(urlPath.lastIndexOf('/') + 1);

switch (fileName) {
    case 'index.php':
        document.getElementById("home").style.color = "#80ad64"; 
        break;
    case 'questions.php':
        document.getElementById("questions").style.color = "#80ad64"; 
        break;
    case 'classes.php':
        document.getElementById("classes").style.color = "#80ad64"; 
        break;
    case 'exams.php':
        document.getElementById("exams").style.color = "#80ad64"; 
        break;
    case 'disciplines.php':
        document.getElementById("disciplines").style.color = "#80ad64"; 
        break;
}



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