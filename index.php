<?php
session_start();
include_once('./includes/functions.php');
include_once('./includes/loading.php');
if (isset($_SESSION['id'])){
    $correct = total_user_cw($mysqli, $_SESSION['id'], '1'); // Total de acertos
$wrong = total_user_cw($mysqli, $_SESSION['id'], '0'); // Total de erros
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <title>DVC - QUESTÕES</title>
</head>

<body>
    <?php include('./includes/wpp_btn.php');?>
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
            <main id="home-menu-root" class="animate__animated animate__fadeInUp">
                <div id="header_root_index">
                    <h1 id="welcome_user_title">Bem vindo de volta, <?php echo $_SESSION['name']?>!</h1>
                    <span id="motivacional"></span>
                    <div id="general_st">
                        <h6>
                            <ion-icon name="document-text-outline" role="img" class="md hydrated"
                                aria-label="document text outline"></ion-icon> Questões Resolvidas:
                            <?php echo total_questions_answered($mysqli, $_SESSION['id']); ?>
                        </h6>
                        <h6 id="correct">
                            <ion-icon name="happy-outline"></ion-icon> Questões Acertadas: <?php echo $correct; ?>
                        </h6>
                        <h6 id="wrong">
                            <ion-icon name="sad-outline"></ion-icon> Questões Erros: <?php echo $wrong; ?>
                        </h6>
                    </div>
                </div>


                <div class="container_ind">
                    <h1>Simulados Recentes</h1>
                    <div class="carousel-container">
                        <button class="sim_btn prev" onclick="scrollToLeft()">&#10094;</button>
                        <div class="carousel">
                            <div class="simulado-card">
                                <h2>(Amostra) Projeto Decorando a Lei Seca - 1ª Semana</h2>
                                <p>155 questões</p>
                                <div class="footer-card">
                                    <i class="fa fa-calendar"></i>
                                    <span>04/04/2023</span>
                                </div>
                            </div>
                            <div class="simulado-card">
                                <h2>(Amostra) Projeto Decorando a Lei Seca - 1ª Semana</h2>
                                <p>155 questões</p>
                                <div class="footer-card">
                                    <i class="fa fa-calendar"></i>
                                    <span>04/04/2023</span>
                                </div>
                            </div>
                            <div class="simulado-card">
                                <h2>(Amostra) Projeto Decorando a Lei Seca - 1ª Semana</h2>
                                <p>155 questões</p>
                                <div class="footer-card">
                                    <i class="fa fa-calendar"></i>
                                    <span>04/04/2023</span>
                                </div>
                            </div>
                            <div class="simulado-card">
                                <h2>(Amostra) Projeto Decorando a Lei Seca - 1ª Semana</h2>
                                <p>155 questões</p>
                                <div class="footer-card">
                                    <i class="fa fa-calendar"></i>
                                    <span>04/04/2023</span>
                                </div>
                            </div>
                            <div class="simulado-card">
                                <h2>(Amostra) Projeto Decorando a Lei Seca - 1ª Semana</h2>
                                <p>155 questões</p>
                                <div class="footer-card">
                                    <i class="fa fa-calendar"></i>
                                    <span>04/04/2023</span>
                                </div>
                            </div>
                            <div class="simulado-card">
                                <h2>(Amostra) Projeto Decorando a Lei Seca - 1ª Semana</h2>
                                <p>155 questões</p>
                                <div class="footer-card">
                                    <i class="fa fa-calendar"></i>
                                    <span>04/04/2023</span>
                                </div>
                            </div>
                            <div class="simulado-card">
                                <h2>(Amostra) Projeto Decorando a Lei Seca - 1ª Semana</h2>
                                <p>155 questões</p>
                                <div class="footer-card">
                                    <i class="fa fa-calendar"></i>
                                    <span>04/04/2023</span>
                                </div>
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
                        <button class="sim_btn next" onclick="scrollRight()">&#10095;</button>
                    </div>
                </div>
                <div class="video-container">
                    <h1>Vídeos Recomendados</h1>
                    <div class="carousel-container">
                        <button class="sim_btn prev" onclick="scrollToLeftv()">&#10094;</button>
                        <div class="carousel" id="videoCarousel">
                            <div class="video-card">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/_2c8YZwzaMk?si=EjvK9BJ52fuiGK4s"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                            <div class="video-card">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID_2"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                            <div class="video-card">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID_3"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                            <div class="video-card">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID_4"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                            <div class="video-card">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID_5"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                            <!-- Adicione mais vídeos conforme necessário -->
                        </div>
                        <button class="sim_btn next" onclick="scrollRightv()">&#10095;</button>
                    </div>
                </div>

            </main>
        </nav>
    </main>
</body><?php include_once('./includes/footer.php')?>
<script src=" https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/index.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./scripts/protect.js"></script>

</html>