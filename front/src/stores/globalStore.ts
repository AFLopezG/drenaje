import { defineStore } from 'pinia'

export const globalStore = defineStore('global', {
  state: () => ({
    counter: 0,
    user: {},
    isLoggedIn: !!localStorage.getItem('tokenDrenaje'),

    booluser: false,
    boolver:false,
    boolreg:false,
    boolmodat:false,
    boolmodtub:false,

    }),
  getters: {
    doubleCount: (state) => state.counter * 2
  },
  actions: {
    increment () {
      this.counter++
    }
  }
})
