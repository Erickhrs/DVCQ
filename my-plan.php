<?php
session_start();
// Supondo que os valores da sessão sejam 0, 1 ou 2
$current_plan = $_SESSION['plan'];
?>

<link rel="stylesheet" href="./style/my-plan.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<h1>Escolha o plano ideal para você</h1>
<p>
    Aumente seu rendimento com ferramentas de estudo eficientes e preços acessíveis.
</p>

<div class="pricing">
    <div class="plan <?php echo $current_plan == '0' ? 'current' : ''; ?>">
        <h2>Grátis</h2>
        <div class="price">Grátis</div>
        <ul class="features">
            <li><i class='bx bx-check-circle'></i> 10 questões por dia:<br> Pratique diariamente com um limite saudável.
            </li>
            <li><i class='bx bx-check-circle'></i> Estatísticas Básicas:<br> Monitore seu progresso e entenda onde
                melhorar.</li>
        </ul>
        <?php if ($current_plan === '0'): ?>
        <span>Plano Atual</span>
        <?php endif; ?>
        <?php if ($current_plan !== '0'): ?>
        <button>Assinar Grátis</button>
        <?php endif; ?>
    </div>

    <div class="plan <?php echo $current_plan == '1' ? 'current' : ''; ?>">
        <h2>Padrão</h2>
        <div class="price">R$ 24,90/mês</div>
        <ul class="features">
            <li><i class='bx bx-check-circle'></i> Questões de Bancas 100% Comentadas:<br> Entenda cada resposta com
                explicações detalhadas.</li>
            <li><i class='bx bx-check-circle'></i> Caderno de Erros:<br> Acompanhe e corrija seus pontos fracos de forma
                contínua.</li>
            <li><i class='bx bx-check-circle'></i> Simulado Padrão:<br> Teste seus conhecimentos em um ambiente
                simulado.</li>
            <li><i class='bx bx-check-circle'></i> Estatísticas Padrão:<br> Receba análises detalhadas do seu
                desempenho.</li>
        </ul>
        <?php if ($current_plan === '1'): ?>
        <span>Plano Atual</span>
        <?php endif; ?>
        <?php if ($current_plan !== '1'): ?>
        <div class="footer_container">
            <button>Assinar Agora</button>
            <p><small>Ou R$ 19,90/mês no plano anual (18% de desconto)</small></p>
        </div>
        <?php endif; ?>
    </div>

    <div class="plan <?php echo $current_plan == '2' ? 'current' : ''; ?>">
        <h2>Avançado</h2>
        <div class="price">R$ 34,90/mês</div>
        <ul class="features">
            <li><i class='bx bx-check-circle'></i> Questões de Bancas 100% Comentadas:<br> Entenda cada resposta com
                explicações detalhadas.</li>
            <li><i class='bx bx-check-circle'></i> Questões Inéditas 100% Comentadas:<br> Desafie-se com questões
                exclusivas.</li>
            <li><i class='bx bx-check-circle'></i> Questões Ilimitadas:<br> Pratique o quanto quiser.</li>
            <li><i class='bx bx-check-circle'></i> Método ARQ Exclusivo:<br> Estudo focado em tópicos relevantes.</li>
            <li><i class='bx bx-check-circle'></i> Caderno de Erros:<br> Acompanhe e corrija seus pontos fracos de forma
                contínua.</li>
            <li><i class='bx bx-check-circle'></i> Simulado Padrão:<br> Testes regulares para verificar sua prontidão.
            </li>
            <li><i class='bx bx-check-circle'></i> Estatísticas Avançadas:<br> Insights detalhados para otimizar seu
                estudo.</li>
            <li><i class='bx bx-check-circle'></i> Suporte Tira-dúvidas:<br> Atendimento personalizado com Professor via
                WhatsApp.</li>
        </ul>
        <?php if ($current_plan === '2'): ?>
        <span>Plano Atual</span>
        <?php endif; ?>
        <?php if ($current_plan !== '2'): ?>
        <div class="footer_container">
            <button>Assinar Agora</button>
            <p><small>Ou R$ 29,90/mês no plano anual (16% de desconto)</small></p>
        </div>
        <?php endif; ?>
    </div>
</div>