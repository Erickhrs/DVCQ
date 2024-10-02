<?php
echo '
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
/* Estilos do botão */
.whatsapp-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #25D366;
    color: white;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s ease;
    z-index: 1000;
    text-decoration: none; /* Remove underline */
}

/* Efeito hover */
.whatsapp-button:hover {
    background-color: #22bb5c;
}

/* Remove underline do link e ícone */
.whatsapp-button i, 
.whatsapp-button {
    text-decoration: none;
}

/* Ícone dentro do botão */
.whatsapp-button i {
    font-size: 30px;
}
</style>

<a href="https://wa.me/SEU_NUMERO_DE_TELEFONE" target="_blank" class="whatsapp-button">
    <i class="bx bxl-whatsapp"></i>
</a>
';
?>