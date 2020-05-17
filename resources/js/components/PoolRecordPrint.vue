<template>
    <div style="display: none;">
        <div id="printMe" class="row">
            <div class="col-12">
                <h1 class="text-center">Turkuaz Havuz</h1>
                <div class="d-flex justify-content-between">
                    <p>
                        <b>Tarih:</b> {{ printData.created_at }}
                    </p>
                    <p>
                        <b>Fiş No:</b> {{ printData.voucher_no }}
                    </p>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Müşteri</th>
                            <th scope="col">Adet</th>
                            <th scope="col">Fiyat</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="detail in printData.detail" style="border-bottom: 1px solid #000;">
                            <td>{{ detail.customer_type.name }}</td>
                            <td>{{ detail.quantity }}</td>
                            <td>{{ detail.price }}₺</td>
                        </tr>
                        <tr>
                            <td>Toplam</td>
                            <td>{{ printData.customer_count }}</td>
                            <td>{{ printData.total_price }}₺</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'PoolRecordPrint',
        data() {
            return {
                output: null
            }
        },
        props: {
            printData: {
                type: Object,
                required: true
            }
        },
        methods: {
            print() {
                // Pass the element id here
                this.$htmlToPaper('printMe');
            }
        }
    }
</script>
