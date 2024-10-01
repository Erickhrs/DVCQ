<?php
session_start();
include_once('./includes/functions.php');

$correct = total_user_cw($mysqli, $_SESSION['id'], '1'); // Total de acertos
$wrong = total_user_cw($mysqli, $_SESSION['id'], '0'); // Total de erros

// Obter contagem de matérias
$subjects = getUserDisciplinesCount($mysqli, $_SESSION['id']);

// Obter desempenho por matéria
$performance_data = get_performance_by_subject($mysqli, $_SESSION['id']);
$labels = [];
$correct_data = [];
$wrong_data = [];

// Mapeia o question_ID para o nome da matéria e acumula acertos e erros
foreach ($performance_data as $question_id => $performance) {
    // Utilize o índice como question_ID, pois está no array
    $subject_name = getSubjectName($mysqli, $question_id); // Altera para usar $question_id
    $labels[] = $subject_name; // Nome da matéria
    $correct_data[] = $performance['correct_count']; // Acertos por matéria
    $wrong_data[] = $performance['wrong_count']; // Erros por matéria
}

$question_type_counts = getUserQuestionTypeCount($mysqli, $_SESSION['id']);
$question_type_labels = ['tf', 'mult'];
$question_type_data = [$question_type_counts['tf'], $question_type_counts['mult']];

// Obter contagem de disciplinas por nível
$levels_count = getUserDisciplinesCountByLevel($mysqli, $_SESSION['id']);
$level_labels = array_keys($levels_count); // Níveis
$level_counts = array_values($levels_count); // Contagens

$bancasData = getUserDisciplinesCountByBanca($mysqli, $_SESSION['id']);
$banca_labels = [];
$banca_counts = [];

$jobFunctionsCount = getUserJobFunctionsCount($mysqli, $_SESSION['id']);
$jobFunction_labels = array_keys($jobFunctionsCount); // Funções de trabalho
$jobFunction_counts = array_values($jobFunctionsCount); // Contagens

$jobRolesCount = getUserJobRolesCount($mysqli, $_SESSION['id']);
$jobRole_labels = array_keys($jobRolesCount); // Funções de trabalho
$jobRole_counts = array_values($jobRolesCount); // Contagens

// Obter contagem de cursos
$coursesCount = getUserCoursesCount($mysqli, $_SESSION['id']);
$course_labels = array_keys($coursesCount);
$course_counts = array_values($coursesCount);

foreach ($bancasData as $banca) {
    $banca_labels[] = $banca['name']; // Altere 'name' para o nome correto da coluna que contém o nome da banca
    $banca_counts[] = $banca['count']; // Altere 'count' para o nome correto da coluna que contém a contagem
}
// Obter dados de evolução
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
        <?php require_once('./includes/navbar.php'); ?>
        <?php require_once('./includes/nav_menu.php'); ?>
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
        <div id="chart_infos">
            <span id="questions-per-day">
                <?php evaluateQuestionsPerDay($mysqli, $_SESSION['id']); ?>
            </span>
            <div>
                <span id="user-performance">
                    <?php evaluateUserPerformance($mysqli, $_SESSION['id']); ?>
                </span>
                <div style="display: flex;">
                    <span id="user-ranking">
                        <?php getUserRanking($mysqli, $_SESSION['id']); ?>
                    </span>

                    <span id="user-ranking-correct-answers">
                        <?php getUserRankingByCorrectAnswers($mysqli, $_SESSION['id']); ?>
                    </span>
                </div>
            </div>
        </div>
        <main id="home-menu-root">
            <div id="stat_container">
                <div class="card_container">
                    <h3 data-toggle="performance">Desempenho Geral</h3>
                    <div class="grid3" class="toggle-content">
                        <div>
                            <h6>Questões Resolvidas: <?php echo total_questions_answered($mysqli, $_SESSION['id']); ?>
                            </h6>
                            <h6>Total de matérias:</h6>
                            <h6 id="correct">Acertos: <?php echo $correct; ?></h6>
                            <h6 id="wrong">Erros: <?php echo $wrong; ?></h6>
                        </div>
                        <div>
                            <canvas id="total_cw_chart"></canvas>
                        </div>
                        <div><canvas id="subject_performance_chart"></canvas></div>
                    </div>
                </div>
                <div class="card_container">
                    <h3 data-toggle="disciplines">Contabilizando disciplinas</h3>
                    <div class="grid2 toggle-content">
                        <div>
                            <canvas id="disciplines_donut_chart" width="400" height="400"></canvas>
                        </div>
                        <div class="card_container">
                            <canvas id="question_type_chart" width="400" height="400"></canvas>
                        </div>
                        <div class="card_container">
                            <canvas id="level_chart" width="400" height="400"></canvas>
                        </div>
                        <div class="card_container">
                            <canvas id="banca_chart" width="400" height="400"></canvas>
                        </div>
                        <div class="card_container">
                            <canvas id="jobfunction_chart" width="400" height="400"></canvas>
                        </div>
                        <div class="card_container">
                            <canvas id="jobrole_chart" width="400" height="400"></canvas>
                        </div>
                        <div class="card_container">
                            <canvas id="course_chart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card_container">
                    <h3 data-toggle="evolution">Evolução do Desempenho</h3>
                    <div class="grid1 toggle-content">
                        <canvas id="evolution_chart" width="400" height="200"
                            style="max-width: 100%; height: auto;"></canvas>
                    </div>
                </div>
            </div>
        </main>

    </main>
    <?php include_once('./includes/footer.php'); ?>
</body>

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
                text: 'Desempenho por Assunto'
            }
        }
    }
});

const evolution_ctx = document.getElementById('evolution_chart').getContext('2d');
const evolutionChart = new Chart(evolution_ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [{
                label: 'Acertos',
                data: <?php echo json_encode($correct_counts); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.4)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
            },
            {
                label: 'Erros',
                data: <?php echo json_encode($wrong_counts); ?>,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.4)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
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

// Dados do gráfico de disciplinas
const subjects = <?php echo json_encode(array_keys($subjects)); ?>; // Nomes das matérias
const counts = <?php echo json_encode(array_values($subjects)); ?>; // Contagens

// Configuração do gráfico de donut
const ctx = document.getElementById('disciplines_donut_chart').getContext('2d');
const donutChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: subjects,
        datasets: [{
            label: 'Matérias',
            data: counts,
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)'
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
                text: 'Distribuição de Disciplinas'
            }
        }
    }
});
// Dados do gráfico de question type
const questionTypeLabels = <?php echo json_encode($question_type_labels); ?>; // Tipos de questão
const questionTypeCounts = <?php echo json_encode($question_type_data); ?>; // Contagens

// Configuração do gráfico de question type
const questionTypeCtx = document.getElementById('question_type_chart').getContext('2d');
const questionTypeChart = new Chart(questionTypeCtx, {
    type: 'bar',
    data: {
        labels: questionTypeLabels,
        datasets: [{
            label: 'Contagem de Tipos de Questão',
            data: questionTypeCounts,
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
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
                text: 'Distribuição de Tipos de Questão'
            }
        }
    }
});
// Dados do gráfico de níveis
const levelLabels = <?php echo json_encode($level_labels); ?>; // Níveis
const levelCounts = <?php echo json_encode($level_counts); ?>; // Contagens

// Configuração do gráfico de níveis
const levelCtx = document.getElementById('level_chart').getContext('2d');
const levelChart = new Chart(levelCtx, {
    type: 'bar', // Pode ser 'bar', 'line', etc. conforme sua preferência
    data: {
        labels: levelLabels,
        datasets: [{
            label: 'Contagem de Disciplinas por Nível',
            data: levelCounts,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
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
                text: 'Distribuição de Disciplinas por Nível'
            }
        }
    }
});
const banca_labels = <?php echo json_encode($banca_labels); ?>; // Rótulos das bancas
const banca_counts = <?php echo json_encode($banca_counts); ?>; // Contagens

const bancaCtx = document.getElementById('banca_chart').getContext('2d');
const bancaChart = new Chart(bancaCtx, {
    type: 'doughnut', // ou 'bar', dependendo do que você precisa
    data: {
        labels: banca_labels,
        datasets: [{
            label: 'Contagem por Banca',
            data: banca_counts,
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(153, 102, 255, 1)'
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
                text: 'Distribuição por Banca'
            }
        }
    }
});
// Gráfico de funções de trabalho
const jobfunction_ctx = document.getElementById('jobfunction_chart').getContext('2d');
const jobFunctionChart = new Chart(jobfunction_ctx, {
    type: 'bar', // ou 'pie', 'doughnut', etc.
    data: {
        labels: <?php echo json_encode($jobFunction_labels); ?>,
        datasets: [{
            label: 'Contagem de Funções de Trabalho',
            data: <?php echo json_encode($jobFunction_counts); ?>,
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
        }]
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
                text: 'Contagem de Funções de Trabalho'
            }
        }
    }
});
// Gráfico de Funções de Trabalho
const jobRoleCtx = document.getElementById('jobrole_chart').getContext('2d');
const jobRoleChart = new Chart(jobRoleCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($jobRole_labels); ?>,
        datasets: [{
            label: 'Contagem de Funções',
            data: <?php echo json_encode($jobRole_counts); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
            borderColor: 'rgba(75, 192, 192, 1)',
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
                text: 'Contagem de Funções de Trabalho'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfico de contagem de cursos
const courseCtx = document.getElementById('course_chart').getContext('2d');
const courseChart = new Chart(courseCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($course_labels); ?>,
        datasets: [{
            label: 'Contagem de Cursos',
            data: <?php echo json_encode($course_counts); ?>,
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
        }]
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
                text: 'Contagem de Cursos por Usuário'
            }
        }
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Seleciona todos os cabeçalhos h3
    const headers = document.querySelectorAll('h3[data-toggle]');

    headers.forEach(header => {
        header.addEventListener('click', function() {
            // Encontra o próximo elemento irmão que é o conteúdo a ser exibido
            const content = header.nextElementSibling;

            // Alterna a visibilidade do conteúdo
            if (content.style.display === "none" || content.style.display === "") {
                content.style.display = "block"; // Exibe o conteúdo
            } else {
                content.style.display = "none"; // Oculta o conteúdo
            }
        });
    });
});
</script>

</html>