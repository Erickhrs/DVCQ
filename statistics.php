<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/index.css">
    <link rel="stylesheet" href="./style/statistics.css">
    <title>DVC - QUESTÕES</title>
</head>

<body>
    <div style="background-color: white;">
        <?php require_once('./includes/navbar.php');?>
        <?php require_once('./includes/nav_menu.php');?>
    </div>
    <main id="root">
        <nav id="home-menu">
            <ul>
                <li><a href="./index.php">
                        <ion-icon name="rocket-outline"></ion-icon> Ambiente de estudos
                    </a></li>
                <li><a href="./books.php">
                        <ion-icon name="document-text-outline"></ion-icon> Cadernos e Simulados
                    </a></li>
                <li><a href="./statistics.php" class="active">
                        <ion-icon name="stats-chart-outline"></ion-icon> Meu Desempenho
                    </a></li>
            </ul>
            <nav id="stat_filter">
                <form class="horizontal-form">
                    <div>
                        <label for="periodo">Período:</label>
                        <select id="periodo" name="periodo">
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <!-- Adicione mais opções conforme necessário -->
                        </select>
                    </div>

                    <div>
                        <label for="disciplina">Disciplina:</label>
                        <select id="disciplina" name="disciplina">
                            <option value="matematica">Matemática</option>
                            <option value="portugues">Português</option>
                            <option value="historia">História</option>
                            <!-- Adicione mais opções conforme necessário -->
                        </select>
                    </div>

                    <div>
                        <label for="banca">Banca:</label>
                        <select id="banca" name="banca">
                            <option value="cespe">CESPE</option>
                            <option value="fcc">FCC</option>
                            <option value="vunesp">VUNESP</option>
                            <!-- Adicione mais opções conforme necessário -->
                        </select>
                    </div>

                    <div>
                        <label for="pasta">Pasta:</label>
                        <select id="pasta" name="pasta">
                            <option value="pasta1">Pasta 1</option>
                            <option value="pasta2">Pasta 2</option>
                            <option value="pasta3">Pasta 3</option>
                            <!-- Adicione mais opções conforme necessário -->
                        </select>
                    </div>

                    <div>
                        <label for="dificuldade">Dificuldade:</label>
                        <select id="dificuldade" name="dificuldade">
                            <option value="facil">Fácil</option>
                            <option value="media">Média</option>
                            <option value="dificil">Difícil</option>
                            <!-- Adicione mais opções conforme necessário -->
                        </select>
                    </div>

                    <button type="submit">Filtrar</button>
                </form>

            </nav>
            <main id="home-menu-root">
                <div id="stat_container">
                    <div class="card_container">
                        <h3>Desempenho Geral</h3>
                        <div class="grid3">
                            <div>
                                <h6>Questões Resolvidas: 12</h6>
                                <h6>Total de matériass: 12</h6>
                                <h6>Acertos: 12</h6>
                                <h6>Erros: 12</h6>
                            </div>
                            <div>grafico circular acertos/erros</div>
                            <div>grafico para mostrar desempenho em cada materia feita sla</div>
                        </div>
                    </div>
                    <div class="card_container">
                        <h3>Evolução do Desempenho</h3>
                        <div class="grid1">
                            <div>
                                grafico evolutivo mostrando evolução de erros e acertos ao decorrer do tempo
                            </div>
                        </div>
                    </div>
                    <div class="card_container">
                        <h3>Contabilizando disciplinas</h3>
                        <div class="grid3">
                            <div>
                                <h6>Questões Resolvidas: 12</h6>
                                <h6>Total de matériass: 12</h6>
                            </div>
                            <div>grafico circular de materias feitas</div>
                            <div>lista de todas as disciplinas e o total feito por voce em cada</div>
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