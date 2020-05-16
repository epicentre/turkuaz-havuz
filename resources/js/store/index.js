import Vue from 'vue';
import Vuex from 'vuex';

import auth from './modules/auth';
import lang from './modules/lang';
import statistics from "./modules/statistics";
import customerTypes from "./modules/customer-types";
import poolRecords from "./modules/pool-records";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        lang,
        statistics,
        customerTypes,
        poolRecords
    }
})
