<?php
include('../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $note = $_POST['note'];

    $stmt = $mysqli->prepare("UPDATE users_notes SET note = ? WHERE ID = ?");
    $stmt->bind_param("si", $note, $id);

    if ($stmt->execute()) {
        echo 'Nota atualizada com sucesso.';
    } else {
        echo 'Erro ao atualizar a nota.';
    }

    $stmt->close();
}
?>