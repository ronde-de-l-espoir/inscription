const addPeopleBtn = document.getElementById('add-member')
// const editPeopleBtn = document.getElementById
const membersDiv = document.getElementById('members')
const memberInfoForm = document.getElementById('member-info-form')
const lnameInput = document.getElementsByName('lname')[0]
const ageInput = document.querySelector('input[name="age"]:checked').value;
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

        if (response.status === 205) {
            return false;
        } else if (response.status === 405) {
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
            let ID = (Math.floor(Math.random() * 1000000000)).toString();
            ID = "0".repeat(9 - ID.length) + ID;

            const exists = await checkIDExists(ID);

            if (!exists) {
                resolve(ID);
                break;
            }
        }
    });
}

async function addPersonBlock(){
    memberID = await createID();
    const personBlock = `
    <div class="person" id="${memberID}">
        <span class="person-name">Personne inconnue</span>
        <div id="actions">
            <span class="material-symbols-rounded edit" onclick="editPerson('${memberID}')">edit</span>
            <span class="material-symbols-rounded delete" onclick="removePerson('${memberID}')">delete_forever</span>
        </div>
    </div>
    `
    membersDiv.innerHTML += personBlock
    editPerson(memberID)
}

function removePerson(memberID){
    try {
        var memberPos = Object.values(info.table).findIndex(subObj => subObj.member === memberID);
        info.table.splice(memberPos, 1)
        delete info.table[memberPos]
    } finally {
        document.getElementById(memberID).remove()
    }
}

function editPerson(memberID){
    const everything = document.getElementsByTagName('*')
    for (let i = 0; i < everything.length; i++) {
        if (!(everything[i].hasAttribute('unblur'))) {
            everything[i].classList.add('blurred')
        }
    }
    memberInfoForm.classList.remove('hidden')
    memberInfoForm.setAttribute('for', memberID)
    document.getElementsByName('lname')[0].value = getValues(memberID)[0]
    document.getElementsByName('fname')[0].value = getValues(memberID)[1]
    document.getElementsByName('age')[0].value = getValues(memberID)[2]
    document.getElementsByName('email')[0].value = getValues(memberID)[3]
    document.getElementsByName('phone')[0].value = getValues(memberID)[4]
    return 0
}

function getValues(memberID) {
    var memberPos = Object.values(info.table).findIndex(subObj => subObj.id === memberID);
    if (memberPos === -1){
        return ['', '', '', '', '']
    } else {
        return [info.table[memberPos].lname, info.table[memberPos].fname, info.table[memberPos].age, info.table[memberPos].email, info.table[memberPos].phone]
    }
}

function closeMemberForm() {
    memberInfoForm.classList.add('hidden')
    memberInfoForm.removeAttribute('for')
    document.getElementsByName('lname')[0].value = ""
    document.getElementsByName('fname')[0].value = ""
    document.getElementsByName('age')[0].value = ""
    document.getElementsByName('email')[0].value = ""
    document.getElementsByName('phone')[0].value = ""
    hideErrors()
    const everything = document.getElementsByTagName('*')
    for (let i = 0; i < everything.length; i++) {
        if (!(everything[i].hasAttribute('unblur'))) {
            everything[i].classList.remove('blurred')
        }
    }
}

function cancelMemberForm() {
    memberID = memberInfoForm.getAttribute('for')
    if (getValues(memberID)[0] == ''){
        document.getElementById(memberID).remove()
    }
    closeMemberForm()
}

function showErrors(errors){
    errors.forEach(errorRegion => {
        if (errorRegion == 'lname'){
            document.getElementsByName('lname')[0].parentNode.getElementsByTagName('p')[0].innerHTML = 'Nom invalide'
        } else if (errorRegion == 'fname'){
            document.getElementsByName('fname')[0].parentNode.getElementsByTagName('p')[0].innerHTML = 'Prénom invalide'
        } else if (errorRegion == 'age'){
            document.getElementsByName('age')[0].parentNode.getElementsByTagName('p')[0].innerHTML = 'Age invalide'
        } else if (errorRegion == 'email'){
            document.getElementsByName('email')[0].parentNode.getElementsByTagName('p')[0].innerHTML = 'Email invalide'
        } else if (errorRegion == 'phone'){
            document.getElementsByName('phone')[0].parentNode.getElementsByTagName('p')[0].innerHTML = 'Téléphone invalide'
        }
    });
}

function hideErrors() {
    document.getElementsByName('lname')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
    document.getElementsByName('fname')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
    document.getElementsByName('age')[0].parentNode.parentNode.getElementsByClassName('error-text')[0].innerHTML = ''
    document.getElementsByName('email')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
    document.getElementsByName('phone')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
}

function validateMemberForm() {
    var lname = lnameInput.value
    var fname = fnameInput.value
    var age = ageInput.value
    var email = emailInput.value
    var phone = phoneInput.value
    var errors = []
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
        memberID = memberInfoForm.getAttribute('for')
        var memberPos = Object.values(info.table).findIndex(subObj => subObj.id === memberID);
        if (memberPos === -1){
            var memberData = {
                'id': memberID,
                'lname': lname,
                'fname': fname,
                'age': age,
                'email': email,
                'phone': phone
            }
            info.table.push(memberData)
        } else {
            info.table[memberPos] = {
                'id': memberID,
                'lname': lname,
                'fname': fname,
                'age': age,
                'email': email,
                'phone': phone
            }
        }
        document.getElementById(memberID).getElementsByClassName('person-name')[0].innerHTML = fname + " " + lname
        closeMemberForm()
    } else {
        showErrors(errors)
    }
}

function sendData(proceed) {
    fetch('./saveMembers.php', {
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(info)
    }).then(response => {
        if (response.status == 205){
            if (proceed){
                window.location = '../confirmation'
            } else if (!proceed){
                window.location = '../informations'
            }
        } else {
            setTimeout(function(){
                document.getElementById('response-error-text').innerText = "Une erreur innattendue est survenue..."
            }, 1000)
        }
    }).catch(error => {
        console.error(error)
    })
}

function allowMemberFormContinue() {
    document.getElementById('member-form-continue').removeAttribute('disabled')
}

addPeopleBtn.addEventListener('doubleclick', function(){addPersonBlock()})