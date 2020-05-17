<template>
    <div>
        <card :title="cardTitle">
            <div class="d-flex justify-content-between mb-2">
                <div class="pagination align-items-center">
                    <button class="btn btn-primary mr-2" @click="fetchStatistic({page: page - 1 })" :disabled="statistics.current_page === 1">
                        Geri
                    </button>
                    <span>Sayfa {{statistics.current_page}} - {{statistics.last_page}}</span>
                    <button class="btn btn-primary ml-2" @click="fetchStatistic({page: page + 1 })" :disabled="statistics.current_page === statistics.last_page">
                        İleri
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Gün</th>
                        <th scope="col" v-for="customerType in customerTypes">{{ customerType.name }}</th>
                        <th scope="col">Toplam</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="data in statistics.data">
                        <td scope="row">{{ data.day }}</td>
                        <td scope="row" v-for="customerType in customerTypes">
                            {{ data['type_' + customerType.id + '_total'] }}
                        </td>
                        <td scope="row">{{ data.total }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </card>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        middleware: 'auth',
        scrollToTop: false,

        metaInfo() {
            return {title: 'İstatistikler'}
        },

        data: () => ({
            cardTitle: 'İstatistikler',
            page: 1,
        }),

        computed: mapGetters({
            customerTypes: 'statistics/customerTypes',
            statistics: 'statistics/statistics',
        }),

        methods: {
            ...mapActions({
                fetchStatistic: 'statistics/fetchStatistic',
            })
        },

        created() {
            this.fetchStatistic({page: this.page});
        },
    }
</script>
