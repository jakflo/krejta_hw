// odpocitava cas do targetTime a kazdou minutu refreshne zbyvajici cas do div.countdown elementu
$(() => {
    const targetTime = (new Date('2025-09-11 14:20:10')).getTime() / 1000;
    const nowTime = (new Date()).getTime() / 1000;
    let timeLeft = targetTime - nowTime;
    const timeDom = $('div.countdown');
    
    const refreshTime = (timeLeft, timeDom) => {
        if (timeLeft <= 0) {
            $(timeDom).text('Už je to tady!');
            return;
        }
        
        const days = Math.floor(timeLeft / 86400);
        const hours = Math.floor(timeLeft % 86400 / 3600);
        const mins = Math.floor(timeLeft % 3600 / 60);
        $(timeDom).text(`${days} dní : ${hours} hodin : ${mins} minut`);        
    };
    
    refreshTime(timeLeft, timeDom);
    
    const timer = setInterval(() => {
        timeLeft -= 1;
        if (Math.floor(timeLeft % 60) === 59 || timeLeft <= 0) {
            refreshTime(timeLeft, timeDom);
        }
        if (timeLeft <= 0) {
            clearInterval(timer);
        }
    }, 1000);
    
});