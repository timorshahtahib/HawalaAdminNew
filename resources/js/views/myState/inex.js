// store/index.js
import { createStore } from 'vuex';

const store = createStore({
    state: {
        customers: [] // Initial empty array
    },
    mutations: {
        ADD_CUSTOMER(state, customer) {
            state.customers.push(customer);
        }
    },
    actions: {
        addCustomer({ commit }, customer) {
            // Simulate API call to add customer
            // Once added, commit mutation to update state
            commit('ADD_CUSTOMER', customer);
        }
    },
    getters: {
        getCustomers: state => state.customers
    }
});

export default store;