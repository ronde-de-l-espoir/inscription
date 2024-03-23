// inits all the variables conatining references to useful DOM elements

const addPeopleBtn = document.getElementById('add-member')
const membersDiv = document.getElementById('members')
const memberInfoForm = document.getElementById('member-info-form')
const lnameInput = document.getElementsByName('lname')[0]
const ageInputs = document.querySelectorAll('input[name="age"]');
const fnameInput = document.getElementsByName('fname')[0]
const emailInput = document.getElementsByName('email')[0]
const phoneInput = document.getElementsByName('phone')[0]

let memberID = ''

async function checkIDExists(ID) {
    try {
        const response = await fetch('../modules/checkIfIDExists.php', {
            method: "POST",
            headers: {'Content-Type': 'text/plain'},
            body: ID
        });
        // sends a POST request to the server with ID as body
        // this checks if the ID is already in the db

        if (response.status === 205) {
            // 205 means unique, non-existing
            return false;
        } else if (response.status === 405) {
            // 405 means existing
            return true;
        } else {
            console.error("Unexpected response from server");
            return false;
        }
    } catch (error) {
        console.error(error);
        return false;
    }
}

function createID(){
    return new Promise(async (resolve) => {
        while (true) {
            let ID = (Math.floor(Math.random() * 1000000000)).toString(); // creates a random number
            ID = "0".repeat(9 - ID.length) + ID; // pads it to 9 digits with 0s

            const exists = await checkIDExists(ID);

            if (!exists) {
                resolve(ID);
                break;
            }
        }
    });
}

async function addPersonBlock(){
    memberID = await createID(); // creates an ID for this new person
    const personBlock = `
    <div class="person" id="${memberID}">
        <span class="person-name">Personne inconnue</span>
        <div id="actions">
            <span class="material-symbols-rounded edit" onclick="editPerson('${memberID}')">edit</span>
            <span class="material-symbols-rounded delete" onclick="removePerson('${memberID}')">delete_forever</span>
        </div>
    </div>
    `
    membersDiv.innerHTML += personBlock // adds this html to the membersDiv element
    editPerson(memberID) // fires the person-editing
}

function removePerson(memberID){
    try {
        var memberPos = Object.values(info.table).findIndex(subObj => subObj.member === memberID); // finds the index of the person with id property = memberID within the info table
        info.table.splice(memberPos, 1) // removes the person (using its  index)
        delete info.table[memberPos] // extra thing needed to delete completely
    } finally {
        document.getElementById(memberID).remove() // remove the block in the membersDiv
    }
}

function editPerson(memberID){
    const everything = document.getElementsByTagName('*')
    for (let i = 0; i < everything.length; i++) {
        if (!(everything[i].hasAttribute('unblur'))) {
            everything[i].classList.add('blurred') // blurrs everything on page except the elemnts with the unblur attribute
        }
    }
    memberInfoForm.classList.remove('hidden') // shows the memberInfoForm
    memberInfoForm.setAttribute('for', memberID) // its attribute for's use has been changed : it stores the member's ID
    document.getElementsByName('lname')[0].value = getValues(memberID)[0]
    document.getElementsByName('fname')[0].value = getValues(memberID)[1]
    ageInputs.forEach(ageInput => {
        if (getValues(memberID)[2] == ageInput.value){
            ageInput.checked = true
        }
    });
    document.getElementsByName('email')[0].value = getValues(memberID)[3]
    document.getElementsByName('phone')[0].value = getValues(memberID)[4]
    // sets all the inputs' values in the form to be equally to some data returned by getValues()
    return 0
}

function getValues(memberID) {
    var memberPos = Object.values(info.table).findIndex(subObj => subObj.id === memberID); // tries to find the position of the subobject where the id = memberID
    if (memberPos === -1){
        // if it doesn't exist
        // this is the case of a new person the user is adding
        return ['', '', '', '', '']
    } else {
        // this is the case of an existing person the user is editing
        return [info.table[memberPos].lname, info.table[memberPos].fname, info.table[memberPos].age, info.table[memberPos].email, info.table[memberPos].phone]
    }
}

function closeMemberForm() {
    memberInfoForm.classList.add('hidden') // hides the form
    memberInfoForm.removeAttribute('for')
    // empties all the inputs
    document.getElementsByName('lname')[0].value = ""
    document.getElementsByName('fname')[0].value = ""
    ageInputs.forEach(ageInput => {
        if (ageInput.checked){
            ageInput.checked = false
        }
    });
    document.getElementsByName('email')[0].value = ""
    document.getElementsByName('phone')[0].value = ""
    hideErrors()
    const everything = document.getElementsByTagName('*')
    for (let i = 0; i < everything.length; i++) {
        if (!(everything[i].hasAttribute('unblur'))) {
            everything[i].classList.remove('blurred')
        }
    }
    // unblur everything that was blurred, which means everything without the unblur attribute
}

function cancelMemberForm() {
    memberID = memberInfoForm.getAttribute('for')
    if (getValues(memberID)[0] == ''){
        // if the values are empty, completely remove the div in membersDiv
        document.getElementById(memberID).remove()
    }
    closeMemberForm() // then run closeMemberFormm()
}

function showErrors(errors){
    errors.forEach(errorRegion => {
        // errorRegion is the current element
        if (errorRegion == 'lname'){
            document.getElementsByName('lname')[0].parentNode.getElementsByTagName('p')[0].innerHTML = 'Nom invalide'
        } else if (errorRegion == 'fname'){
            document.getElementsByName('fname')[0].parentNode.getElementsByTagName('p')[0].innerHTML = 'Prénom invalide'
        } else if (errorRegion == 'age'){
            ageInputs[0].parentNode.parentNode.getElementsByTagName('p')[1].innerHTML = 'Age invalide'
        } else if (errorRegion == 'email'){
            document.getElementsByName('email')[0].parentNode.getElementsByTagName('p')[0].innerHTML = 'Email invalide'
        } else if (errorRegion == 'phone'){
            document.getElementsByName('phone')[0].parentNode.getElementsByTagName('p')[0].innerHTML = 'Téléphone invalide'
        }
        // all these above set the errors under the inputs
    });
}

function hideErrors() {
    // empties all the error p
    document.getElementsByName('lname')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
    document.getElementsByName('fname')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
    ageInputs[0].parentNode.parentNode.getElementsByClassName('error-text')[0].innerHTML = ''
    document.getElementsByName('email')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
    document.getElementsByName('phone')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
}

function validateMemberForm() {
    var lname = lnameInput.value
    var fname = fnameInput.value
    var age = (function () {
        var selectedAge = null;
        ageInputs.forEach(ageInput => {
            if (ageInput.checked) {
                selectedAge = ageInput.value;
            }
        });
        return selectedAge;
    })();
    var email = emailInput.value
    var phone = phoneInput.value
    // collects all the values in the form
    var errors = [] // inits an empty errors array
    // for all the following, it tests the values agaibst some regex; if one doesn't match, it keeps in the errors array the name of the input where the error occured
    if (!(/^[a-zA-Z\-\s]+$/.test(lname))) {
        errors.push('lname')
    }
    if (!(/^[a-zA-Z\-\s]+$/).test(fname)) {
        errors.push('fname')
    }
    if (!(/^(major)|(minor)$/.test(age))){
        errors.push('age')
    }
    if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))){
        errors.push('email')
    }
    if (!(/^(0|(\+33[\s]?([0]?|[(0)]{3}?)))[1-9]([-. ]?[0-9]{2}){4}$/.test(phone))){
        errors.push('phone')
    }
    if (errors.length === 0){
        // if there aren't any errors
        memberID = memberInfoForm.getAttribute('for')
        var memberPos = Object.values(info.table).findIndex(subObj => subObj.id === memberID); // tries to find person subobj where id = memberID
        if (memberPos === -1){
            // if nothing exists
            var memberData = { // memberData is JSON
                'id': memberID,
                'lname': lname,
                'fname': fname,
                'age': age,
                'email': email,
                'phone': phone
            }
            info.table.push(memberData) // add to table memberData
        } else {
            // if it already exists
            // (this means editing)
            info.table[memberPos] = { // change directly at the correct memberPos
                'id': memberID,
                'lname': lname,
                'fname': fname,
                'age': age,
                'email': email,
                'phone': phone
            }
        }
        document.getElementById(memberID).getElementsByClassName('person-name')[0].innerHTML = fname + " " + lname // sets the correct name in the membersDiv
        closeMemberForm()
    } else {
        // if there are some errors, show them, and do nothing else
        showErrors(errors)
    }
}

function sendData(proceed) {
    fetch('./saveMembers.php', {
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(info) // send the members table to the server using a POST request to saveMembers.php
    }).then(response => {
        if (response.status == 205){
            // 205 is a good response
            if (proceed){
                window.location = '../confirmation'
            } else if (!proceed){
                window.location = '../informations'
            }
        } else {
            setTimeout(function(){
                document.getElementById('response-error-text').innerText = "Une erreur innattendue est survenue..."
            }, 1000) // wait 1 second before showing the error message (UX effect)
        }
    }).catch(error => {
        console.error(error)
    })
}

function allowMemberFormContinue() {
    document.getElementById('member-form-continue').removeAttribute('disabled') // ungreys the continue button of the member form
}

addPeopleBtn.addEventListener('doubleclick', function(){addPersonBlock()}) // run addPersonBlock() on double-click of the addPeopleBtn