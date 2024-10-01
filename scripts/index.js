function scrollToLeft() {
    document.querySelector('.carousel').scrollBy({
        left: -300,
        behavior: 'smooth'
    });
}

function scrollRight() {
    document.querySelector('.carousel').scrollBy({
        left: 300,
        behavior: 'smooth'
    });
}

function scrollToLeftv() {
    document.getElementById('videoCarousel').scrollBy({
        left: -300,
        behavior: 'smooth'
    });
}

function scrollRightv() {
    document.getElementById('videoCarousel').scrollBy({
        left: 300,
        behavior: 'smooth'
    });
}
const frasesMotivacionais = [
    "O único lugar onde o sucesso vem antes do trabalho é no dicionário.",
    "A educação é o passaporte para o futuro, pois o amanhã pertence àqueles que se preparam hoje.",
    "Estude agora e brilhe depois.",
    "A dedicação de hoje é o sucesso de amanhã.",
    "O esforço de hoje constrói o conhecimento de amanhã.",
    "A cada página lida, você está mais perto de seus sonhos.",
    "A persistência transforma sonhos em conquistas.",
    "Seu futuro depende do que você faz hoje.",
    "A chave do sucesso está na sua força de vontade.",
    "Não há elevador para o sucesso, você tem que subir as escadas.",
    "O sucesso é resultado de preparação, trabalho duro e aprender com os erros.",
    "A dor que você sente hoje é a força que você terá amanhã.",
    "Estudar é abrir portas para novas oportunidades.",
    "O conhecimento é o único tesouro que ninguém pode tirar de você.",
    "A vitória pertence aos que persistem.",
    "Sucesso é a soma de pequenos esforços repetidos diariamente.",
    "Cada desafio superado te deixa mais forte e preparado.",
    "Não espere pelo momento perfeito, faça o momento perfeito.",
    "Estudar pode ser cansativo, mas desistir não leva a lugar algum.",
    "O que parece difícil hoje, se tornará sua conquista amanhã.",
    "Para alcançar algo que você nunca teve, precisa fazer algo que nunca fez.",
    "O estudo é o único caminho que te leva onde você quer chegar.",
    "Foco, força e fé nos seus estudos te levarão longe.",
    "Não existe mágica, existe trabalho duro e dedicação.",
    "Estudar nunca é tempo perdido. É um investimento no seu futuro.",
    "Não se compare com os outros, apenas com o seu progresso diário.",
    "Pequenas vitórias diárias geram grandes resultados.",
    "Nunca subestime o poder de uma mente dedicada.",
    "Quem acredita, estuda. Quem estuda, conquista.",
    "Seu sucesso depende daquilo que você faz repetidamente.",
    "Acredite em si mesmo e todo o resto se encaixará.",
    "O sucesso é a soma de pequenos esforços repetidos dia após dia.",
    "A persistência é o caminho do êxito.",
    "Não importa o quão devagar você vá, desde que não pare.",
    "Grandes coisas nunca vêm de zonas de conforto.",
    "O segredo para avançar é começar.",
    "Você é mais forte do que imagina.",
    "O único limite para o seu sucesso é a sua mente.",
    "Acredite que você pode, e você já está no meio do caminho.",
    "A vida é 10% o que acontece com você e 90% como você reage.",
    "O fracasso é a oportunidade de começar de novo com mais inteligência.",
    "Seja a mudança que você quer ver no mundo.",
    "Tudo o que você sempre quis está do outro lado do medo.",
    "O sucesso não é definitivo, o fracasso não é fatal: o que conta é a coragem de continuar.",
    "Você não pode mudar o vento, mas pode ajustar as velas.",
    "A melhor maneira de prever o futuro é criá-lo.",
    "Dificuldades preparam pessoas comuns para destinos extraordinários.",
    "A jornada de mil milhas começa com um único passo.",
    "A ação é a chave fundamental para todo sucesso.",
    "Você nunca é velho demais para definir outro objetivo ou sonhar um novo sonho.",
    "Faça de cada obstáculo um degrau para a sua vitória.",
    "Sonhe grande, comece pequeno, mas, acima de tudo, comece.",
    "Você não precisa ser perfeito para começar, mas precisa começar para ser perfeito.",
    "Sua única limitação é aquela que você impõe a si mesmo.",
    "Seja mais forte que sua maior desculpa.",
    "Você nunca sabe que resultados virão da sua ação, mas se você não fizer nada, não haverá resultados.",
    "A disciplina é a ponte entre metas e conquistas.",
    "Todo esforço tem sua recompensa.",
    "Não espere por oportunidades, crie-as.",
    "Você é o único responsável pelo seu sucesso."
];

document.getElementById('motivacional').innerHTML =  frasesMotivacionais[Math.floor(Math.random() * 30)];

  // Supondo que você tenha o nome do usuário armazenado em uma variável PHP
  const userName = "<?php echo htmlspecialchars($_SESSION['name'], ENT_QUOTES); ?>"; // Escapa o nome do usuário para evitar problemas

  // Obtém a hora atual
  const currentHour = new Date().getHours();

  // Define a saudação com base na hora
  let greeting;
  if (currentHour >= 5 && currentHour < 12) {
      greeting = "Bom dia";
  } else if (currentHour >= 12 && currentHour < 18) {
      greeting = "Boa tarde";
  } else {
      greeting = "Boa noite";
  }

  // Seleciona o elemento e define seu conteúdo
  document.getElementById("user_name").innerText = `${greeting}, ${userName}!`;

  const videoList = document.getElementById('videoList');
  const prevButton = document.getElementById('prevButton');
  const nextButton = document.getElementById('nextButton');

  prevButton.addEventListener('click', () => {
      videoList.scrollBy({ left: -300, behavior: 'smooth' });
  });

  nextButton.addEventListener('click', () => {
      videoList.scrollBy({ left: 300, behavior: 'smooth' });
  });