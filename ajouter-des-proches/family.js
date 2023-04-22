const addPeopleBtn = document.getElementById('add-member')
const editPeopleBtn = document.getElementById
const membersDiv = document.getElementById('members')

const personBlock = `
    <div class="person">
        <span class="person-name">Personne inconnue</span>
        <div id="actions">
            <span class="material-symbols-rounded edit" onclick="editPersonBlock(this)">edit</span>
            <span class="material-symbols-rounded delete" onclick="removePersonBlock(this)">delete_forever</span>
        </div>
    </div>
`

function addPersonBlock(){
    membersDiv.innerHTML += personBlock
}

function removePersonBlock(element){
    var currentBlock = element.parentElement.parentElement
    currentBlock.remove()
}

function editPersonBlock(element){
    const everything = document.getElementsByTagName('*')
    for (let i = 0; i < everything.length; i++) {
        if (!(everything[i].hasAttribute('unblur'))) {
            everything[i].classList.add('blurred')
        }
    }
    document.getElementById('member-info-form').classList.remove('hidden')
}

addPeopleBtn.addEventListener('doubleclick', function(){addPersonBlock()})
editPeopleBtn.addEventListener('doubleclick', function(){editPersonBlock()})