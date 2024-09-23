<?php
// Iniciar sessão
session_start();

// Incluir conexão com o banco de dados
include './includes/connection.php';
include './includes/protect.php';
// Verificar se o ID do usuário está na sessão
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    echo "ID do usuário não está na sessão.";
    exit;
}

// Verificar se o formulário foi enviado para atualizar a senha
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar se as senhas são iguais
    if ($new_password === $confirm_password) {
        // Criptografar a nova senha (opcional, mas recomendado)
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Atualizar a senha no banco de dados
        $updateQuery = "UPDATE users SET psw = ? WHERE id = ?";
        if ($stmt = $mysqli->prepare($updateQuery)) {
            $stmt->bind_param("si", $hashed_password, $id);
            if ($stmt->execute()) {
                header('Location: ./logout.php');
            } else {
                echo "<p class='error'>Erro ao atualizar senha: " . $stmt->error . "</p>";
            }
            $stmt->close();
        }
    } else {
        echo "<p class='error'>As senhas não coincidem. Tente novamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Senha</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        animation: fadeInUp 1s ease-in-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
            /* Ajuste o valor conforme necessário */
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #1d3969;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    label {
        font-weight: bold;
        color: #555;
    }

    input[type="password"],
    input[type="submit"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        font-size: 16px;
    }

    input[type="submit"] {
        background-color: #28a745;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #218838;
    }

    .success {
        color: #28a745;
        text-align: center;
    }

    .error {
        color: #dc3545;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Editar Senha</h1>
        <form action="" method="POST">
            <label for="new_password">Nova Senha:</label>
            <input type="password" name="new_password" required>

            <label for="confirm_password">Confirmar Nova Senha:</label>
            <input type="password" name="confirm_password" required>

            <input type="submit" value="Atualizar Senha">
        </form>
    </div>
</body>

</html>