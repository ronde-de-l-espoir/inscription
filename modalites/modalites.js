function toggleSubmit(){
    var sbmtBtn = document.querySelectorAll('button[value="continue"]')[0] // gets the 'Next' button
    if (document.querySelectorAll('input[value="1"]')[0].checked){ // checks if the confirmation checkbox is checked
        sbmtBtn.disabled = false // enables the 'Next' button
    } else {
        sbmtBtn.disabled = true // disables the 'Next' button
    }
}