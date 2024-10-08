<?php
// Conexão com o banco de dados
include('./includes/connection.php');


// Obtendo o ID do livro via GET
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    // Consulta para buscar o nome do livro
    $query = "SELECT name FROM users_books WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "ID inválido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/edit_book.css">
    <title>Edição de Caderno</title>
</head>

<body>
    <h1>Editar caderno</h1>
    <form action="./actions/update_book.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="name">Nome do caderno:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        <button type="submit">Salvar</button>
    </form>

</body>

</html>