function toggleSubmit(){
    var sbmtBtn = document.querySelectorAll('button[value="continue"]')[0]
    if (document.querySelectorAll('input[value="1"]')[0].checked){
        sbmtBtn.disabled = false
    } else {
        sbmtBtn.disabled = true
    }
}