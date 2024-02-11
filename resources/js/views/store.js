// store/index.js
import Vue from 'vue';
import Vuex from 'vuex';

// Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: null,
        authError: null,
        processing: false
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setAuthError(state, error) {
            state.authError = error;
        },
        setProcessing(state, processing) {
            state.processing = processing;
        }
    },
    actions: {
        async login({ commit }, { email, password }) {
            commit('setProcessing', true);
            try {
                const response = await axios.post('/api/login', { email, password });
                if (response.data.status === true && response.data.access_token) {
                    const token = response.data.access_token;
                    localStorage.setItem('user', JSON.stringify({ token }));
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                    commit('setUser', { token });
                    commit('setAuthError', null);
                    // Redirect handled outside of Vuex
                } else {
                    commit('setAuthError', response.data.error || 'Authentication failed.');
                }
            } catch (error) {
                // Handle errors
                console.error('Error during login:', error);
                commit('setAuthError', 'Error during login. Please try again.');
            } finally {
                commit('setProcessing', false);
            }
        }
        // You can define other actions for logout, token refresh, etc.
    }
});