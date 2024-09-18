<?php
include('./includes/connection.php');
$idUser = $_SESSION['id'];
$picture = $_SESSION['picture']; // Assumindo que a imagem está armazenada na sessão

// Prepara a consulta
$stmt = $mysqli->prepare("SELECT ID, user_ID, note, created_at FROM users_notes WHERE question_ID = ?");
$stmt->bind_param("s", $idQuestion); // 's' para string

// Executa a consulta
$stmt->execute();

// Obtém o resultado
$result_notes = $stmt->get_result();
?>

<div class="notes-container">
    <?php
    if ($result_notes->num_rows > 0) {
        while ($inf = $result_notes->fetch_assoc()) {
            echo '<div class="note-item" data-id="'.$inf['ID'].'">';
            echo '<img src="'.$picture.'" alt="User Picture" class="note-img"> '; // Adiciona a imagem
            echo '<span class="note-text">'.$inf['note'].'</span>';
            echo '<span class="note-date">'.date('d/m/Y', strtotime($inf['created_at'])).'</span>';
            echo '<div class="tools_notes">';
            echo '<i class="bx bx-edit edit-icon" onclick="editNote('.$inf['ID'].')"></i>';
            echo '<i class="bx bx-trash delete-icon" onclick="deleteNote('.$inf['ID'].')"></i>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<span class="no-notes">Nenhuma nota encontrada.</span>';
    }
    ?>
</div>

<?php
// Fecha a declaração
$stmt->close();
?>