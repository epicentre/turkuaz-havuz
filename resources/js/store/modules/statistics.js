import axios from 'axios';
import * as types from '../mutation-types';

// state
const state = {
    customerTypes: null,
    statistics: null,
};

// getters
const getters = {
    customerTypes: state => state.customerTypes,
    statistics: state => state.statistics
};

// mutations
const mutations = {
    [types.FETCH_STATISTIC_SUCCESS](state, {data}) {
        state.customerTypes = data.customer_types;
        state.statistics = data.statistics;
    },

    [types.FETCH_STATISTIC_FAILURE](state) {
        state.customerTypes = null;
        state.statistics = null;
    },
};

// actions
const actions = {
    async fetchStatistic({commit}, payload) {
        try {
            const {today} = payload;
            const {data} = await axios.get(`/api/pool-records/statistics?today=${today}`);

            commit(types.FETCH_STATISTIC_SUCCESS, {data});
        } catch (e) {
            commit(types.FETCH_STATISTIC_FAILURE);
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
