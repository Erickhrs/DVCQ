<?php
include('../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $stmt = $mysqli->prepare("DELETE FROM users_notes WHERE ID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo 'Nota excluída com sucesso.';
    } else {
        echo 'Erro ao excluir a nota.';
    }

    $stmt->close();
}
?>