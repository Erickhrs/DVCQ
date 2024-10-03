<?php
session_start();
include_once('./includes/functions.php');
include_once('./includes/loading.php');

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
    <?php include('./includes/wpp_btn.php');?>
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
            <div id="charts_view">
                <h3 data-toggle="cstr1">
                    <ion-icon name="pie-chart-outline"></ion-icon> Desempenho Geral
                </h3>
                <h3 data-toggle="cstr2">
                    <ion-icon name="stats-chart-outline"></ion-icon> Contabilizando disciplinas
                </h3>
                <h3 data-toggle="cstr3">
                    <ion-icon name="bar-chart-outline"></ion-icon> Evolução do Desempenho
                </h3>
            </div>
            <div id="stat_container">
                <div class="card_container">

                    <div class="grid3" class="toggle-content" id="cstr1">
                        <div style="display: block;">
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

                    <div class="grid3" id="cstr2">
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

                    <div class="grid1 toggle-content" id="cstr3">
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
                'rgba(173, 216, 230, 0.6)', // Azul claro para acertos
                'rgba(255, 182, 193, 0.6)' // Rosa claro para erros
            ],
            borderColor: [
                'rgba(173, 216, 230, 1)',
                'rgba(255, 182, 193, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: 'white' // Cor branca para as legendas
                }
            },
            title: {
                display: true,
                text: 'Sua Relação de Acertos e Erros',
                color: 'white' // Cor branca para o título
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
                backgroundColor: 'rgba(173, 216, 230, 0.6)', // Azul claro
                borderColor: 'rgba(173, 216, 230, 1)',
                borderWidth: 1
            },
            {
                label: 'Erros',
                data: <?php echo json_encode($wrong_data); ?>,
                backgroundColor: 'rgba(255, 182, 193, 0.6)', // Rosa claro
                borderColor: 'rgba(255, 182, 193, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white' // Cor branca para os valores do eixo Y
                }
            },
            x: {
                ticks: {
                    color: 'white' // Cor branca para os rótulos do eixo X
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: 'white' // Cor branca para as legendas
                }
            },
            title: {
                display: true,
                text: 'Desempenho por Assunto',
                color: 'white' // Cor branca para o título
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
                'rgba(173, 216, 230, 0.7)', // Azul claro
                'rgba(255, 182, 193, 0.7)', // Rosa claro
                'rgba(255, 228, 181, 0.7)', // Bege claro
                'rgba(144, 238, 144, 0.7)', // Verde claro
                'rgba(255, 239, 213, 0.7)' // Branco baunilha claro
            ],
            borderColor: [
                'rgba(173, 216, 230, 1)',
                'rgba(255, 182, 193, 1)',
                'rgba(255, 228, 181, 1)',
                'rgba(144, 238, 144, 1)',
                'rgba(255, 239, 213, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                color: 'white',
            },
            title: {
                display: true,
                text: 'Distribuição de Disciplinas',
                color: 'white',
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
                'rgba(144, 238, 144, 0.7)', // Verde claro
                'rgba(255, 228, 181, 0.7)' // Bege claro
            ],
            borderColor: [
                'rgba(144, 238, 144, 1)',
                'rgba(255, 228, 181, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white' // Texto claro
                }
            },
            x: {
                ticks: {
                    color: 'white' // Texto claro
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: 'white' // Texto claro
                }
            },
            title: {
                display: true,
                text: 'Distribuição de Tipos de Questão',
                color: 'white' // Texto claro
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
            backgroundColor: 'rgba(255, 239, 213, 0.7)', // Branco baunilha claro
            borderColor: 'rgba(255, 239, 213, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white' // Texto claro
                }
            },
            x: {
                ticks: {
                    color: 'white' // Texto claro
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: 'white' // Texto claro
                }
            },
            title: {
                display: true,
                text: 'Distribuição de Disciplinas por Nível',
                color: 'white' // Texto claro
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
                'rgba(144, 238, 144, 0.7)', // Verde claro
                'rgba(255, 182, 193, 0.7)', // Rosa claro
                'rgba(173, 216, 230, 0.7)', // Azul claro
                'rgba(255, 239, 213, 0.7)', // Branco baunilha claro
                'rgba(255, 228, 181, 0.7)' // Bege claro
            ],
            borderColor: [
                'rgba(144, 238, 144, 1)',
                'rgba(255, 182, 193, 1)',
                'rgba(173, 216, 230, 1)',
                'rgba(255, 239, 213, 1)',
                'rgba(255, 228, 181, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: 'white' // Texto claro
                }
            },
            title: {
                display: true,
                text: 'Distribuição por Banca',
                color: 'white' // Texto claro
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
            backgroundColor: 'rgba(173, 216, 230, 0.7)', // Azul claro
            borderColor: 'rgba(173, 216, 230, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white' // Texto claro
                }
            },
            x: {
                ticks: {
                    color: 'white' // Texto claro
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: 'white' // Texto claro
                }
            },
            title: {
                display: true,
                text: 'Contagem de Funções de Trabalho',
                color: 'white' // Texto claro
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
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white' // Texto claro
                }
            },
            x: {
                ticks: {
                    color: 'white' // Texto claro
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: 'white' // Texto claro
                }
            },
            title: {
                display: true,
                text: 'Contagem de Funções de Trabalho',
                color: 'white' // Texto claro
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
            backgroundColor: 'rgba(173, 216, 230, 0.7)', // Azul claro
            borderColor: 'rgba(173, 216, 230, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white' // Texto claro
                }
            },
            x: {
                ticks: {
                    color: 'white' // Texto claro
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: 'white' // Texto claro
                }
            },
            title: {
                display: true,
                text: 'Contagem de Cursos',
                color: 'white' // Texto claro
            }
        }
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Seleciona todos os cabeçalhos h3
    const headers = document.querySelectorAll('h3[data-toggle]');

    headers.forEach(header => {
        header.addEventListener('click', function() {
            // Obtém o valor do data-toggle
            const toggleData = header.getAttribute('data-toggle');

            // Encontra o elemento com o id correspondente
            const content = document.getElementById(toggleData);

            // Alterna a visibilidade do conteúdo
            if (content.style.display === "none" || content.style.display === "") {
                content.style.display = "grid"; // Exibe o conteúdo
            } else {
                content.style.display = "none"; // Oculta o conteúdo
            }
        });
    });
});
</script>

</html>