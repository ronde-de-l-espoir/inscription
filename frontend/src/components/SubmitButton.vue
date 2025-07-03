<script setup lang="ts">

import {ref} from 'vue';

const props = defineProps({
    destination: {
        type: String,
        required: true
    },
    active: {
        type: Boolean,
        default: false
    }
})

const continueButton = ref<HTMLButtonElement | null>(null);

</script>

<template>
    <RouterLink :to="props.destination">
        <button type="submit" ref="continueButton" :class="{activated: props.active}">
            Continuer
        </button>
    </RouterLink>
</template>

<style lang="css" scoped>
button[type="submit"] {
    font-family: 'Orienta', sans-serif;
    margin-top: 15px;
    font-size: 120%;
    padding: 10px;
    background-color: #474646;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: not-allowed;
}

button[type="submit"].activated {
    background-color: #45a049;
    cursor: pointer;
}

button[type="submit"].activated:hover {
    background-color: #45a049;
}
</style>