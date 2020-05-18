<template>
    <div>
        <div class="row">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-lg btn-primary" @click="showCreateForm">
                    <fa icon="plus" />
                    Yeni Kayıt Oluştur
                </button>
            </div>
        </div>
        <div class="row mt-4 justify-content-center align-items-center">
            <div class="col-12">
                <h2 class="text-center">
                    Bugünün Sayıları
                </h2>
            </div>
            <div class="col d-flex flex-column align-items-center justify-content-center my-2">
                <h4 class="text-muted">Tümü</h4>
                <div class="circle my-2">
                    <span class="number">{{ getTotalStatistic(true) }}</span>
                </div>
                <h4 class="text-muted">Toplam: {{ getTotalStatistic(false) }}</h4>
            </div>
            <div class="col mb-4" v-for="customerType in customerTypes">
                <div class="col-12 d-flex flex-column align-items-center justify-content-center my-2">
                    <h4 class="text-muted">{{ customerType.name }}</h4>
                    <div class="circle small my-2">
                        <span class="number">{{ getStatisticFromCustomerType(customerType.id, true) }}</span>
                    </div>
                    <h4 class="text-muted">Toplam: {{ getStatisticFromCustomerType(customerType.id, false) }}</h4>
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
                        <div class="row">
                            <div class="col-4">
                                <h5>Toplam: </h5>
                            </div>
                            <div class="col-4">
                                <h5><b>{{ formTotal.customerCount }}</b></h5>
                            </div>
                            <div class="col-4">
                                <h5><b>{{ formTotal.totalPrice }}₺</b></h5>
                            </div>
                        </div>
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

<style scoped>
    .circle {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 180px;
        height: 180px;
        border-radius: 100%;
        background: transparent;
        border: 5px solid #38c172;
    }

    .circle .number {
        font-size: 4rem;
    }

    .circle.small {
        width: 130px;
        height: 130px;
        font-size: 3rem;
    }
</style>
