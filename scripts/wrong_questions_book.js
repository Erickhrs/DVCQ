let seconds = 0, minutes = 0, hours = 0;
let timer;
let isRunning = false;
let isGreen = false;


function updateTimer() {
  seconds++;
  if (seconds === 60) {
    seconds = 0;
    minutes++;
  }
  if (minutes === 60) {
    minutes = 0;
    hours++;
  }

  document.getElementById("cronometro").textContent =
    (hours < 10 ? "0" + hours : hours) + ":" +
    (minutes < 10 ? "0" + minutes : minutes) + ":" +
    (seconds < 10 ? "0" + seconds : seconds);
}

function startTimer() {
  if (!isRunning) {
    timer = setInterval(updateTimer, 1000);
    isRunning = true;
  }
}

function pauseTimer() {
  clearInterval(timer);
  isRunning = false;
}

window.onload = function() {
  startTimer(); // Inicia o cronômetro automaticamente ao carregar a página
}

function toggleColor() {
  const cronometro = document.getElementById('cronometro');
  
  if (isGreen) {
    cronometro.style.color = 'black'; // Muda para preto
  } else {
    cronometro.style.color = 'var(--green-todbg)'; // Muda para o verde (ou qualquer valor da variável)
  }
  
  isGreen = !isGreen; // Alterna o estado da cor
}

document.getElementById('finish').addEventListener('click', function() {
  // Obtém o ID do usuário do span
  const userId = $('#userId').text().trim();

  // Obtém o valor atual do cronômetro
  const cronometroValue = $('#cronometro').text().trim();

  // Calcula o total de respostas
  const totalAnswered = corrects + wrongs;

  // Cria o objeto com os dados de respostas, o ID do usuário e o valor do cronômetro
  const resultObject = {
      totalRespondidos: totalAnswered,
      corretos: corrects,
      errados: wrongs,
      userId: userId, // Inclui o ID do usuário no objeto
      time: cronometroValue // Inclui o valor do cronômetro no objeto
  };

  // Exibe o objeto no console (ou pode ser utilizado para outros fins)
  console.log(resultObject);

  // Atualiza os spans com os valores finais, se necessário
  $('#corrects').text(corrects);
  $('#wrongs').text(wrongs);

  // Aqui você pode fazer outras operações com o objeto, como enviar via AJAX, etc.
});

