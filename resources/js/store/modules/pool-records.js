import axios from 'axios';
import * as types from '../mutation-types';

const defaultCreateFormData = () => ({
    data : [],
    total: {
        customerCount: 0,
        totalPrice: 0
    }
});

// state
const state = {
    createFormData: defaultCreateFormData(),
    poolRecords: [],
    activePage: 1,
    searchText: '',
    paginationData : {},
    poolRecord: {},
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
    },
    poolRecords: state => state.poolRecords,
    paginationData: state => state.paginationData,
    activePage: state => state.activePage,
    searchText: state => state.searchText,
    poolRecord: state => state.poolRecord,
};

// mutations
const mutations = {
    [types.RESET_POOL_FORM_DATA](state) {
        state.createFormData = defaultCreateFormData();
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
    },

    [types.FETCH_POOL_RECORDS_SUCCESS](state, {data, page, searchText}) {
        state.poolRecords = data.data;
        state.paginationData = {...data.links, ...data.meta};
        state.activePage = page;
        state.searchText = searchText;
    },

    [types.FETCH_POOL_RECORDS_FAILURE](state) {
        state.poolRecords = [];
        state.activePage = 1;
        state.searchText = '';
    },

    [types.FETCH_RECORD_ID_SUCCESS](state, {data}) {
        state.poolRecord = data.data;
    },

    [types.FETCH_RECORD_ID_FAILURE](state) {
        state.poolRecord = {};
    },
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

    async fetchRecordFromId({commit}, payload) {
        const id = (payload && payload.hasOwnProperty('id')) ? payload.id : null;
        if (!id) {
            commit(types.FETCH_RECORD_ID_FAILURE);
            return;
        }
        try {
            const {data} = await axios.get(`/api/pool-records/${id}`);

            commit(types.FETCH_RECORD_ID_SUCCESS, {data});
        } catch (e) {
            commit(types.FETCH_RECORD_ID_FAILURE);
        }
    },

    async fetchPoolRecords({commit}, payload) {
        const page = (payload && payload.hasOwnProperty('page')) ? payload.page : 1;
        const searchText = (payload && payload.hasOwnProperty('searchText') && payload.searchText.trim() !== '') ? payload.searchText : '';
        try {
            const {data} = await axios.get(`/api/pool-records?page=${page}&searchText=${searchText}`);

            commit(types.FETCH_POOL_RECORDS_SUCCESS, {data, page, searchText});
        } catch (e) {
            commit(types.FETCH_POOL_RECORDS_FAILURE);
        }
    },

    async updatePoolRecord({commit}, {id}) {
        try {
            await axios.put(`/api/pool-records/${id}`);

        } catch (e) { }
    },

    async deletePoolRecord({commit}, {id}) {
        try {
            await axios.delete(`/api/pool-records/${id}`);

        } catch (e) { }
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
