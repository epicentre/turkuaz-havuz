<template>
    <div>
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" @click="$router.go(-1)">Geri</button>
            </div>
            <div class="card-body">
                <h5>Fiş No: {{ poolRecord.voucher_no }}</h5>
                <table class="table table-bordered mt-2">
                    <thead>
                    <tr>
                        <th scope="col">Müşteri Tipi</th>
                        <th scope="col">Adet</th>
                        <th scope="col">Toplam Fiyat</th>
                        <th scope="col">Giriş Tarihi</th>
                        <th scope="col">Çıkış Tarihi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="data in poolRecord.detail">
                        <td scope="row">{{ data.customer_type.name }}</td>
                        <td>{{ data.quantity }}</td>
                        <td>{{ data.price }} ₺</td>
                        <td>{{ data.entry_date }}</td>
                        <td>{{ data.exit_date }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

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

        computed: mapGetters({
            poolRecord: 'poolRecords/poolRecord',
        }),

        methods: {
            ...mapActions({
                fetchRecordFromId: 'poolRecords/fetchRecordFromId',
            }),
        },

        created() {
            this.fetchRecordFromId({id: this.$route.params.id });
        },
    }
</script>
