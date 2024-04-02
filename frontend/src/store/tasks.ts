import { defineStore } from 'pinia';

export const useTasksStore = defineStore('apiData1', {
    state: () => ({
        data: null,
        data_length: 0,
        loading: false,
        error: null,
    }),

    actions: {
        async fetchData() {
            try {
              this.loading = true;
      
              //const response = await fetch(import.meta.env.VITE_API_URL + '/api/tasks');
              if(localStorage.token){
                const response = await fetch(import.meta.env.VITE_API_URL + '/api/tasks', {
                  method: 'GET',
                  headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.token
                  },
                });
                const data = await response.json();

                this.data = data;
                this.data_length = data.length;
                this.error = null;
              }
      
            } catch (error: any) {
              this.error = error.message;
            } finally {
              this.loading = false;
            }
        },
    },

    getters: {
        tasks: (state) => state.data,
        tasksLength: (state) => state.data_length,
       // overviewData: (state) => state.overview_data,
        isLoading: (state) => state.loading,
        getError: (state) => state.error,
    },
});