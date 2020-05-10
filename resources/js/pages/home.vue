<template>
    <div>
        <div class="row">
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
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        middleware: 'auth',
        metaInfo() {
            return {title: this.$t('home')}
        },
        computed: {
            ...mapGetters({
                customerTypes: 'statistics/customerTypes',
                statistics: 'statistics/statistics'
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
            ...mapActions([
                'statistics/fetchStatistic'
            ])
        },
        mounted() {
            this['statistics/fetchStatistic']({ today: true });
        }
    }
</script>
