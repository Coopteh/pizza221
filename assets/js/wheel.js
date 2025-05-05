// Ждем полной загрузки DOM
document.addEventListener('DOMContentLoaded', function() {
  // Проверяем существование всех элементов
  const showWheelBtn = document.getElementById('show-wheel');
  const wheelContainer = document.getElementById('wheel-container');
  const wheel = document.getElementById('wheel');
  const spinBtn = document.getElementById('spin-btn');
  const resultDiv = document.getElementById('result');
  
  if (!showWheelBtn || !wheelContainer || !wheel || !spinBtn || !resultDiv) {
      console.error('Один из необходимых элементов не найден!');
      return;
  }

  // Настройки колеса
  const segments = ["10% скидки", "5% скидки", "Бесплатная доставка", "Повезёт в следующий раз", "20% скидки"];
  const colors = ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"];
  const ctx = wheel.getContext('2d');

  // Показываем колесо при клике
  showWheelBtn.addEventListener('click', function() {
      wheelContainer.style.display = 'block';
      drawWheel();
  });

  // Рисуем колесо
  function drawWheel() {
      const segmentAngle = (2 * Math.PI) / segments.length;
      
      segments.forEach((segment, index) => {
          ctx.beginPath();
          ctx.arc(200, 200, 200, index * segmentAngle, (index + 1) * segmentAngle);
          ctx.lineTo(200, 200);
          ctx.fillStyle = colors[index];
          ctx.fill();
          
          // Текст
          ctx.save();
          ctx.translate(200, 200);
          ctx.rotate(index * segmentAngle + segmentAngle / 2);
          ctx.fillStyle = "white";
          ctx.font = "16px Arial";
          ctx.fillText(segment, 100, 10);
          ctx.restore();
      });
  }

  // Крутим колесо
  spinBtn.addEventListener('click', function() {
      spinBtn.disabled = true;
      const spins = 5 + Math.random() * 5; // 5-10 оборотов
      let startAngle = 0;
      const endAngle = startAngle + spins * Math.PI * 2;
      const segmentAngle = (2 * Math.PI) / segments.length;
      
      const spinInterval = setInterval(() => {
          startAngle += 0.1;
          ctx.clearRect(0, 0, 400, 400);
          ctx.save();
          ctx.translate(200, 200);
          ctx.rotate(startAngle);
          ctx.translate(-200, -200);
          drawWheel();
          ctx.restore();
          
          if (startAngle >= endAngle) {
              clearInterval(spinInterval);
              const winningSegment = Math.floor(((2 * Math.PI) - (startAngle % (2 * Math.PI))) / segmentAngle);
              resultDiv.innerHTML = `Вы выиграли: <strong>${segments[winningSegment]}</strong>`;
              
              // Сохраняем скидку
              localStorage.setItem('discount', segments[winningSegment]);
              
              // Отправляем на сервер
              fetch('/avtoservis/apply_discount', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({ discount: segments[winningSegment] })
              })
              .then(response => response.json())
              .then(data => console.log('Скидка сохранена:', data))
              .catch(error => console.error('Ошибка:', error));
              
              spinBtn.disabled = false;
          }
      }, 20);
  });
});