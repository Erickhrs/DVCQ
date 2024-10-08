<?php
include('./includes/connection.php');

$userId = $_SESSION['id'];

// Prepara a consulta
$stmt = $mysqli->prepare("SELECT ID, name, owner, created_at FROM users_books WHERE owner = ?");
$stmt->bind_param("s", $userId); 

// Executa a consulta
$stmt->execute();

// Obtém o resultado
$result_cmts = $stmt->get_result();
$total_comments = $result_cmts->num_rows;

if ($total_comments > 0) {
    echo '<ul class="notebook-list">'; // Começa uma lista não ordenada
    while ($inf_cmts = $result_cmts->fetch_assoc()) {
        // Formata a data
        $formattedDate = date('d/m/Y', strtotime($inf_cmts['created_at']));
        
        echo '<li class="notebook-item">';
        echo '<div class="notebook-details">';
        echo '<i>📓</i>';
        echo '<div>';
        echo '<p>' . htmlspecialchars($inf_cmts['name']) . '</p>'; // Exibe o nome do caderno
        echo '<span class="date">Criado em ' . $formattedDate . ' | 0 questões</span>'; // Formata a data de criação
        echo '</div>';
        echo '</div>';
        echo '<div class="options">';
          echo '
          <div class="options">
          <form action="./edit_book.php" method="POST">
         <input name="id" type="hidden" value="' . $inf_cmts['ID']  . '">
          <button type="submit"><i class="bx bx-play"></i></button>
          </form>
          </div>';
          echo '
          <div class="options">
          <form action="./edit_book.php" method="POST">
          <input name="id" type="hidden" value="' . $inf_cmts['ID']  . '">
         <button class="options"><i class="bx bx-edit-alt" ></i></button>
          </form>
          </div>';
        echo '</div>';
        echo '</li>';
    }
    echo '</ul>'; // Fecha a lista não ordenada
} else {
    echo '<div><i class="bx bx-sad"></i> Nenhum caderno encontrado.</div>';
}

// Fecha a declaração
$stmt->close();
?>