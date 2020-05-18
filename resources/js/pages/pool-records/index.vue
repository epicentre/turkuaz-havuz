<template>
    <div>
        <card :title="cardTitle">
            <div class="d-flex justify-content-between mb-2">
                <div class="pagination align-items-center">
                    <button class="btn btn-primary mr-2" @click="fetchPoolRecords({page: activePage - 1 })" :disabled="paginationData.current_page === 1">
                        Geri
                    </button>
                    <span>Sayfa {{paginationData.current_page}} - {{paginationData.last_page}}</span>
                    <button class="btn btn-primary ml-2" @click="fetchPoolRecords({page: activePage + 1 })" :disabled="paginationData.current_page === paginationData.last_page">
                        İleri
                    </button>
                </div>
                <div class="form-inline">
                    <div class="form-group">
                        <label>Fiş No</label>
                        <input type="text" class="form-control mx-sm-3" v-model="localSearchText" v-on:keyup.enter="fetchPoolRecords({page: 1, searchText: localSearchText })">
                    </div>
                    <button type="button" class="btn btn-primary" @click="fetchPoolRecords({page: 1, searchText: localSearchText })">Ara</button>
                    <button type="button" class="btn btn-danger ml-2" @click="resetSearchText">Sıfırla</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Fiş No</th>
                        <th scope="col">Kişi Sayısı</th>
                        <th scope="col">Toplam Fiyat</th>
                        <th scope="col">Gün</th>
                        <th scope="col" style="width: 200px;">Görüntüle</th>
                        <th scope="col" style="width: 200px;">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="poolRecord in poolRecords">
                        <td scope="row">{{ poolRecord.voucher_no }}</td>
                        <td>{{ poolRecord.customer_count }}</td>
                        <td>{{ poolRecord.total_price }} ₺</td>
                        <td>{{ poolRecord.day }}</td>
                        <td>
                            <router-link :to="{name: 'poolRecordShow', params: {id: poolRecord.id}}" class="btn btn-primary">Görüntüle</router-link>
                            <button type="button" class="btn btn-success" @click="localPrint(poolRecord.id)">
                                <fa icon="print" />
                                Yazdır
                            </button>
                        </td>
                        <td>
                            <button v-if="poolRecord.status === 0" class="btn btn-warning" @click="localUpdatePoolRecord(poolRecord.id)">Çıkış Yap</button>
                            <button class="btn btn-danger" @click="showDeleteModal(poolRecord)">Sil</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </card>

        <!-- Delete Modal -->
        <div class="modal fade" id="poolRecordDeleteModal" tabindex="-1" role="dialog" aria-labelledby="poolRecordDeleteModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="poolRecordDeleteModalTitle">Silme İşlemi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Havuz kaydını silmek istediğine emin misin?
                        <b>Bu işlem geri alınamaz!!</b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                        <button type="button" class="btn btn-danger" @click="confirmDelete">Sil</button>
                    </div>
                </div>
            </div>
        </div>

        <pool-record-print ref="print" :print-data="printData" />
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        middleware: 'auth',
        scrollToTop: false,

        metaInfo() {
            return {title: 'Havuz Kayıtları'}
        },

        data: () => ({
            cardTitle: 'Havuz Kayıtları',
            activePoolRecord: null,
            localSearchText: ''
        }),

        computed: mapGetters({
            poolRecords: 'poolRecords/poolRecords',
            activePage: 'poolRecords/activePage',
            searchText: 'poolRecords/searchText',
            paginationData: 'poolRecords/paginationData',
            printData: 'poolRecords/poolRecord'
        }),

        methods: {
            ...mapActions({
                fetchPoolRecords: 'poolRecords/fetchPoolRecords',
                updatePoolRecord: 'poolRecords/updatePoolRecord',
                deletePoolRecord: 'poolRecords/deletePoolRecord',
            }),
            showDeleteModal(poolRecord) {
                this.activePoolRecord = poolRecord;

                jQuery('#poolRecordDeleteModal').modal('show');
            },
            confirmDelete() {
                this.deletePoolRecord({ id: this.activePoolRecord.id }).then(() => {
                    jQuery('#poolRecordDeleteModal').modal('hide');

                    this.activePoolRecord = null;
                    this.fetchPoolRecords({page: this.activePage, searchText: this.searchText });
                });
            },
            localUpdatePoolRecord(id) {
                this.updatePoolRecord({id}).then(() => {
                    this.fetchPoolRecords({page: this.activePage, searchText: this.searchText });
                });
            },
            resetSearchText() {
                this.localSearchText = '';

                this.fetchPoolRecords({page: 1 });
            },
            localPrint(poolRecordId) {
                this.$store.dispatch('poolRecords/fetchRecordFromId', {id: poolRecordId}).then(() => {
                    this.$refs.print.print();
                });
            },
        },

        created() {
            this.fetchPoolRecords();
        },
    }
</script>
