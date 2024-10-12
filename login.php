<?php
session_start();
include_once('./includes/loading.php');
?>
<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com-->
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DVC - QUESTÕES </title>

    <!-- CSS -->
    <link rel="shortcut icon" href="./assets/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="./style/login.css">
    <link rel="stylesheet" href="./style/global.css">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>Seja bem-vindo de volta! :)</header>

                <form action="./actions/login_validate.php" method="post">
                    <?php
                    if(isset($_SESSION['erro'])){
                        echo '<span class="erroMSG">'.$_SESSION['erro'].'</span>';
                    } ?>
                    <div class="field input-field">
                        <input type="email" placeholder="Email" class="input" name="email">
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Senha" class="password" name="password">
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="form-link">
                        <a href="./reset_password.php" class="forgot-pass">Esqueceu a senha?</a>
                    </div>

                    <div class="field button-field">
                        <button type="submit">Entrar</button>
                    </div>
                </form>

                <div class="form-link">
                    <span>Não tem uma conta? <a href="./signup.html" class="link signup-link">Cadastra-se</a></span>
                </div>
            </div>

            <div class="line"></div>

            <div class="media-options">
                <a href="#" class="field facebook">
                    <i class='bx bxl-facebook facebook-icon'></i>
                    <span>Login with Facebook</span>
                </a>
            </div>

            <div class="media-options">
                <a href="#" class="field google">
                    <img src="./assets/google.png" alt="" class="google-img">
                    <span>Login with Google</span>
                </a>
            </div>

        </div>
    </section>

    <!-- JavaScript -->
    <script src="./scripts/login.js"></script>
</body><?php include_once('./includes/footer.php')?>

</html>