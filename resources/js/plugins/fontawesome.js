import Vue from 'vue';
import {library} from '@fortawesome/fontawesome-svg-core';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';

// import { } from '@fortawesome/free-regular-svg-icons'

import {
    faUser, faLock, faSignInAlt, faSignOutAlt, faCog, faPlus, faPrint
} from '@fortawesome/free-solid-svg-icons';

library.add(
    faUser, faLock, faSignInAlt, faSignOutAlt, faCog, faPlus, faPrint
);

Vue.component('fa', FontAwesomeIcon);
