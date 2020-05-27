<template>
    <div style="display: none;">
        <div id="printMe">
            <h1 class="centered">Turkuaz Havuz</h1>
            <p>
                <b>Tarih:</b> {{ printData.created_at }}
                <br><br>
                <b>Fiş No:</b> {{ printData.voucher_no }}
            </p>
            <table>
                <thead>
                    <tr>
                        <th>Müşteri</th>
                        <th class="centered">Adet</th>
                        <th>Fiyat</th>
                    </tr>
                </thead>
                <tbody>
                <tr v-for="detail in printData.detail">
                    <td>{{ detail.customer_type && detail.customer_type.name }}</td>
                    <td class="centered">{{ detail.quantity }}</td>
                    <td>{{ detail.price }} TL</td>
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Toplam</td>
                        <td class="centered">{{ printData.customer_count }}</td>
                        <td>{{ printData.total_price }} TL</td>
                    </tr>
                </tfoot>
            </table>
            <p class="centered">
                Teşekkürler
            </p>
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
