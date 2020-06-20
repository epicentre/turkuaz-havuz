import Vue from 'vue';
import store from './store';
import router from './router';
import i18n from './plugins/i18n';
import App from './components/App';
import {VUE_HTML_TO_PAPER_OPTIONS} from './config';
import VueHtmlToPaper from 'vue-html-to-paper';
import VueNumberInput from '@chenfengyuan/vue-number-input';


Vue.use(VueHtmlToPaper, VUE_HTML_TO_PAPER_OPTIONS);
Vue.use(VueNumberInput);

import './plugins';
import './components';

Vue.config.productionTip = false;

new Vue({
    i18n,
    store,
    router,
    ...App
});
