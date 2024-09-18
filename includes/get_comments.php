<?php
include('./includes/connection.php');
// Prepara a consulta
$stmt = $mysqli->prepare("SELECT question_ID, user_ID, picture, comment, created_at FROM comments WHERE question_ID = ?");
$stmt->bind_param("s", $idQuestion); // 's' para string

// Executa a consulta
$stmt->execute();

// Obtém o resultado
$result_cmts = $stmt->get_result();
?>

<div class="comments-container">
    <?php
    if ($result_cmts->num_rows > 0) {
        while ($inf_cmts = $result_cmts->fetch_assoc()) {
            echo '<div class="comment-item">';
            echo '    <img src="' . $inf_cmts['picture'] . '" alt="User Picture" class="user-picture">'; // Adiciona a imagem
            echo '    <div class="comment-content">';
            echo '        <div class="comment-header">';
            echo '            <span class="user-id">' . getUserName($mysqli,$inf_cmts['user_ID']) . '</span>';
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