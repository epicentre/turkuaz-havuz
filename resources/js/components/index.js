import Vue from 'vue';
import Card from './Card';
import Child from './Child';
import Button from './Button';
import Checkbox from './Checkbox';
import CustomerTypeElement from "./CustomerTypeElement";
import PoolRecordPrint from './PoolRecordPrint';
import {HasError, AlertError, AlertSuccess} from 'vform';

// Components that are registered globaly.
[
    Card,
    Child,
    Button,
    Checkbox,
    HasError,
    AlertError,
    AlertSuccess,
    CustomerTypeElement,
    PoolRecordPrint
].forEach(Component => {
    Vue.component(Component.name, Component);
});
