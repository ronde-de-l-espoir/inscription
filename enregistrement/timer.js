const timerElement = document.getElementById('time')
var left = 1800

function updateTimer() {
    timerElement.innerText = Math.ceil(left/60)
}


function decreaseTimer() {
    left--
    updateTimer()
}

updateTimer()
var timer = setInterval(decreaseTimer, 1000)