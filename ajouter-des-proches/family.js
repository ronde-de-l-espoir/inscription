const addPeopleBtn = document.getElementById('add-member')
// const editPeopleBtn = document.getElementById
const membersDiv = document.getElementById('members')
const memberInfoForm = document.getElementById('member-info-form')
const lnameInput = document.getElementsByName('lname')[0]
const ageInput = document.getElementsByName('age')[0]
const fnameInput = document.getElementsByName('fname')[0]
let memberID = ''

async function checkIDExists(ID) {
    try {
        const response = await fetch('./checkIfIDExists.php', {
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

function addPersonBlock(){
    memberID = createID();
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
    return 0
}

function getValues(memberID) {
    var memberPos = Object.values(info.table).findIndex(subObj => subObj.id === memberID);
    if (memberPos === -1){
        return ['', '', '']
    } else {
        return [info.table[memberPos].lname, info.table[memberPos].fname, info.table[memberPos].age]
    }
}

function closeMemberForm() {
    memberInfoForm.classList.add('hidden')
    memberInfoForm.removeAttribute('for')
    document.getElementsByName('lname')[0].value = ""
    document.getElementsByName('fname')[0].value = ""
    document.getElementsByName('age')[0].value = ""
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
        removePerson(memberID)
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
        }
    });
}

function hideErrors() {
    document.getElementsByName('lname')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
    document.getElementsByName('fname')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
    document.getElementsByName('age')[0].parentNode.getElementsByTagName('p')[0].innerHTML = ''
}

function validateMemberForm() {
    var lname = lnameInput.value
    var fname = fnameInput.value
    var age = ageInput.value
    var errors = []
    if (!(/^[a-zA-Z\-\s]+$/.test(lname))) {
        errors.push('lname')
    }
    if (!(/^[a-zA-Z\-\s]+$/).test(fname)) {
        errors.push('fname')
    }
    if (!(/^(0?[1-9]|[1-9][0-9]|[1][1-9][1-9]|200)$/.test(age))){
        errors.push('age')
    }
    if (errors.length === 0){
        memberID = memberInfoForm.getAttribute('for')
        var memberPos = Object.values(info.table).findIndex(subObj => subObj.member === memberID);
        if (memberPos === -1){
            var memberData = {
                'id': memberID,
                'lname': lname,
                'fname': fname,
                'age': age
            }
            info.table.push(memberData)
        } else {
            info.table[memberPos] = {
                'id': memberID,
                'lname': lname,
                'fname': fname,
                'age': age
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