<?php
// Inclui a conexão com o banco de dados
require '../includes/connection.php';

// Função para redirecionar com mensagem de erro
function redirectWithError($message) {
    echo "<script>
        localStorage.setItem('signupError', '{$message}');
        window.location.href = '../signup.html';
    </script>";
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $cpf = $_POST['cpf'];
    $address = $_POST['address'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $uf = $_POST['uf'];
    $cep = $_POST['cep'];
    $birth = $_POST['birth'];
    $since = date('Y-m-d'); // Formato da data: YYYY-MM-DD
    $psw = $_POST['psw'];
    $confirm_psw = $_POST['confirm_psw'];

    // Valida se as senhas são iguais
    if ($psw !== $confirm_psw) {
        redirectWithError("As senhas não coincidem!");
    }

    // Criptografa a senha
    $hashed_password = password_hash($psw, PASSWORD_DEFAULT);

    // Valida se o email já existe
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email_exists);
    $stmt->fetch();
    $stmt->close();

    if ($email_exists > 0) {
        redirectWithError("Email já cadastrado!");
    }

    // Valida se o telefone já existe
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->bind_result($phone_exists);
    $stmt->fetch();
    $stmt->close();

    if ($phone_exists > 0) {
        redirectWithError("Telefone já cadastrado!");
    }

    // Valida se o CPF já existe
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE CPF = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $stmt->bind_result($cpf_exists);
    $stmt->fetch();
    $stmt->close();

    if ($cpf_exists > 0) {
        redirectWithError("CPF já cadastrado!");
    }

    // Prepara a consulta SQL para inserir o novo usuário
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, phone, CPF, address, district, city, UF, CEP, picture, birth, since, status, psw) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Define o status como 1 (ativo)
    $status = 1; // Mude para 1 para que o status seja ativo
    $picture = 'https://api.dicebear.com/9.x/thumbs/svg?seed=' . $name;
    
    // Vincula os parâmetros
    $stmt->bind_param("sssssssssssiss", $name, $email, $phone, $cpf, $address, $district, $city, $uf, $cep, $picture, $birth, $since, $status, $hashed_password);

    // Executa a consulta
    if ($stmt->execute()) {
        // Armazena informações no localStorage
        echo "<script>
            localStorage.setItem('signupName', '{$name}');
            localStorage.setItem('signupPicture', '{$picture}');
            window.location.href = '../success.html';
        </script>";
        exit;
    } else {
        redirectWithError("Erro: " . $stmt->error);
    }

    // Fecha a consulta
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$mysqli->close();
?>