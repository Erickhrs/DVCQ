<?php
session_start();
require_once('./includes/connection.php');
require_once('./includes/functions.php');
require_once('./includes/protect.php');
include_once('./includes/loading.php');

$bookId = getBookName($mysqli, $_POST['id']);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/logo.ico" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/index.css">
    <link rel="stylesheet" href="./style/questions.css">
    <link rel="stylesheet" href="./style/wrong_questions_book.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>DVC - QUESTÕES</title>
</head>

<body>
    <div class="cronometro-container">
        <span id="cronometro">00:00:00</span>
        <div>
            <button onclick="startTimer()"><i class='bx bx-play'></i></button>
            <button onclick="pauseTimer()">
                <i class='bx bx-pause'></i>
            </button>
            <button onclick="toggleColor()"><i class='bx bx-show'></i></button>
        </div>
    </div>
    <main id="root">
        <div style="display: none;">
            <span id="userId"><?php echo $_SESSION['id'];?></span>
            <span id="wrongs"></span>
            <span id="corrects"></span>
        </div>
        <div>
            <div id="book_header">
                <h1>📓 <?php echo $bookId;?></h1>
            </div>
            <div id="questions_container">
                <?php 
                if (isset($_SESSION['id'])){
                    include_once('./includes/wrong_book.php'); 
                }
                ?>
                <button id="finish">Finalizar Simulado</button>
            </div>
            <div>

            </div>
        </div>

    </main>

    <!-- Modal -->
    <div id="notConnectedModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>
            <div class="icon">
                <ion-icon name="sad-outline"></ion-icon>
            </div>
            <h2>Você não está conectado</h2>
            <p>Para visualizar todas as alternativas, você precisa estar logado. Caso não tenha uma conta, faça login ou
                assine um plano para ter acesso ilimitado.</p>
            <a href="./login.php" class="login-link">Ir para Login</a>
        </div>
    </div>

</body><?php include_once('./includes/footer.php')?>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

<script src=" ./scripts/answer_validator.js"></script>
<script src="./scripts/questions.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="./scripts/wrong_questions_book.js"></script>
<script src="./scripts/global.js"></script>


</html>