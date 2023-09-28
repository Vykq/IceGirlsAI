function timer(id, deadline) {

    function getTimeRemaining(endtime) {
        let t = Date.parse(endtime) - Date.parse(new Date()),
            days = Math.floor(t / (1000 * 60 * 60 * 24)),
            hours = Math.floor((t / (1000 * 60 * 60)) % 24),
            minutes = Math.floor((t / (1000 * 60)) % 60),
            seconds = Math.floor((t / 1000) % 60);

        return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
        };
    }

    function getZero(num) {
        return num.toString().padStart(2, '0');
    }

    function setClock(selector, endtime) {
        const timer = document.querySelector(selector);
        const timeInterval = setInterval(updateClocks, 1000);

        updateClocks();

        function updateClocks() {
            const t = getTimeRemaining(endtime),
                dayTitle = timer.querySelector('#day-title'),
                hourTitle = timer.querySelector('#hour-title'),
                minutesTitle = timer.querySelector('#minutes-title'),
                secondsTitle = timer.querySelector('#seconds-title');

            if (t.days === "1") {
                dayTitle.innerHTML = 'Day';
            } else  {
                dayTitle.innerHTML = 'Days';
            }

            if (t.hours === "1") {
                hourTitle.innerHTML = 'Hour';
            } else {
                hourTitle.innerHTML = 'Hours';
            }

            if (t.minutes === "1") {
                minutesTitle.innerHTML = 'Minute';
            } else {
                minutesTitle.innerHTML = 'Minutes';
            }

            if (t.seconds === "1") {
                secondsTitle.innerHTML = 'Second';
            } else {
                secondsTitle.innerHTML = 'Seconds';
            }

            function firstDigit(num) {
                // 1: convert absolute form to string and get length of integer
                const len = String(Math.abs(num)).length;
                const divisor = 10 ** (len - 1);
                // 2: get integer part from result of division
                return Math.trunc(num / divisor);
            }

            function lastDigit(num) {
                // 1: get the remainder after dividing by 10
                const lastDigit = Math.abs(num) % 10;
                return lastDigit;
            }

            const daysLeft = timer.querySelector('.left.cell.days .number');
            const daysRight = timer.querySelector('.right.cell.days .number');
            const hoursLeft = timer.querySelector('.left.cell.hours .number');
            const hoursRight = timer.querySelector('.right.cell.hours .number');
            const minutesLeft = timer.querySelector('.left.cell.minutes .number');
            const minutesRight = timer.querySelector('.right.cell.minutes .number');
            const secondsLeft = timer.querySelector('.left.cell.seconds .number');
            const secondsRight = timer.querySelector('.right.cell.seconds .number');

            if(t.days < 10) {
                daysLeft.textContent = 0;
                daysRight.textContent = t.days;
            } else {
                const leftDigit = firstDigit(t.days);
                daysLeft.textContent = leftDigit;
                const rightDigit = lastDigit(t.days);
                daysRight.textContent = rightDigit;
            }

            if(t.hours < 10) {
                hoursLeft.textContent = 0;
                hoursRight.textContent = t.hours;
            } else {
                const leftDigit = firstDigit(t.hours);
                hoursLeft.textContent = leftDigit;
                const rightDigit = lastDigit(t.hours);
                hoursRight.textContent = rightDigit;
            }

            if(t.minutes < 10) {
                minutesLeft.textContent = 0;
                minutesRight.textContent = t.minutes;
            } else {
                const leftDigit = firstDigit(t.minutes);
                minutesLeft.textContent = leftDigit;
                const rightDigit = lastDigit(t.minutes);
                minutesRight.textContent = rightDigit;
            }

            if(t.seconds < 10) {
                secondsLeft.textContent = 0;
                secondsRight.textContent = t.seconds;
            } else {
                const leftDigit = firstDigit(t.seconds);
                secondsLeft.textContent = leftDigit;
                const rightDigit = lastDigit(t.seconds);
                secondsRight.textContent = rightDigit;
            }


            if (t.total <= 0) {
                clearInterval(timeInterval);
            }
        }

    }

    setClock(id, deadline);
}

export default timer;