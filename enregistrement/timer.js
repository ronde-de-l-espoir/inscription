const timerElement = document.getElementById('time')
var left = 1800
timerElement.innerText = left/60


function decreaseTimer() {
    left--
    timerElement.innerText = Math.ceil(left/60)
}

var timer = setInterval(decreaseTimer, 1000)