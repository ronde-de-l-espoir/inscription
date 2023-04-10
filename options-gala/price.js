const totalBox = document.getElementById('total')
const siblingCheck = document.getElementsByName('withSibling')[0]

if (age < 18){
    var initialPrice = 5
} else {
    var initialPrice = 10
}

let total = initialPrice
totalBox.innerText = total

function updateTotalWithSibling() {
    if (siblingCheck.checked == true){
        total = total + 5
    } else {
        total = total - 5
    }
    console.log('yes')
    totalBox.innerText = total
}
