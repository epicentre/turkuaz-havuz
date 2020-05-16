import Vue from 'vue';
import Vuex from 'vuex';

import auth from './modules/auth';
import lang from './modules/lang';
import statistics from "./modules/statistics";
import customerTypes from "./modules/customer-types";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        lang,
        statistics,
        customerTypes
    }
})
