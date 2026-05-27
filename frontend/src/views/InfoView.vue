<script setup lang="ts">

import '@fontsource/krona-one';
import '@fontsource/orienta';
import { usePersonStore } from '@/stores/person';
var buyer = usePersonStore();
import { ref } from 'vue';
import PersonForm from '@/components/PersonForm.vue';
import SubmitButton from '@/components/SubmitButton.vue';

const priceCat = ref(buyer.bestPriceCategory)
const validForm = ref(false);

</script>

<template>
  <div id="info-wrapper">
    <h2 :class="{ onlytitle: buyer.member_id == '' }">Informations personnelles</h2>
    <PersonForm :person="buyer" :fields="buyer.selectedEvent.info_fields" @update:is-valid="(isValid) => {validForm = isValid}"/>
    <h4 id="category-sentence">Vous êtes en catégorie "{{ priceCat.display }}" ({{ priceCat.price }} €)</h4>
    <SubmitButton :destination="'/paiement'" :active="validForm"/>
  </div>
</template>

<style scoped>
  #info-wrapper {
    padding: 20px 40px;
    border-radius: 25px;
    color: white;
    background-color: #2c7ba8;
    border: 2px solid #1d338f;

    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    align-items: center;
  }

  h2 {
    font-family: 'Krona One', sans-serif;
    text-align: center;
    margin-bottom: 5px;
  }

  h2.onlytitle {
    margin-bottom: 20px;
  }

  h4 {
    font-family: 'Orienta', sans-serif;
    text-align: center;
  }

  h4#member-data {
    margin-bottom: 20px;
    margin-top: 0px;
  }

  #info-wrapper p {
    font-size: 110%;
    font-family: 'Orienta', sans-serif;
    margin-top: 15px;
  }
</style>
