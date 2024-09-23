<?php
include('./includes/connection.php');

// Prepara a consulta
$stmt = $mysqli->prepare("SELECT question_ID, user_ID, picture, comment, created_at FROM comments WHERE question_ID = ?");
$stmt->bind_param("s", $idQuestion); // 's' para string

// Executa a consulta
$stmt->execute();

// Obtém o resultado
$result_cmts = $stmt->get_result();
$total_comments = $result_cmts->num_rows;
?>

<div class="comments-container">
    <div class="comments-header">
        <h2>Comentários (<?php echo $total_comments; ?>)</h2>
        <div class="new-comment-form">
            <input type="hidden" class="question_ID" data-question-id="<?php echo $idQuestion; ?>"
                value="<?php echo $idQuestion; ?>">
            <input type="hidden" class="user_ID" value="<?php echo $_SESSION['id']; ?>">
            <input type="text" class="comment" placeholder="Adicione um comentário">
            <span class="submit-comment" data-question-id="<?php echo $idQuestion; ?>">Enviar</span>
        </div>
    </div>

    <?php
    if ($total_comments > 0) {
        while ($inf_cmts = $result_cmts->fetch_assoc()) {
            echo '<div class="comment-item">';
            echo '    <img src="' . $inf_cmts['picture'] . '" alt="User Picture" class="user-picture">'; // Adiciona a imagem
            echo '    <div class="comment-content">';
            echo '        <div class="comment-header">';
            echo '            <span class="user-id">' . getUserName($mysqli, $inf_cmts['user_ID']) . '</span>';
            echo '        </div>';
            echo '        <p class="comment-text">' . htmlspecialchars($inf_cmts['comment']) . '</p>';
            echo '        <div class="comment-footer">';
            echo '            <span class="comment-date">' . date('d/m/Y', strtotime($inf_cmts['created_at'])) . '</span>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
    } else {
        echo '<div class="no-comments">Nenhum comentário.</div>';
    }
    ?>
</div>

<?php
// Fecha a declaração
$stmt->close();
?>


<!-- Adicione o CSS abaixo ao seu arquivo de estilos -->
<style>
.comments-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 100%;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f4f4f4;
}

.comments-header {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 15px;
}

.comments-header h2 {
    margin: 0;
    font-size: 1.5em;
    color: #333;
}

.new-comment-form {
    display: flex;
    gap: 10px;
    align-items: center;
}

.new-comment-form input[type="text"] {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.new-comment-form .submit-comment {
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.new-comment-form .submit-comment:hover {
    background-color: #0056b3;
}

.comment-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
}

.user-picture {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

.comment-content {
    flex: 1;
}

.comment-header {
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.comment-text {
    margin: 0;
    color: #555;
    line-height: 1.5;
}

.comment-footer {
    margin-top: 10px;
    font-size: 0.9em;
    color: #888;
    text-align: right;
}

.comment-date {
    font-size: 0.9em;
}

.no-comments {
    text-align: center;
    color: #999;
    font-style: italic;
    padding: 20px;
}
</style>

<!-- Adicione o JavaScript abaixo ao final do seu arquivo -->
<script>
document.querySelectorAll('.submit-comment').forEach(function(button) {
    button.addEventListener('click', function() {
        const questionID = this.getAttribute(
            'data-question-id'); // Obtém o question_ID a partir do botão clicado
        const userID = document.querySelector('.user_ID').value;
        const comment = document.querySelector(`.question_ID[data-question-id="${questionID}"]`)
            .parentElement.querySelector('.comment').value.trim();

        if (comment === '') {
            Swal.fire({
                title: 'Por favor, adicione um comentário.',
                icon: 'error',
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 6000,
                toast: true,
                background: 'red',
                color: 'white',
                timerProgressBar: true
            });
            return;
        }

        const formData = new FormData();
        formData.append('question_ID', questionID);
        formData.append('user_ID', userID);
        formData.append('comment', comment);

        fetch('./actions/add_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Comentário em análise para liberação!',
                        icon: 'success',
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 6000,
                        toast: true,
                        background: '#1d3969',
                        color: 'white',
                        timerProgressBar: true
                    });
                    document.querySelector(`.question_ID[data-question-id="${questionID}"]`)
                        .parentElement.querySelector('.comment').value =
                        ''; // Limpa o campo de comentário
                } else {
                    Swal.fire({
                        title: 'Erro ao adicionar comentário. Tente novamente!',
                        icon: 'error',
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 6000,
                        toast: true,
                        background: 'red',
                        color: 'white',
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => console.error('Erro:', error));
    });
});
</script>