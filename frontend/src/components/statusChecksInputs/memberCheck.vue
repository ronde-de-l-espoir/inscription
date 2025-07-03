<script setup lang="ts">
import { IClientPerson, IEvent } from 'lml-shared';
import { onBeforeMount, ref } from 'vue';
const personObject = defineModel<IClientPerson>({required: true})
const props = defineProps<{categories: IEvent['price_categories']}>();
const person = personObject.value
const memberInvalid = ref<Boolean | undefined>(undefined);

function checkMember(member_id: string) {
    if (!member_id) {
        memberInvalid.value = undefined;
        person.verifiedCategories = person.verifiedCategories.filter(category => category.type !== 'member');
        return;
    }
    fetch('/api/member/' + member_id)
        .then(response => {
            if (!response.ok) {
                memberInvalid.value = true;
                person.verifiedCategories = person.verifiedCategories.filter(category => category.type !== 'member');
            } else {
                memberInvalid.value = false;
                if (!person.verifiedCategories.find((category) => category.type == 'member')) {
                    person.verifiedCategories.push(props.categories.find((category) => category.type == 'member')!);
                }
            }
        }).catch(error => {
            console.error(error)
            memberInvalid.value = true;
        })
}

onBeforeMount(() => {
    if (person.member_id !== "") {
        checkMember(person.member_id);
    }
});

</script>

<template>
    <input type="number" v-model="person.member_id" min="0" max="999999"
        @input="checkMember(person.member_id.toString())"
        :class="{ validated: memberInvalid==false, invalidated: memberInvalid }"
    />

</template>

<style lang="css" scoped>
input {
    font-family: 'Lexend', sans-serif;
    font-size: 120%;
    padding: 5px;
    border: 2px solid #d9dadd;
    border-radius: 5px;
    background-color: #2c7ba8;
    color: white;
    outline: none;
    width: 20%;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input.validated {
    border-width: 3px;
    border-color: #00d30b;
}

input.invalidated {
    border-color: #be131c;
}
</style>