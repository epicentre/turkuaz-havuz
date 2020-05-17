import axios from 'axios';
import * as types from '../mutation-types';

// state
const state = {
    customerTypes: {},
    statistics: {},
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
        state.customerTypes = {};
        state.statistics = {};
    },
};

// actions
const actions = {
    async fetchStatistic({commit}, payload) {
        try {
            const page = (payload && payload.hasOwnProperty('page')) ? payload.page : 1;
            const today = (payload && payload.hasOwnProperty('today')) ? payload.today : false;
            const {data} = await axios.get(`/api/pool-records/statistics?today=${today}&page=${page}`);

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
