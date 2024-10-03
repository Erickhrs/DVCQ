<?php
// Iniciar sessão
session_start();
include_once('./includes/loading.php');
// Incluir conexão com o banco de dados
include './includes/connection.php';
include './includes/protect.php';
// Verificar se o ID do usuário está na sessão
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    // Buscar informações do usuário no banco de dados
    $query = "SELECT name, email, phone, address, district, city, UF, CEP, birth FROM users WHERE id = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($name, $email, $phone, $address, $district, $city, $UF, $CEP, $birth);
        $stmt->fetch();
        $stmt->close();
    }
} else {
    echo "ID do usuário não está na sessão.";
    exit;
}

// Verificar se o formulário foi enviado para atualizar os dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $UF = $_POST['UF'];
    $CEP = $_POST['CEP'];
    $birth = $_POST['birth'];

    // Atualizar os dados no banco de dados
    $updateQuery = "UPDATE users SET name = ?, email = ?, phone = ?, address = ?, district = ?, city = ?, UF = ?, CEP = ?, birth = ? WHERE id = ?";
    if ($stmt = $mysqli->prepare($updateQuery)) {
        $stmt->bind_param("sssssssssi", $name, $email, $phone, $address, $district, $city, $UF, $CEP, $birth, $id);
        if ($stmt->execute()) {
            header('Location: ./profile.php');
        } else {
            echo "<p class='error'>Erro ao atualizar dados: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 100%;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    label {
        font-weight: bold;
        color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="submit"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        font-size: 16px;
    }

    input[type="submit"] {
        grid-column: span 2;
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
        <h1>Editar Informações</h1>
        <form action="" method="POST">
            <label for="name">Nome:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="phone">Telefone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

            <label for="address">Endereço:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" required>

            <label for="district">Bairro:</label>
            <input type="text" name="district" value="<?php echo htmlspecialchars($district); ?>" required>

            <label for="city">Cidade:</label>
            <input type="text" name="city" value="<?php echo htmlspecialchars($city); ?>" required>

            <label for="UF">UF:</label>
            <input type="text" name="UF" value="<?php echo htmlspecialchars($UF); ?>" required maxlength="2">

            <label for="CEP">CEP:</label>
            <input type="text" name="CEP" value="<?php echo htmlspecialchars($CEP); ?>" required>

            <label for="birth">Data de Nascimento:</label>
            <input type="text" name="birth" value="<?php echo htmlspecialchars($birth); ?>" required>

            <input type="submit" value="Atualizar">
        </form>
    </div>
</body>

</html>