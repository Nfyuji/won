const timeElement = document.querySelector('.time');
const countdownDate = new Date('2025-02-20T00:00:00').getTime();

setInterval(() => {
    const now = new Date().getTime();
    const distance = countdownDate - now;

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    timeElement.textContent = `${days} يوم ${hours} ساعة ${minutes} دقيقة ${seconds} ثانية`;

    if (distance < 0) {
        timeElement.textContent = "انتهى الوقت!";
    }
}, 1000);
