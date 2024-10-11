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
  const finishedTime = $('#cronometro').text().trim();

  const book = $('#book_title').text().trim();
  
  // Supondo que as variáveis 'corrects' e 'wrongs' já estão definidas no seu código
  const corrects = parseInt($('#corrects').text().trim()) || 0; // Exemplo de como obter as respostas corretas
  const wrongs = parseInt($('#wrongs').text().trim()) || 0;     // Exemplo de como obter as respostas erradas

  // Calcula o total de respostas
  const totalAnswered = corrects + wrongs;

  // Validação para verificar se o total de respostas é 0
  if (totalAnswered === 0) {
      // Exibe o alerta pedindo para o usuário responder algo
      Swal.fire({
          title: 'Atenção!',
          text: 'Você precisa responder pelo menos uma pergunta antes de finalizar.',
          icon: 'warning',
          confirmButtonText: 'OK'
      });
      return; // Impede que o código continue se não houver respostas
  }

  // Cria o objeto com os dados de respostas, o ID do usuário e o valor do cronômetro
  const resultObject = {
      book: book,
      totalAnswered: totalAnswered,
      corrects: corrects,
      wrongs: wrongs,
      userId: userId, // Inclui o ID do usuário no objeto
      finishedTime: finishedTime // Inclui o valor do cronômetro no objeto
  };

  // Adiciona um console.log para exibir o objeto que será enviado ao backend
  console.log('Dados enviados:', resultObject);

  // Envia os dados via AJAX
  $.ajax({
    url: './actions/save_results.php', // Arquivo que processa a inserção no banco
    type: 'POST',
    data: resultObject,
    success: function(response) {
        // Exibir o alerta ao usuário quando finalizar
        Swal.fire({
            title: 'Simulado Finalizado!',
            text: 'Seu caderno de erros foi salvo com sucesso.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
              //  console.log('Resposta da API:', response);
             //   console.log(resultObject);
                window.location.href = 'books_results.php'; 
            }
        });
    },
    error: function(error) {
        console.error('Erro ao salvar os resultados: ', error);
    }
  });
});



  // Atualiza os spans com os valores finais, se necessário
  $('#corrects').text(corrects);
  $('#wrongs').text(wrongs);

  // Aqui você pode fazer outras operações com o objeto, como enviar via AJAX, etc.


