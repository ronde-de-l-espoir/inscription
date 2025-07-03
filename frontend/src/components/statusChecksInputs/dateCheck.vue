<script setup lang="ts">
import { IClientPerson, IEvent } from 'lml-shared';
import { onBeforeMount, ref } from 'vue';
const personObject = defineModel<IClientPerson>({ required: true })
const props = defineProps<{ categories: IEvent['price_categories'] }>();
const person = personObject.value

function dateCheck(birth: string) {
    const birthDate = new Date(birth);
    const age = new Date(Date.now() - birthDate.getTime()).getUTCFullYear() - 1970;
    if (age < 18) {
        if (!person.verifiedCategories.find((category) => category.type == 'minor')) {
            person.verifiedCategories.push(props.categories.find((category) => category.type == 'minor')!);
        }
    } else {
        person.verifiedCategories = person.verifiedCategories.filter(category => category.type !== 'minor');
    }
}

onBeforeMount(() => {
    if (person.birth !== '') {
        dateCheck(person.birth as string);
    }
});

</script>

<template>
    <input type="date" v-model="person.birth" @input="dateCheck(person.birth as string)" />
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
}

input::-webkit-calendar-picker-indicator {
    filter: invert(1);
}
</style>