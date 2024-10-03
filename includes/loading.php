<?php
echo '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página com Loading</title>
    <style>
        :root {
            --main-color: #648e4a;
            --logo-blue: #1d3969;
            --logo-green: #007700;
            --light-green: #6aac41;
            --green-todbg: #b3e295;
        }

        /* Estilos do corpo */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Estilos da tela de loading */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--light-green), var(--green-todbg)); /* Gradiente de fundo */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Mantém a tela de loading acima de outros elementos */
            backdrop-filter: blur(10px); /* Efeito de desfoque no fundo */
            animation: fadeIn 0.5s; /* Animação de aparecimento */
        }

        /* Estilo da logo com efeito de pulsação */
        .logo {
            width: 150px; /* Largura da logo */
            height: auto; /* Altura automática */
            margin-bottom: 20px; /* Espaçamento abaixo da logo */
            animation: pulse 1.4s infinite; /* Animação de pulsação */
        }

        /* Animação de pulsação */
       @keyframes pulse {
    0%, 100% {
        transform: scale(1); /* Tamanho inicial normal */
        opacity: 0.5; /* Opacidade inicial (mais visível) */
    }
    50% {
        transform: scale(2); /* Aumenta o tamanho significativamente */
        opacity: 1; /* Aumenta a opacidade */
    }
}

        /* Animação de fade in */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        /* Estilo da frase */
        .loading-text {
            font-size: 24px; /* Tamanho da fonte */
            font-weight: bold; /* Negrito */
            text-align: center; /* Centraliza o texto */
            color: var(--logo-blue); /* Cor do texto */
            margin-top: 15px; /* Espaçamento acima do texto */
            line-height: 1.5; /* Altura da linha */
        }

        /* Conteúdo da página */
        #content {
            display: none; /* Conteúdo inicialmente escondido */
            padding: 20px; /* Espaçamento do conteúdo */
        }
    </style>
</head>
<body>
    <!-- Tela de loading -->
    <div id="loading" class="loading">
        <img src="./assets/logo.png" alt="Logo" class="logo">
       <!-- <p class="loading-text">Estamos preparando tudo para você!</p>-->
    </div>

    <script>
        // Esconder a tela de loading quando a página estiver completamente carregada
        window.addEventListener("load", function() {
           document.getElementById("loading").style.display = "none"; // Esconde a tela de loading
        });
    </script>
</body>
</html>
';
?>