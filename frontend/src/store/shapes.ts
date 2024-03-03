import { defineStore } from 'pinia';

export const useShapesStore = defineStore('apiData', {
  state: () => ({
    data: null,
    data_length: 0,
    loading: false,
    error: null,
    overview_data: null,
  }),

  actions: {
    async fetchData() {
      try {
        this.loading = true;

        const response = await fetch(import.meta.env.VITE_API_URL + '/api/shapes');
        const data = await response.json();

        this.data = data;
        this.data_length = data.length;
        this.error = null;
      } catch (error: any) {
        this.error = error.message;
      } finally {
        this.loading = false;
      }
    },
    async fetchOverviewData() {
      try {
        
        if(localStorage.token){
          const response = await fetch(import.meta.env.VITE_API_URL + '/api/overview', {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
              'Authorization': 'Bearer ' + localStorage.token
            },
          });
          const data = await response.json();
  
          this.overview_data = data;
        }

        // this.error = null;
      } catch (error: any) {
        this.error = error.message;
      }
    },
  },

  getters: {
    shapes: (state) => state.data,
    shapesLength: (state) => state.data_length,
    overviewData: (state) => state.overview_data,
    isLoading: (state) => state.loading,
    getError: (state) => state.error,
  },
});
