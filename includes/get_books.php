<?php
include('./includes/connection.php');
include('./includes/functions.php');
$userId = $_SESSION['id'];

// Prepara a consulta
$stmt = $mysqli->prepare("SELECT ID, name, owner, created_at FROM users_books WHERE owner = ? ORDER BY ID DESC");
$stmt->bind_param("s", $userId); 

// Executa a consulta
$stmt->execute();

// Obtém o resultado
$result_cmts = $stmt->get_result();
$total_comments = $result_cmts->num_rows;

if ($total_comments > 0) {
    echo '<ul class="notebook-list">'; 
   
    if (checkUserAnswering($mysqli, $userId) == 1) {
        echo '
        <li class="notebook-item">
            <div class="notebook-details">
                <i>📓</i>
                <div>
                    <p>Caderno de erros</p>
                    <span class="date"> Desde que você se cadastrou | 0 questões</span>
                </div>
            </div>
            <div class="options">
                <form action="./wrong_questions_book.php" method="POST">
                    <button type="submit"><i class="bx bx-play"></i></button>
                </form>
            </div>
        </li>';
    }

    while ($inf_cmts = $result_cmts->fetch_assoc()) {
        // Formata a data
        $formattedDate = date('d/m/Y', strtotime($inf_cmts['created_at']));
        $totalQuestions = countQuestionsForBook($mysqli, $inf_cmts['ID']); // Conta as questões do caderno
        
        echo '<li class="notebook-item">';
        echo '<div class="notebook-details">';
        echo '<i>📓</i>';
        echo '<div>';
        echo '<p>' . htmlspecialchars($inf_cmts['name']) . '</p>'; // Exibe o nome do caderno
        echo '<span class="date">Criado em ' . $formattedDate . ' | ' . $totalQuestions . ' questões</span>'; // Formata a data de criação
        echo '</div>';
        echo '</div>';
        echo '<div class="options">';

        // Botão de play com SweetAlert caso não tenha questões
        echo '
        <form action="./question_book.php" method="POST" class="play-form">
            <input name="id" type="hidden" value="' . $inf_cmts['ID'] . '">
            <button type="button" onclick="checkQuestions(' . $totalQuestions . ', this.form)"><i class="bx bx-play"></i></button>
        </form>';
        
        // Botão de editar
        echo '
        <form action="./edit_book.php" method="POST">
            <input name="id" type="hidden" value="' . $inf_cmts['ID']  . '">
            <button class="options"><i class="bx bx-edit-alt"></i></button>
        </form>';

        // Botão de exclusão
        echo '
        <form action="./actions/delete_book.php" method="POST" class="delete-form" style="display:inline;">
            <input name="id" type="hidden" value="' . $inf_cmts['ID'] . '">
            <button type="button" class="delete-button" onclick="confirmDelete(this.form)"><i class="bx bx-trash"></i></button>
        </form>';

        echo '</div>';
        echo '</li>';
    }
    
    echo '</ul>'; // Fecha a lista não ordenada
} else {
    //echo '<div><i class="bx bx-sad"></i> Nenhum caderno encontrado.</div>';
}

// Fecha a declaração
$stmt->close();
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(form) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // Envia o formulário se o usuário confirmar
        }
    });
}
</script>