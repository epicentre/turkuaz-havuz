import axios from 'axios';
import * as types from '../mutation-types';

// state
const state = {
    customerTypes: null,
};

// getters
const getters = {
    customerTypes: state => state.customerTypes
};

// mutations
const mutations = {
    [types.FETCH_CUSTOMER_TYPE_SUCCESS](state, {data}) {
        state.customerTypes = data.data;
    },

    [types.FETCH_CUSTOMER_TYPE_FAILURE](state) {
        state.customerTypes = null;
    },
};

// actions
const actions = {
    async fetchCustomerTypes({commit}, payload) {
        try {
            const {data} = await axios.get('/api/customer-types');

            commit(types.FETCH_CUSTOMER_TYPE_SUCCESS, {data});
        } catch (e) {
            commit(types.FETCH_CUSTOMER_TYPE_FAILURE);
        }
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
