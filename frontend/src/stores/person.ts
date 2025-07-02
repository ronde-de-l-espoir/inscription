import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import { IBuyer, IEvent } from 'lml-shared'

export const usePersonStore = defineStore('person', {
  state: () => <IBuyer>({
    name: '',
    surname: '',
    birth: '',
    email: '',
    phone: '',
    attendants: 1,
    selectedEvent: {} as IEvent,
    verifiedCategories: [] as IEvent["price_categories"],
    member_id: '',
    pi_secret: '',
    booking_id: '',
    children: [],
    fullName: '',
    bestPriceCategory: {} as IEvent["price_categories"][0],
  }),
  getters: {
    fullName: (state) => `${state.name} ${state.surname}`,
    bestPriceCategory: (state) => {
      if (state.verifiedCategories.length !== 0) {
        state.verifiedCategories.sort((a, b) => a.price! - b.price!);
        return state.verifiedCategories[0];
      }
    },
  },
  actions: {},
  persist: true,
})
