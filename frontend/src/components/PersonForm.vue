<script lang="ts" setup>

import { IClientPerson, IEvent } from 'lml-shared';
import MemberCheck from './statusChecksInputs/memberCheck.vue';
import DateCheck from './statusChecksInputs/dateCheck.vue';
import { onMounted } from 'vue';
const props = defineProps<{
    fields: (IEvent['info_fields'][number] | 'member' | 'birth')[];
}>();
const person = defineModel<IClientPerson>('person', {required: true});
const isValid = defineModel<boolean>('isValid', {default: false});

function validateForm(inputs: NodeListOf<Element>) {
    let allValid = true;
    inputs.forEach(input => {
        if (!input.classList.contains('valid')) {
            allValid = false;
        }
    });
    isValid.value = allValid
}

onMounted(() => {
    const inputs = document.querySelectorAll('#container input');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            var regexToTest = new RegExp('');
            switch (input.id) {
                case "phone":
                    regexToTest = /(0|(\+33[\s]?([0]?|[(0)]{3}?)))[1-9]([-. ]?[0-9]{2}){4}/;
                    break;
                case "email":
                    regexToTest = /[\w-\.]+@([\w-]+\.)+[\w-]{2,4}/
                    break;
                default:
                    regexToTest = /\p{L}/u; // For all the others
                    break;
            }
            if ((input as HTMLInputElement).value.match(regexToTest)) {
                input.classList.remove('invalid');
                input.classList.add('valid');
            } else {
                input.classList.remove('valid');
                input.classList.add('invalid');
            }
            validateForm(inputs)
        });
    });
    inputs.forEach(input => {
        input.dispatchEvent(new Event('input'));
    });
    validateForm(inputs);
})

</script>

<template>
    <div id="container">
        <div v-for="field in props.fields" :key="field">
            <label for="name" v-if="field == 'name'" :key="field">
                Prénom
                <input type="text" id="name" name="name" required v-model="person.name">
            </label>
    
            <label for="surname" v-if="field == 'surname'">
                Nom
                <input type="text" id="surname" name="surname" required v-model="person.surname">
            </label>
    
            <label for="email" v-if="field == 'email'">
                Email
                <input type="email" id="email" name="email" required v-model="person.email">
            </label>
    
            <label for="phone" v-if="field == 'phone'">
                Téléphone
                <input type="tel" id="phone" name="phone" required v-model="person.phone">
            </label>
    
            <label for="member" v-if="field == 'member'">
                Numéro d'adhérent
                <MemberCheck :categories="person.selectedEvent.price_categories" v-model="person"/>
            </label>
    
            <label for="birth" v-if="field == 'birth'">
                Date de naissance
                <DateCheck :categories="person.selectedEvent.price_categories" v-model="person"/>
            </label>
        </div>
    </div>
</template>

<style scoped>
#container {
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: auto;
    column-gap: 4vw;
    row-gap: 20px;
    grid-auto-flow: column;
    font-family: 'Orienta', sans-serif;;
}

#container:has(div:nth-child(2)) {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr;
}

#container:has(div:nth-child(3)) {
    grid-template-columns: 1fr 1fr;
    grid-auto-flow: row;
}

#container label {
    font-weight: bold;
}

#container input {
    margin-top: 5px;
    display: block;
    padding: 10px;
    border: 2px solid #0050a4;
    border-radius: 5px;
}

#container input:focus {
    outline: none;
}

#container input.valid {
    border-color: #5de15d;
}

#container input.invalid {
    border-color: #e62727;
}
</style>