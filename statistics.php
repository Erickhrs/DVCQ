<?php
session_start();
include_once('./includes/functions.php');
$correct = total_user_cw($mysqli, $_SESSION['id'], '1'); // Total de acertos
$wrong = total_user_cw($mysqli, $_SESSION['id'], '0'); // Total de erros

$performance_data = get_performance_by_subject($mysqli, $_SESSION['id']);
$labels = [];
$correct_data = [];
$wrong_data = [];

foreach ($performance_data as $performance) {
    $labels[] = 'Matéria ' . $performance['question_ID']; // Aqui você pode mapear o question_ID para o nome da matéria, se necessário
    $correct_data[] = $performance['correct_count'];
    $wrong_data[] = $performance['wrong_count'];
}
list($dates, $correct_counts, $wrong_counts) = get_evolution_data($mysqli, $_SESSION['id']);
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        </nav>
        <nav id="stat_filter" style="display: none;">
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
                            <h6>Questões Resolvidas: <?php echo total_questions_answered($mysqli, $_SESSION['id'])?>
                            </h6>
                            <h6>Total de matérias: <?php echo total_subjects($mysqli, $_SESSION['id'])?></h6>
                            <h6 id="correct">Acertos: <?php echo total_user_cw($mysqli, $_SESSION['id'], '1')?></h6>
                            <h6 id="wrong">Erros: <?php echo total_user_cw($mysqli, $_SESSION['id'], '0')?></h6>
                        </div>
                        <div>
                            <canvas id="total_cw_chart"></canvas>
                        </div>
                        <div><canvas id="subject_performance_chart"></canvas></div>
                    </div>
                </div>
                <div class="card_container">
                    <h3>Contabilizando disciplinas</h3>
                    <div class="grid2">
                        <div>grafico circular de materias feitas</div>
                        <div>lista de todas as disciplinas e o total feito por voce em cada</div>
                    </div>
                </div>
                <div class="card_container">
                    <h3>Evolução do Desempenho</h3>
                    <div class="grid1">
                        <canvas id="evolution_chart" width="400" height="200"
                            style="max-width: 100%; height: auto;"></canvas>
                    </div>
                </div>

            </div>

        </main>
    </main>
</body><?php include_once('./includes/footer.php')?>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
<script src="./scripts/spa.js" type="module"></script>
<script src="./scripts/global.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./scripts/protect.js"></script>
<script>
const total_cw_ctx = document.getElementById('total_cw_chart').getContext('2d');
const myPieChart = new Chart(total_cw_ctx, {
    type: 'pie',
    data: {
        labels: ['Acertos', 'Erros'],
        datasets: [{
            label: 'Desempenho',
            data: [<?php echo $correct; ?>, <?php echo $wrong; ?>],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Sua Relação de Acertos e Erros'
            }
        }
    }
});

const subjectCtx = document.getElementById('subject_performance_chart').getContext('2d');
const subjectChart = new Chart(subjectCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
                label: 'Acertos',
                data: <?php echo json_encode($correct_data); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Erros',
                data: <?php echo json_encode($wrong_data); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Desempenho por Matéria'
            }
        }
    }
});

const evolution_ctx = document.getElementById('evolution_chart').getContext('2d');
const evolutionChart = new Chart(evolution_ctx, {
    type: 'line', // Gráfico de linha
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [{
                label: 'Acertos',
                data: <?php echo json_encode($correct_counts); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.4)', // Área preenchida
                fill: true, // Preencher a área sob a linha
                tension: 0.4, // Suaviza a linha
                borderWidth: 2, // Espessura da linha
            },
            {
                label: 'Erros',
                data: <?php echo json_encode($wrong_counts); ?>,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.4)', // Área preenchida
                fill: true, // Preencher a área sob a linha
                tension: 0.4, // Suaviza a linha
                borderWidth: 2, // Espessura da linha
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Evolução de Acertos e Erros ao Longo do Tempo'
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Datas'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Contagem'
                },
                beginAtZero: true
            }
        }
    }
});
</script>
</body>

</html>