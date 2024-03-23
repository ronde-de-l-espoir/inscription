/**
 * BEWARE
 * You are entering a zone of utter simplicity !
 * The only elementary JS script in the entire repo
 */


const timerElement = document.getElementById('time')
var left = 1800 // again, should be a variable (see ./index.php)

function updateTimer() {
    timerElement.innerText = Math.ceil(left/60) // rounds up to the minute
}


function decreaseTimer() {
    left--
    updateTimer()
}

updateTimer()
var timer = setInterval(decreaseTimer, 1000)