function creditsTimer(id, deadline) {
    let countDownDate = new Date(deadline);
    countDownDate.setHours(countDownDate.getHours() + 2);
    countDownDate = countDownDate.getTime(); // Convert to timestamp
    const creditTimer = document.querySelector(id);

    const timer = setInterval(function() {

        // Get today's date and time
        const now = new Date().getTime();
        const difference = countDownDate - now;

        // Ensure the deadline has not passed
        if (difference <= 0) {
            clearInterval(timer);
            creditTimer.querySelector('#hour').textContent = '00';
            creditTimer.querySelector('#minutes').textContent = '00';
            creditTimer.querySelector('#seconds').textContent = '00';
            return;
        }

        // Time calculations for days, hours, minutes and seconds
        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

        creditTimer.querySelector('#hour').textContent = hours.toString().padStart(2, '0');
        creditTimer.querySelector('#minutes').textContent = minutes.toString().padStart(2, '0');
        creditTimer.querySelector('#seconds').textContent = seconds.toString().padStart(2, '0');

        console.log('timer is working');
    }, 1000);

}

export default creditsTimer;