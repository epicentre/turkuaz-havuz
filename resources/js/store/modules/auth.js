import axios from 'axios';
import * as types from '../mutation-types';

// state
const state = {
    user: null,
    token: localStorage.getItem('token')
};

// getters
const getters = {
    user: state => state.user,
    token: state => state.token,
    check: state => state.user !== null
};

// mutations
const mutations = {
    [types.SAVE_TOKEN](state, {token, remember}) {
        state.token = token;
        localStorage.setItem('token', token);
    },

    [types.FETCH_USER_SUCCESS](state, {user}) {
        state.user = user;
    },

    [types.FETCH_USER_FAILURE](state) {
        state.token = null;
        localStorage.removeItem('token');
    },

    [types.LOGOUT](state) {
        state.user = null;
        state.token = null;

        localStorage.removeItem('token');
    },

    [types.UPDATE_USER](state, {user}) {
        state.user = user;
    }
};

// actions
const actions = {
    saveToken({commit, dispatch}, payload) {
        commit(types.SAVE_TOKEN, payload);
    },

    async fetchUser({commit}) {
        try {
            const {data} = await axios.get('/api/user');

            commit(types.FETCH_USER_SUCCESS, {user: data});
        } catch (e) {
            commit(types.FETCH_USER_FAILURE);
        }
    },

    updateUser({commit}, payload) {
        commit(types.UPDATE_USER, payload);
    },

    async logout({commit}) {
        try {
            await axios.post('/api/logout');
        } catch (e) {
        }

        commit(types.LOGOUT);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
