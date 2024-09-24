<?php
include('../includes/connection.php');
session_start();

if (isset($_POST['email'], $_POST['password'])) {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Busca o usuário pelo email
    $sql_code = "SELECT * FROM users WHERE email = '$email'";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    if ($sql_query->num_rows == 1) {
        $usuario = $sql_query->fetch_assoc();
        $hashedPassword = $usuario['psw'];
        $emailValidation = $usuario['email_validation'];
        $status = $usuario['status'];

        // Verifica se o email_validation não está "ok"
        if ($emailValidation !== 'ok') {
            // Verifica a senha do campo email_validation
            if ($password === $emailValidation) {
                // Atualiza o status para 1 (ativo) e define o email_validation como "ok"
                $update_sql = "UPDATE users SET status = 1, email_validation = 'ok' WHERE email = '$email'";
                $mysqli->query($update_sql) or die("Falha na execução do código SQL: " . $mysqli->error);

                // Define as variáveis de sessão
                $_SESSION['plan'] = $usuario['plan'];
                $_SESSION['id'] = $usuario['ID'];
                $_SESSION['name'] = $usuario['name'];
                $_SESSION['picture'] = $usuario['picture'];
                session_regenerate_id();
                
                header("Location: ../index.php");
                exit;
            } else {
                // Senha incorreta para o email_validation
                $_SESSION['erro'] = "Senha incorreta";
                header("Location: ../login.php");
                exit;
            }
        } elseif (password_verify($password, $hashedPassword)) {
            // Senha correta no campo psw
            $_SESSION['plan'] = $usuario['plan'];
            $_SESSION['id'] = $usuario['ID'];
            $_SESSION['name'] = $usuario['name'];
            $_SESSION['picture'] = $usuario['picture'];
            session_regenerate_id();
            
            header("Location: ../index.php");
            exit;
        } else {
            // Senha incorreta
            $_SESSION['erro'] = "Senha incorreta";
            header("Location: ../login.php");
            exit;
        }
    } else {
        // Usuário não encontrado
        $_SESSION['erro'] = "Usuário não encontrado";
        header("Location: ../login.php");
        exit;
    }
} else {
    // Campos não preenchidos
    $_SESSION['erro'] = "Preencha todos os campos";
    header("Location: ../login.php");
    exit;
}
?>