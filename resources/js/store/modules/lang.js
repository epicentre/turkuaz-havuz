import * as types from '../mutation-types';
import * as config from '../../config';

// state
const state = {
    locale: localStorage.getItem('locale') || config.DEFAULT_LOCALE,
    locales: config.LOCALES
};

// getters
const getters = {
    locale: state => state.locale,
    locales: state => state.locales
};

// mutations
const mutations = {
    [types.SET_LOCALE] (state, { locale }) {
        state.locale = locale;
    }
};

// actions
const actions = {
    setLocale ({ commit }, { locale }) {
        commit(types.SET_LOCALE, { locale });

        localStorage.setItem('locale', locale);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
