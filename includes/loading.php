<?php
echo '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Spinner</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            background-image: linear-gradient(-105deg, #009acc, #363795);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index:999;
        }

        .spinner {
            animation: rotate 2s linear infinite;
            z-index: 2;
            width: 50px;
            height: 50px;
        }

        .spinner .path {
            stroke: hsl(210, 70, 75);
            stroke-linecap: round;
            animation: dash 1.5s ease-in-out infinite;
            fill: none;
            stroke-width: 5;
        }

        @keyframes rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes dash {
            0% {
                stroke-dasharray: 1, 150;
                stroke-dashoffset: 0;
            }
            50% {
                stroke-dasharray: 90, 150;
                stroke-dashoffset: -35;
            }
            100% {
                stroke-dasharray: 90, 150;
                stroke-dashoffset: -124;
            }
        }
    </style>
</head>
<body>
    <svg class="spinner" viewBox="0 0 50 50">
        <circle class="path" cx="25" cy="25" r="20"></circle>
    </svg>

   
</body>
</html>
';
?>