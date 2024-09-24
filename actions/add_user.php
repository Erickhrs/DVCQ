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

//enviar email
function sendConfirmationEmail($email, $name, $first_password) {
    $to = $email;
    $subject = "Confirmação de Cadastro";
    
    // Corpo do e-mail
    $message = "
    <html>
    <head>
        <title>Confirmação de Cadastro</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #333333;
                padding: 20px;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #4CAF50;
                padding: 10px;
                border-radius: 8px 8px 0 0;
                text-align: center;
                color: white;
            }
            .content {
                margin: 20px 0;
            }
            .content p {
                line-height: 1.6;
            }
            .password {
                font-size: 18px;
                font-weight: bold;
                color: #ff5722;
            }
            .footer {
                text-align: center;
                color: #777777;
                font-size: 12px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Confirmação de Cadastro</h1>
            </div>
            <div class='content'>
                <p>Olá, <strong>{$name}</strong>!</p>
                <p>Obrigado por se cadastrar em nosso sistema.</p>
                <p>Sua senha de <strong>PRIMEIRO</strong> acesso é:</p>
                <p class='password'>{$first_password}</p>
                <p>Após o primeiro login, você poderá continuar usando sua senha padrão cadastrada.</p>
            </div>
            <div class='footer'>
                <p>Atenciosamente,</p>
                <p>Equipe de Suporte</p>
            </div>
        </div>
    </body>
    </html>
    ";

    // Definindo os headers para enviar e-mail em HTML
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // Cabeçalhos adicionais
    $headers .= 'From: no-reply@dvcquestoes.com' . "\r\n";

    // Envia o e-mail
    mail($to, $subject, $message, $headers);
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

    // Criptografa a senha original
    $hashed_password = password_hash($psw, PASSWORD_DEFAULT);

    // Gera uma senha aleatória para email_validation
    $email_validation_password = bin2hex(random_bytes(16));

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

    // Prepara a consulta SQL para inserir o novo usuário, incluindo a senha aleatória
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, phone, CPF, address, district, city, UF, CEP, picture, birth, since, status, psw, email_validation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $status = 0; 
    $picture = 'https://api.dicebear.com/9.x/thumbs/svg?seed=' . $name;
    
    // Vincula os parâmetros, incluindo a senha aleatória para email_validation
    $stmt->bind_param("sssssssssssisss", $name, $email, $phone, $cpf, $address, $district, $city, $uf, $cep, $picture, $birth, $since, $status, $hashed_password, $email_validation_password);

    // Executa a consulta
    if ($stmt->execute()) {

        sendConfirmationEmail($email, $name, $email_validation_password);
        
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