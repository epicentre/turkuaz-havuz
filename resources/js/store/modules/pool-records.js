import axios from 'axios';
import * as types from '../mutation-types';

// state
const state = {
    createFormData: {
        data : [],
        total: {
            customerCount: 0,
            totalPrice: 0
        }
    },
};

// getters
const getters = {
    formData: state => state.createFormData.data,
    formTotal: state => state.createFormData.total,
    formPostData: state => {
        let data = { records: [] };
        state.createFormData.data.forEach((item) => {
            data.records.push({
                customer_type_id: item.id,
                quantity: item.quantity,
                price: item.totalPrice
            });
        });

        return data;
    }
};

// mutations
const mutations = {
    [types.RESET_POOL_FORM_DATA](state) {
        state.createFormData = {
            data : [],
            total: {
                customerCount: 0,
                totalPrice: 0
            }
        };
    },

    [types.INIT_POOL_FORM_DATA](state, {customerTypes}) {
        customerTypes.forEach((item) => {
            state.createFormData.data.push({
                id: item.id,
                name: item.name,
                dbPrice: item.price,
                quantity: 0,
                totalPrice: 0
            });
        });
    },

    [types.UPDATE_POOL_FORM_DATA](state, {updatedData}) {
        let newFormTotal = {
            customerCount: 0,
            totalPrice: 0
        };
        let newFormData = state.createFormData.data.map(item => {

            if (item.id === updatedData.id) {
                if (updatedData.elem === 'quantity') {
                    updatedData.totalPrice = parseFloat(updatedData.quantity * item.dbPrice);
                }

                item = { ...item, ...updatedData };
            }

            newFormTotal.customerCount += parseInt(item.quantity);
            newFormTotal.totalPrice += parseFloat(item.totalPrice);

            return item;
        });

        state.createFormData = {data: newFormData, total: newFormTotal};
    }
};

// actions
const actions = {
    createForm({commit, dispatch}, payload) {
        const customerTypes = payload.customerTypes;

        dispatch('resetCreateFormData');
        commit(types.INIT_POOL_FORM_DATA, {customerTypes});
    },

    updateFormData({commit}, payload) {
        const updatedData = payload.updatedData;

        commit(types.UPDATE_POOL_FORM_DATA, {updatedData});
    },

    resetCreateFormData({commit}) {
        commit(types.RESET_POOL_FORM_DATA);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
