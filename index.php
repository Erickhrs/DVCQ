<?php
session_start();
include_once('./includes/functions.php');

$correct = total_user_cw($mysqli, $_SESSION['id'], '1'); // Total de acertos
$wrong = total_user_cw($mysqli, $_SESSION['id'], '0'); // Total de erros
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/index.css">
    <title>DVC - QUESTÕES</title>
</head>

<body>
    <div style="background-color: white;">
        <?php require_once('./includes/navbar.php');?>
        <?php require_once('./includes/nav_menu.php');?>
    </div>
    <main id="root" class="protected_content">
        <nav id="home-menu">
            <ul>
                <li><a href="./index.php" class="active">
                        <ion-icon name="rocket-outline"></ion-icon> Ambiente de estudos
                    </a></li>
                <li><a href="./books.php">
                        <ion-icon name="document-text-outline"></ion-icon> Cadernos
                    </a></li>
                <li><a href="./statistics.php">
                        <ion-icon name="stats-chart-outline"></ion-icon> Meu Desempenho
                    </a></li>
            </ul>
            <main id="home-menu-root">
                <h1 id="welcome_user_title">Bem vindo de volta, <?php echo $_SESSION['name']?></h1>
                <div id="general_st">
                    <h6>Questões Resolvidas: <?php echo total_questions_answered($mysqli, $_SESSION['id']); ?>
                    </h6>
                    <h6 id="correct">Questões Acertadas: <?php echo $correct; ?></h6>
                    <h6 id="wrong">Questões Erros: <?php echo $wrong; ?></h6>
                </div>

                <div class="container_ind">
                    <h1>Simulados</h1>
                    <div class="search-box">
                        <input type="text" placeholder="Busque pelo nome">
                        <button>
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="simulado-card">
                        <h2>(Amostra) Projeto Decorando a Lei Seca - 1ª Semana</h2>
                        <p>155 questões</p>
                        <div class="footer-card">
                            <i class="fa fa-calendar"></i>
                            <span>04/04/2023</span>
                        </div>
                    </div>
                </div>
            </main>
        </nav>
    </main>
</body><?php include_once('./includes/footer.php')?>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./scripts/protect.js"></script>

</html>