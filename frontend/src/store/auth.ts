import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: '',
  }),
  actions: {
    setAuthToken(token: string) {
      this.token = token
    },
    isAuthenticated() {
      return this.token !== ''
    },
    removeAuthToken() {
      this.token = ''
    }
  },
  getters: {
    authToken: (state) => state.token
  },
});
