<?php
session_start();
include_once('./includes/loading.php');
include_once('./includes/connection.php');

function gerarSenhaAleatoria() {
    $senhas = [
        'QuestãoTop123!', 'EstudoFácil2028$', 'DVCQ-Aprovado789!', 'MasterExame456$', 
        'ProvaSegura2028!', 'RespostaCerta789$', 'DesafioQuest!123', 'NotaMaxima2028!', 
        'FocusNosEstudos321!', 'SucessoNoDVCQ2028!'
    ];
    return $senhas[array_rand($senhas)];
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verifica se o email foi preenchido
    if (empty($email)) {
        $_SESSION['erro'] = 'Por favor, digite um email.';
    } else {
        // Busca o email no banco de dados
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se o email existe
        if ($result->num_rows > 0) {
            // Gera uma nova senha aleatória
            $novaSenha = gerarSenhaAleatoria();
            $senhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);

            // Atualiza a senha no banco de dados
            $stmt = $mysqli->prepare("UPDATE users SET psw = ? WHERE email = ?");
            $stmt->bind_param("ss", $senhaCriptografada, $email);
            if ($stmt->execute()) {
                // Envia a nova senha para o email do usuário
                $para = $email;
                $assunto = "Recuperação de Senha";
                $mensagem = "Sua nova senha é: $novaSenha";
                $headers = "From: suporte@seudominio.com\r\n";
                
                if (mail($para, $assunto, $mensagem, $headers)) {
                    $_SESSION['sucesso'] = 'Uma nova senha foi enviada para o seu email.';
                } else {
                    $_SESSION['erro'] = 'Ocorreu um erro ao enviar o email. Tente novamente.';
                }
            } else {
                $_SESSION['erro'] = 'Ocorreu um erro ao atualizar sua senha. Tente novamente.';
            }
        } else {
            $_SESSION['erro'] = 'Email não encontrado.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DVC - Recuperar Senha</title>
    <link rel="stylesheet" href="./style/login.css">
    <link rel="stylesheet" href="./style/global.css">
</head>

<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>Digite o email da sua conta</header>
                <form action="" method="post">
                    <?php
                    if (isset($_SESSION['erro'])) {
                        echo '<span class="erroMSG">' . $_SESSION['erro'] . '</span>';
                        unset($_SESSION['erro']);
                    }
                    if (isset($_SESSION['sucesso'])) {
                        echo '<span class="sucessoMSG">' . $_SESSION['sucesso'] . '</span>';
                        unset($_SESSION['sucesso']);
                    }
                    ?>
                    <div class="field input-field">
                        <input type="email" placeholder="Email" class="input" name="email" required>
                    </div>

                    <div class="field button-field">
                        <button type="submit">Recuperar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>