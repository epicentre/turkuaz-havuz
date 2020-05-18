<template>
    <div>
        <div class="row">
            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary" @click="showCreateForm">Yeni Kayıt Oluştur</button>
            </div>
            <div class="col-md-12">
                <h4 class="mt-5 font-weight-bold text-center">
                    Günlük Sayılar
                </h4>
            </div>
        </div>
        <div class="row mt-3 pt-3" style="background-color: #eeeeee">
            <div class="col">
                <div class="card-group">
                    <div class="card mb-4" v-for="customerType in customerTypes">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h4 class="card-title">{{ customerType.name }}</h4>
                            <p>
                                Aktif
                                <br>
                                <span class="ml-2" style="font-size: 30px;">{{ getStatisticFromCustomerType(customerType.id, true) }}</span>
                            <p>
                                Toplam
                                <br>
                                <span class="ml-2" style="font-size: 30px;">{{ getStatisticFromCustomerType(customerType.id, false) }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Toplam</h4>
                            <p>
                                Aktif
                                <br>
                                <span class="ml-2" style="font-size: 30px;">{{ getTotalStatistic(true) }}</span>
                            <p>
                                Toplam
                                <br>
                                <span class="ml-2" style="font-size: 30px;">{{ getTotalStatistic(false) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addPoolRecordModal" tabindex="-1" role="dialog" aria-labelledby="addPoolRecordModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPoolRecordModalTitle">Yeni Kayıt Oluştur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <customer-type-element v-for="data in formData" :key="data.id" :initial-data="data" />
                        <p>
                            Toplam Kişi Sayısı: <b>{{ formTotal.customerCount }}</b>
                            <br>
                            Toplam Tutar: <b>{{ formTotal.totalPrice }}₺</b>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                        <button type="button" class="btn btn-primary" @click="postForm" :disabled="hasPrintedData">Oluştur</button>
                        <button type="button" class="btn btn-success" @click="localPrint" v-if="hasPrintedData">Yazdır</button>
                    </div>
                </div>
            </div>
        </div>

        <pool-record-print ref="print" :print-data="printData" />
    </div>
</template>

<script>
    import axios from 'axios';
    import { mapGetters, mapActions } from 'vuex';
    import CustomerTypeElement from "../components/CustomerTypeElement";

    export default {
        middleware: 'auth',
        metaInfo() {
            return {title: this.$t('home')}
        },
        data: () => ({
            hasPrintedData: false
        }),
        computed: {
            ...mapGetters({
                customerTypes: 'statistics/customerTypes',
                statistics: 'statistics/statistics',
                formData: 'poolRecords/formData',
                formTotal: 'poolRecords/formTotal',
                printData: 'poolRecords/poolRecord',
            })
        },
        methods: {
            getStatisticFromCustomerType(customerTypeId, active = false) {
                let key = `type_${customerTypeId}${active ? '_active' : ''}_total`;
                return this.statistics && this.statistics.hasOwnProperty(key) ? this.statistics[key] : 0;
            },
            getTotalStatistic(active = false) {
                let key = `${active ? 'active_' : ''}total`;
                return this.statistics && this.statistics.hasOwnProperty(key) ? this.statistics[key] : 0;
            },
            showCreateForm() {
                this.hasPrintedData = false;

                this.$store.dispatch('poolRecords/createForm', {customerTypes: this.customerTypes});

                $('#addPoolRecordModal').modal('show');
            },
            postForm() {
                const formPostData = this.$store.getters['poolRecords/formPostData'];

                axios.post('/api/pool-records', formPostData).then(response => {
                    this.hasPrintedData = true;
                    this.$store.dispatch('poolRecords/fetchRecordFromId', {id: response.data.data.id});

                    this['statistics/fetchStatistic']({ today: true });
                }).catch(error => {
                    console.error(error);
                });
            },
            localPrint() {
                this.$refs.print.print();
            },
            ...mapActions([
                'statistics/fetchStatistic'
            ])
        },
        mounted() {
            this['statistics/fetchStatistic']({ today: true });
        }
    }
</script>
